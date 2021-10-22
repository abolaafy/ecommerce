<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\subCategoryObserve;

class SubCategory extends Model
{

			protected $table = 'sub_categories';

			protected $fillable =
			[
				'parent_id' ,'translation_lang','status', 'translation_of','satus','category_id','name','slug','active' ,'img',
			];

			public function items ()
			{
				return $this -> belongsToMany (Item::class ,'item_categories'  ,'category_id' ,'item_id' ,'idhf' ,'id' ,'idhh');
			}
		public function mainCategories ()
		{
            return $this -> belongsTO ('App\Models\MainCategory', 'category_id' , 'id');
		}
        public function sub_sub_ategories ()
		{
                return $this -> hasToOne(self::class, 'parent_id' , 'id');

		}
		public function categries_translation ()
		{
				return $this -> hasMany (self::class, 'translation_of' , 'id');
		}
		public function getActive()
		{
		return  $this -> active  == 0 ?  'غير مفعل'   : 'مفعل' ;
		}

		  public function scopeActive($query)
		  {
				return $query->where('active', 1);
		  }
		  static function boot()
		  {
				parent::boot();
				SubCategory::observe(subCategoryObserve::class );
		  }


}
