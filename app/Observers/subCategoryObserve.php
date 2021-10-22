<?php

namespace App\Observers;

use App\Models\SubCategory;

class subCategoryObserve
{
      public function created(SubCategory $subCategory)
    {
        $subCategory -> items () -> update (['status' => $mainCategory -> active ]);

    }


    public function updated(SubCategory $subCategory)
    {

    }


    public function deleted(SubCategory $subCategory)
    {
      $subCategory ->categryTrans ()-> delete();
	  delete_file ("site/images/".$subCategory -> img);
    }


    public function restored(SubCategory $subCategory)
    {
        //
    }


    public function forceDeleted(SubCategory $subCategory)
    {
        //
    }
}
