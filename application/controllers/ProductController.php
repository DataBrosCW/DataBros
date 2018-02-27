<?php

class ProductController extends Controller
{
    public function show()
    {
        $this->render('product');
    }

    public function search()
    {
        $this->validate( [
            'search' => 'required|string',
        ] );

        $search = $_POST['search'];

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
                    'description' => '...',
                    'price' =>  $productData->price->value,
                ]);
            }

            array_push($products,$product);
        }

        $this->render('search',[
            'products'=>$products,
            'search' => $search
        ]);
    }
}