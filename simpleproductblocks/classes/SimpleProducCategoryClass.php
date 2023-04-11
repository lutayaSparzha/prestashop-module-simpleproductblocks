<?php

use CategoryCore as Category;

class SimpleProducCategoryClass extends ObjectModel
{
 
  public function getCategoriesList(){

    $categories_arr = Category::getCategories();

    foreach($categories_arr as $category_arr) {
        foreach($category_arr as $key => $category_val){

            $category_list[] = [
                    'id_category' => $category_val['infos']['id_category'],
                    'category_name' => $category_val['infos']['name'],
            ]; 
        }
    }
    unset($category_list[0]);

    return $category_list;
}

}
