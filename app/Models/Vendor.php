<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Observers\VendorObserve;

class Vendor extends Model
{
			use Notifiable;
			
			protected $table = 'vendors';

			protected $fillable = 
			[
				'id' , 'name' ,'mobile', 'email' ,'status','active','category_id' ,'address','password','logo','updated_at','created_at',
			];
			
			public $timestamps = true;
			
			protected $hidden = [
				'category_id'
			];	
			
			public function scopeSelectVendor ($q )
			{
				return $q -> select('id' , 'logo','name' ,'status','mobile', 'email' ,'active','category_id' ,'address');
			}
		   public function scopeActive($q)
		  {
					return $q -> where('active',1);	
				//return $this->active == 1 ? 'مفعل' : 'غير مفعل';

		  }  		
		  public function category()
		  {
			return $this -> belongsTO ('App\Models\MainCategory' , 'category_id' , 'id');
		  }  		 
		  
	  
		  public function getAstateActive()
		  {
				return $this->active == 1 ? 'مفعل' : 'غير مفعل';
		  }
		  public function setPasswordAttribute($pass)
		  {
				if (!empty ($pass))
					$this -> attributes['password'] =bcrypt ($pass);
		  } 
			
		  
		 static function boot()
		{
			parent::boot();
			Vendor::observe(VendorObserve::class);
		}
		
	  
}















