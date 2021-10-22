<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Observers\BransObserve;

class Brand extends  Model 
{
	 use Translatable;
	 
    protected $with = ['translation'];
	
	 protected $fillable = ['active','img'];
	 //protected $casts = ['active' => 'boolean'];
	 
	  public $translatedAttributes = ['name' ,'locale'];
	  
	  public function scopeActive($query)
	  {
        return $query -> where('active',1) ;
    }
    public function getActive()
	{
        return  $this -> active  == 0 ?  'غير مفعل'   : 'مفعل' ;
    } 
	public function brand_tarnaslation()
	{
        return  $this -> hasMany ('App\Models\BrandTranslation' ,'brand_id' ,'id');
    }
	static function boot()
	{
			parent::boot();
			Brand::observe(BransObserve::class );
    }
	
	
}
