<?php

class ProductController extends Controller
{
    // Show a product page for a specific product
    public function show($id)
    {

        $product = ProductModel::instantiate()->findOrFail($id);
        $user = auth_user();

        // Store that user searched this product
        // If user visited before, increment count
        $userProduct = UserProductsModel::instantiate()
                                        ->where('user_id',$user->id)
                                        ->where('product_id',$product->id)
                                        ->limit(1)
                                        ->get();
        if (!$userProduct) {
            $userProduct = new UserProductsModel([
                    'user_id'    => $user->id,
                    'product_id' => $product->id,
                    'followed'   => false,
                    'count'      => 1
            ]);
            $userProduct->save();
        } else {
            $userProduct->count = $userProduct->count + 1;
            $userProduct->update();
        }

        // Retrieve product avg price stat if exists
        $productStatAvg = ProductStatsModel::instantiate()
                                        ->where('product_id',$product->id)
                                        ->where('graph_type',ProductStatsModel::AVG_PRICE )
                                        ->limit(1)
                                        ->get();


        // Retrieve product geo stat if exists
        $productStatGeo = ProductStatsModel::instantiate()
                                        ->where('product_id',$product->id)
                                        ->where('graph_type',ProductStatsModel::GEO_LOCATION )
                                        ->limit(1)
                                        ->get();


        // if one of stats is missing
        if (!$productStatGeo || !$productStatAvg || $product->link == null || $product->description == null) {
            $client = new \GuzzleHttp\Client([
                'base_uri' => config('ebay.base_url',true),
            ]);
            $response = $client->get(config('ebay.endpoints.get_item',true).$product->epid,[
                'headers' => config('ebay.headers.get_item')
            ]);
            $result = json_decode($response->getBody());

            // Geographic graph
            if (!$productStatGeo) {
                //get regions for which shipping is available
                $regions = [];
                foreach ( $result->shipToLocations->regionIncluded as $region ) {
                    array_push( $regions, $region->regionName );
                }

                $productStatGeo = new ProductStatsModel( [
                    'product_id' => $product->id,
                    'graph_type' => 'geo_location',
                    'content'    => json_encode( $regions )
                ] );
                $productStatGeo->save();
            }

            // Average graph
            if (!$productStatAvg && strlen($product->epid)>17) {

                $url = $result->primaryItemGroup->itemGroupHref;

                $response = $client->get($url,[
                    'headers' => config('ebay.headers.get_item')
                ]);
                $body = json_decode($response->getBody());

                $items = $body->items;
                $objects = [];
                foreach ($items as $item) {
                    array_push($objects,$item->price->value);
                }

                $productStatAvg = new ProductStatsModel([
                    'product_id' => $product->id,
                    'graph_type' => 'avg_price',
                    'content'    => json_encode($objects)
                ]);
                $productStatAvg->save();
            }

            // Product link
            if ($product->link == null) {
                $product->link = $result->itemWebUrl;
            }

            // Product link
            if ($product->description == null) {
                $product->description = $result->description;
            }

            if ($product->link == null && $product->description == null){
                $product->save();
            }
        }

        $this->render('product',[
            'product' => $product,
            'productStatAvg' =>$productStatAvg,
            'userProduct' => $userProduct,
            'productStatGeo' => $productStatGeo
        ]);

    }

    // Search a product
    public function search($search)
    {

        $this->validate( [
            'search' => 'required|string',
        ],['search'=>$search] );

        // We need to retrieve one
        $client = new \GuzzleHttp\Client([
            'base_uri' => config('ebay.base_url',true),
        ]);
        $response = $client->get(config('ebay.endpoints.search',true).'?q='.$search,[
            'headers' => config('ebay.headers.search')
        ]);
        $body = json_decode($response->getBody());

        if (!isset($body->itemSummaries)) {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error( 'Oups! We didn\'t find anything matching with the keyword "'.$search.'"...' );

            $this->redirectBack();
        }

        $productsData = $body->itemSummaries;

        $products = [];
        foreach ($productsData as $productData){

            // Try to find if we already have the product
            $product = ProductModel::instantiate()->where('epid',$productData->itemId)->limit(1)->get();

            if (!$product) {
                $product = new ProductModel([
                    'epid' => $productData->itemId,
                    'title' => $productData->title,
                    'price' => $productData->price->value,
                    'img' => isset($productData->image)?$productData->image->imageUrl:
                        (isset($productData->additionalImages)?$productData->additionalImages[0]->imageUrl:''),
                    'subgroup' => $productData->categories[0]->categoryId
                ]);
                $product->save();
            }

            array_push($products,$product);
        }

        $this->render('search',[
            'products'=>$products,
            'search' => $search
        ]);
    }

    public function favourite($id){
        $product = ProductModel::instantiate()->findOrFail($id);
        $user = auth_user();

        // Store that user searched this product
        // If user visited before, increment count
        $userProduct = UserProductsModel::instantiate()
                                        ->where('user_id',$user->id)
                                        ->where('product_id',$product->id)
                                        ->limit(1)
                                        ->get();
        if (!$userProduct){
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error( 'Oups! Something went wrong, please try again...' );

            $this->redirect('products/'.$product->id);
        }
        $userProduct->followed = !$userProduct->followed;
        $userProduct->update();

        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        if (!$userProduct->followed){
            $msg->success( 'Product removed from favourite products!' );
        } else {
            $msg->success( 'Product added as a favourite!' );
        }

        return $this->redirectBack();

    }

    /**
     * From a legacy id redirect to a product page
     */
    public function showOld($id){

        $client = new \GuzzleHttp\Client([
            'base_uri' => config('ebay.base_url',true),
        ]);
        try {
            $response = $client->get( config( 'ebay.endpoints.get_item', true ) . 'get_item_by_legacy_id' . '?legacy_item_id=' . $id, [
                'headers' => config( 'ebay.headers.get_item' )
            ] );
        } catch (\GuzzleHttp\Exception\ClientException $e){
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error( 'Unfortunately, we couldn\'t retrieve this product. It seems like there is an issue with the eBay API. Please try again later!' );
            $this->redirectBack();
        }

        $productLegacy = json_decode($response->getBody());

//        dd($productLegacy);

        // Try to find if we already have the product
        $product = ProductModel::instantiate()->where('epid',$productLegacy->itemId)->limit(1)->get();

        //create and save a product
        if (!$product) {
            $product = new ProductModel([
                'epid' => $productLegacy->itemId,
                'title' => $productLegacy->title,
                'price' => $productLegacy->price->value,
                'img' => isset($productLegacy->image)?$productLegacy->image->imageUrl:
                    (isset($productLegacy->additionalImages)?$productLegacy->additionalImages[0]->imageUrl:''),
                'subgroup' => $productLegacy->categoryId,
                'description' => $productLegacy->description
            ]);
            $product->save();
        }

        //open product page
        $this->redirect('products/'.$product->id);

    }

    /**
     * Shows the followed products
     */
    public function followed()
    {
        $user = auth_user();
        $followedProducts = $user->followedProducts();

        $categories = [];
        // Retrieve categories
        foreach ($followedProducts as $product){
            $categories[] = $product->subgroup;
        }

        $products = [];
        foreach ($categories as $category){
            // Search for top items
            $client = new \GuzzleHttp\Client([
                'base_uri' => config('ebay.legacy_base_url',true),
            ]);
            $url = config('ebay.endpoints.getMostWatchedItems',true) .
                   '&maxResults=3&categoryId='.$category.'&CONSUMER-ID='.config('ebay.client_id');

            $response = $client->get($url);
            $xmlReponse = $response->getBody()->getContents();
            $responseXml = simplexml_load_string($xmlReponse);


            foreach ($responseXml->itemRecommendations->item as $productData) {
                $price = json_decode( json_encode($productData->buyItNowPrice),true)[0];

                $product = new ProductModel([
                    'epid' => $productData->itemId,
                    'title' => $productData->title,
                    'img' => $productData->imageURL,
                    'price' => $price,
                    'subgroup' => $productData->categoryId
                ]);

                $products[] = $product;
            }
        }

        shuffle($products);


        return $this->render('followed-products',[
            'followedProducts' => $followedProducts,
            'featuredProducts' => $products
        ]);
    }
}