<?php

class CronController extends Controller
{

    public function test()
    {
        echo 'charly is awesome';
    }

    public function daily()
    {
        header('Content-Type: application/json');
        echo $this->updateCategoryAvgGraph();
    }

    private function updateCategoryAvgGraph(){
        // Update categories top item average price
        $categories = CategoryModel::instantiate()->all()->get();

        $date = \Carbon\Carbon::now()->setTime(0,0,0,0);

        foreach ($categories as $category){

            // Search for top items and calculate average
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

            $avg = round(array_sum($productsPrice)/count($productsPrice),2);

            $stat = CategoryStatsModel::instantiate()->where('category_id', $category->id)
                                      ->where('graph_type',CategoryStatsModel::AVG_PRICE)->get();

            if(!$stat) {
                //Stat doesn't exist, we create fake history
                $stat = new CategoryStatsModel([
                    'category_id' => $category->id,
                    'graph_type' => CategoryStatsModel::AVG_PRICE,
                ]);

                $past_value = [];

                for ($i=1;$i<=44;$i++){
                    $rdm_val = randomFloat($avg*0.8,$avg*1.2);
                    $tempDate = $date->copy();
                    $past_value[$tempDate->subDays(45-$i )->setTime(0,0,0)->format('Y-m-d H:m:s')] = $rdm_val;
                }
                $past_value['Category'] = $category->id;
                $past_value[$date->format('Y-m-d H:m:s')] = $avg;
                $stat->content = json_encode($past_value);
                $stat->save();
            } else {
                //Find smallest date in array
                $content = json_decode($stat->content);

                $date = null;
                $maxDate = null;
                foreach ($content as $key=>$value){
                    if ($key == 'Category') continue;

                    if ($date == null){
                        $date = new \Carbon\Carbon($key);
                    }
                    if ($maxDate == null){
                        $maxDate = new \Carbon\Carbon($key);
                    }
                    $tempDate = new \Carbon\Carbon($key);
                    if ($tempDate->lt($date)) {
                        $date = $tempDate;
                    }
                    if ($tempDate->gt($date)) {
                        $maxDate = $tempDate;
                    }
                }

                // Now we have max and min
                if ($maxDate->format('Y-m-d')!=\Carbon\Carbon::now()->format('Y-m-d')){
                    // We only add value if last update was not today
                    unset($content->{$date->format('Y-m-d H:m:s')});
                    $content->{Carbon\Carbon::now()->setTime(0,0,0)->format('Y-m-d H:m:s')} = $avg;
                    $stat->content = json_encode($content);
                    $stat->save();
                }
            }
        }

        return json_encode(['status'=>'ok']);


    }

}