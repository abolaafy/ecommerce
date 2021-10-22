<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function verifidCode ()
    {
        return $this -> hasToMany(App\Models\Users_verification::class , 'user_id' , 'id');
    }
    public function wishlist ()
    {
        return $this -> BelongsToMany (Item::class, 'wishlists','user_id','item_id')->withTimestamps();
    }
   
    public function carts ()
    {
        return $this -> BelongsToMany (Item::class, 'carts','user_id','item_id');
    }
    public function wishlistIsset ($item_id)
    {
        return $this -> wishlist ()-> where('item_id', $item_id) ->exists();
    }
    public function cartIsset ($item_id)
    {
        return $this -> carts ()-> where('item_id', $item_id) ->exists();
    }

}
