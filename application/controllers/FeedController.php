<?php

class FeedController extends Controller
{

    CONST NB_PRODUCT_DISPLAYED = 100;

    public function index()
    {
        $user = auth_user();
        $categories = $user->followedCategories();

        $products = null;

        if (count($categories)>0){
            if (!is_array($categories)){
                $categories = [$categories];
            }

            $itemPerCategory = ceil(self::NB_PRODUCT_DISPLAYED/count($categories));

            $products = [];
            foreach ($categories as $category){
                $client = new \GuzzleHttp\Client([
                    'base_uri' => config('ebay.base_url',true),
                ]);
                $response = $client->get(config('ebay.endpoints.search',true)
                                         .'?limit='.$itemPerCategory.'&category_ids='.$category->ebay_id,[
                    'headers' => config('ebay.headers.search')
                ]);
                $body = json_decode($response->getBody());

                foreach ($body->itemSummaries as $productData){

                    // Try to find if we already have the product
                    $product = ProductModel::instantiate()->where('epid',$productData->itemId)->get();

                    if (!$product) {
                        $product = new ProductModel([
                            'epid' => $productData->itemId,
                            'title' => $productData->title,
                            'img' => isset($productData->image)?$productData->image->imageUrl:
                                (isset($productData->additionalImages)?$productData->additionalImages[0]->imageUrl:''),
                            'price' =>  $productData->price->value,
                            'subgroup' => $productData->categories[0]->categoryId
                        ]);
                        $product->save();
                    }

//                    //save categories related to the product
//                    foreach($productData->categories as $cat){
//                        $catId = $cat->categoryId;
//                        // Try to find if we already have the product
//                        $productCat = ProductCategoriesModel::instantiate()->where('product_id',$productData->itemId)
//                            ->where('category_id', $catId)->limit(1)->get();
//                        if(!$productCat){
//                            $productCat = new ProductCategoriesModel([
//                                'product_id' => $productData->itemId,
//                                'category_id' => $catId
//                            ]);
//                            $productCat->save();
//                        }
//                    }

                    array_push($products,$product);
                }
            }

        }
        if (is_array($products)) shuffle($products);

        $this->render('feed',[
            'categories' => $categories,
            'products' => $products
        ]);
    }

}