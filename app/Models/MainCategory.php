<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\mainCategoryObserve;

class MainCategory extends Model
{

			protected $table = 'main_categories';

			protected $fillable =
			[
				'translation_lang', 'translation_of','name','slug','active' ,'img','created_at','updated_at',
			];


			protected $hidden = [
				'password', 'remember_token',
			];
			public $timestamps = false;



			public function scopeSelectCat ($q )
			{
				return $q -> select('id' , 'translation_lang' , 'name','translation_of', 'img' ,'active','slug' ,'updated_at','created_at');
			}
		  public function scopeActive($query)
		  {
				return $query->where('active', 1);
		  }
		  public function getActive()
		 {
			return $this->active == 1 ? 'مفعل' : 'غير مفعل';

		 }
		 public function category_translation()
		 {
			return $this->hasMany (self::class , 'translation_of');

		 }
		public function vendors ()
		{
				return $this -> hasMany ('App\Models\Vendor', 'category_id' , 'id');
		}
		public function categories ()
		{
				return $this -> hasMany (self::class, 'translation_of' , 'id');
		}
		public function sub_categories ()
		{
				return $this -> hasMany ('App\Models\SubCategory', 'category_id' ,get_default_lang() =='ar'? 'id' : 'translation_of');
		}

		 static function boot()
		{
			parent::boot();
			MainCategory::observe(mainCategoryObserve::class);
		}

}



















