<?php

namespace App\Observers;

use App\Models\Brand;

class BransObserve
{
    /**
     * Handle the brand "created" event.
     *
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    public function created(Brand $brand)
    {
        //
    }

    /**
     * Handle the brand "updated" event.
     *
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    public function updated(Brand $brand)
    {
        //
    }

    /**
     * Handle the brand "deleted" event.
     *
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    public function deleted(Brand $brand)
    {
        $brand -> brand_tarnaslation()-> delete ();
		delete_file('site/images/'.$brand ->img);
    }

   
    public function restored(Brand $brand)
    {
        //
    }

    
    public function forceDeleted(Brand $brand)
    {
        //
    }
}
