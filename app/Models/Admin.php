<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
			use Notifiable;

			protected $table = 'admins';
            protected $guarded =[];

			protected $fillable = [
			'id' , 'name', 'email','img','password','created_at','updated_at',
			];

            public function rules ()
            {
                return $this -> BelongsTo (Rule::class,'rule_id','id');
            }
			protected $hidden = [
				'password', 'remember_token',
			];
}
