<?php

use Illuminate\Support\Facades\Route;


Route::group( [ 'prefix' => LaravelLocalization::setLocale(),
'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]

] , function ()
{


        # public
    Route::group( [ 'namespace' =>'site'  ] , function ()
    {
        Route::get('/' ,'HomeController@index')->name('home');
        Route::get('main-category/{slug}' , 'MainCategoryController@index')->name('main_category');
        Route::get('sub-category/{slug}' , 'SubCategoryController@index')->name('sub_category');
        Route::get('product/{slug}' , 'ProductController@index')->name('product.details');
        Route::group( [ 'prefix' =>'cart'  ] , function ()
        {
            Route::get('/' ,'CartController@index')->name('cart.index');
            Route::get('/store' , 'CartController@store')->name('cart.store')->middleware('auth');
            Route::get('/store.session' , 'CartController@store_session')->name('cart.store.session');
            Route::get('/update' , 'CartController@update')->name('cart.update');
            Route::get('/delete' , 'CartController@delete')->name('cart.delete')->middleware('auth');
            Route::get('/delete-session' , 'CartController@delete_session')->name('cart.delete.session');
            Route::get('payment/{price}' ,'PaymentController@index')->name('payment')->middleware('auth');
            Route::post('payment/fatoorah' ,'PaymentController@pay_fatoorah')->name('payment.process')->middleware('auth');

        });

    });
            # shoud be Authntecated And verifieded
    Route::group( [   'namespace' =>'site' , 'middleware' => ['auth' ,'verifiedUser',]] , function ()
    {
        Route::get('/profile/{id?}' ,'ProfileController@index')->name('profile');
    });
          # shoud be   JUST Authntecated
          Route::group( [  'namespace' =>'site' , 'middleware' => ['auth' ]] , function ()
          {
              Route::get('/wishlist' ,'WishlistController@index')->name('wishlist.index');
              Route::post('wishlist/store' ,'WishlistController@store')->name('wishlist.store');
              Route::get('wishlist/destroy' ,'WishlistController@destroy')->name('wishlist.destroy');

          });
    Route::post('logout' ,'site\HomeController@logout')->name('user.logout')->middleware('auth:site');

});

