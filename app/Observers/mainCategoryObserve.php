<?php

namespace App\Observers;

use App\Models\MainCategory;

class mainCategoryObserve
{
    /**
     * Handle the main category "created" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function created(MainCategory $mainCategory)
    {

    }

    /**
     * Handle the main category "updated" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function updated(MainCategory $mainCategory)
    {
         $mainCategory -> vendors () -> update (['status' => $mainCategory -> active ]);
         $mainCategory -> sub_categories () -> update (['status' => $mainCategory -> active ]);
       //  $mainCategory -> category_translation () -> update (['active' =>0 ]);

     }

    /**
     * Handle the main category "deleted" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function deleted(MainCategory $mainCategory)
    {
        $mainCategory -> category_translation  () -> delete ();
		delete_file ("site/images/maincategories/".$mainCategory -> img);
    }

    /**
     * Handle the main category "restored" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function restored(MainCategory $mainCategory)
    {
        //
    }

    /**
     * Handle the main category "force deleted" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function forceDeleted(MainCategory $mainCategory)
    {
        //
    }
}
