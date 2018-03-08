<?php

class CategoriesController extends Controller
{
    /**
     * All categories
     */
    public function index()
    {
        $categories = CategoryModel::instantiate()->all()->get();
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
    public function show()
    {
        $this->render('category');
    }

}