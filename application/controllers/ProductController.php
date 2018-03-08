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

        // Retrieve product stat if exists
        $productStat = ProductStatsModel::instantiate()
                                        ->where('product_id',$product->id)
                                        ->where('graph_type',ProductStatsModel::AVG_PRICE )
                                        ->limit(1)
                                        ->get();

        // If it has a link to group
        if (strlen($product->epid)>17 && !$productStat){
            $client = new \GuzzleHttp\Client([
                'base_uri' => config('ebay.base_url',true),
            ]);
            $response = $client->get(config('ebay.endpoints.get_item',true).$product->epid,[
                'headers' => config('ebay.headers.get_item')
            ]);
            $result = json_decode($response->getBody());
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

            $productStat = new ProductStatsModel([
                'product_id' => $product->id,
                'graph_type' => 'avg_price',
                'content'    => json_encode($objects)
            ]);
            $productStat->save();
        }

        $this->render('product',[
            'product' => $product,
            'productStat' =>$productStat,
            'userProduct' => $userProduct
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
            $msg->error( 'Oups! We didn\'t find anythind matching with the keyword "'.$search.'"...' );

            $this->redirectBack();
        }

//        TODO: add link to product + currency

        $productsData = $body->itemSummaries;

        $products = [];
        foreach ($productsData as $productData){

            // Try to find if we already have the product
            $product = ProductModel::instantiate()->where('epid',$productData->itemId)->limit(1)->get();

            if (!$product) {
                $product = new ProductModel([
                    'epid' => $productData->itemId,
                    'title' => $productData->title,
                    'img' => isset($productData->image)?$productData->image->imageUrl:
                        (isset($productData->additionalImages)?$productData->additionalImages[0]->imageUrl:''),
                    'price' =>  $productData->price->value,
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
            $msg->error( 'Oups! We didn\'t find anythind matching with the keyword "'.$search.'"...' );

            $this->redirect();
        }
        $userProduct->followed = !$userProduct->followed;
        $userProduct->update();

        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        if (!$userProduct->followed){
            $msg->success( 'Product added as a favourite!' );
        } else {
            $msg->success( 'Product removed from favourite products!' );
        }

        return $this->redirect('products/'.$product->id);

    }

    /**
     * Shows the followed products
     */
    public function followed()
    {
        return $this->render('followed-products');
    }
}