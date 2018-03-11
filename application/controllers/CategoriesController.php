<?php

class CategoriesController extends Controller
{
    /**
     * All categories
     */
    public function index()
    {
        $categories = CategoryModel::instantiate()->all()->get();
        $user = auth_user();

        if (count($categories)==0){
            return $this->redirect('categories/update');
        }

        $this->render('categories',['categories'=>$categories]);
    }

    /**
     * Update categories
     */
    public function update()
    {
        $xml2 = ('<?xml version="1.0" encoding="utf-8"?>
                <GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                  <CategorySiteID>0</CategorySiteID>
                  <DetailLevel>ReturnAll</DetailLevel>
                  <LevelLimit>1</LevelLimit>
                </GetCategoriesRequest>');

        $client = new \GuzzleHttp\Client([
                'base_uri' => config('ebay.base_url',true),
        ]);
        $response = $client->post(config('ebay.endpoints.categories_update',true),[
            'headers' => config('ebay.headers.categories_update'),
            \GuzzleHttp\RequestOptions::BODY => $xml2,
            \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => '10000',
            \GuzzleHttp\RequestOptions::TIMEOUT => '10000'
        ]);

       $xmlReponse = $response->getBody()->getContents();
       $responseXml = simplexml_load_string($xmlReponse);

       foreach ($responseXml->CategoryArray->Category as  $category){

           $categoryExistingModel = CategoryModel::instantiate()->where('ebay_id',$category->CategoryID)->limit(1)->get();
           if (!$categoryExistingModel ){
               $categoryModel = new CategoryModel([
                   'name' => $category->CategoryName,
                   'ebay_id' => $category->CategoryID,
               ]);
               $categoryModel->save();
           }

       }

        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg->success( 'Categories updated!' );

        return $this->redirect('categories');

    }

    /**
     * Display a specific one
     */
    public function show($id)
    {
        $category = CategoryModel::instantiate()->findOrFail($id);
        $user = auth_user();

        $userCategory = $category->stats();
        if (!$userCategory) {
            $userCategory = new UserCategoriesModel([
                'user_id'    => $user->id,
                'category_id' => $category->id,
                'followed'   => false,
                'count'      => 1
            ]);
            $userCategory->save();
        } else {
            $userCategory->count = $userCategory->count + 1;
            $userCategory->update();
        }

        $this->render('category',[
            'category' => $category,
            'userCategory' => $userCategory
        ]);
    }

    /**
     * Mark a category as favourite
     */
    public function favourite($id){
        $category = CategoryModel::instantiate()->findOrFail($id);
        $user = auth_user();

        // Store that user searched this product
        // If user visited before, increment count
        $userCategory = $category->stats();

        if (!$userCategory){
            $userCategory = new UserCategoriesModel([
                'user_id'    => $user->id,
                'category_id' => $category->id,
                'followed'   => (bool) false,
                'count'      => 0
            ]);
            $userCategory->save();
        }
        $userCategory->followed = !$userCategory->followed;
        $userCategory->update();

        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        if (!$userCategory->followed){
            $msg->success( 'Category removed from favourites categories!' );
        } else {
            $msg->success( 'Category added to favourites categories!' );
        }

        return $this->redirectBack();

    }

    /**
     * Update a specific category top item average price
     */
    public function updateCategory($id){
        $category = CategoryModel::instantiate()->findOrFail($id);

        $client = new \GuzzleHttp\Client([
            'base_uri' => config('ebay.base_url',true),
        ]);
        $url = config('ebay.endpoints.get_merchandised',true) .
               '?metric_name=BEST_SELLING&category_id='.$category->ebay_id.'&limit=6';
        $response = $client->get($url,[
            'headers' => config('ebay.headers.get_merchandised')
        ]);

        dd($response->getBody());
    }

}