<?php

class CronController extends Controller
{

    public function test()
    {
        echo 'charly is awesome';
    }

    public function daily()
    {
        // Update categories top item average price
        $categories = CategoryModel::instantiate()->all()->get();

        foreach ($categories as $category){

            // Search for top items
            $client = new \GuzzleHttp\Client([
                'base_uri' => config('ebay.legacy_base_url',true),
            ]);
            $url = config('ebay.endpoints.getMostWatchedItems',true) .
                   '&maxResults=6&categoryId='.$category->ebay_id.'&CONSUMER-ID='.config('ebay.client_id');

            $response = $client->get($url);
            $xmlReponse = $response->getBody()->getContents();
            $responseXml = simplexml_load_string($xmlReponse);

            $productsPrice = [];

            foreach ($responseXml->itemRecommendations->item as $productData) {
                $price = json_decode( json_encode($productData->buyItNowPrice),true)[0];
                array_push($productsPrice,$price);
            }

            $avg = array_sum($productsPrice)/count($productsPrice);

            $stat = CategoryStatsModel::instantiate()->where('category_id', $category->id)
                ->where('graph_type',CategoryStatsModel::AVG_PRICE)->get();

            if(!$stat) {
                $stat = new CategoryStatsModel([
                   'category_id' => $category->id,
                   'graph_type' => CategoryStatsModel::AVG_PRICE,
                   'content' => '',
                ]);
            }
        }
    }

}