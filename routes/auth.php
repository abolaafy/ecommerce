<?php
use Illuminate\Support\Facades\Route;

Route::group( [   'middleware' => [ 'guest:site']] , function ()
{
    Route::group( [   'middleware' => ['Go_reset']] , function ()
    {
        Auth::routes();
        Route::group( [ 'namespace' =>'Auth' ] , function ()
          {
          Route::get('password/rest/mobile-check' ,'ResetPasswordController@verify')->name('mobile.rest.mobile.check');

        });
    });
    Route::group( [ 'namespace' =>'Auth' , 'middleware' => ['reset']] , function ()
    {
        Route::view('password/rest/code' ,'auth.passwords.confirm')->name('password.rest.code');
        Route::get('password/rest/logout' ,'ResetPasswordController@logout')->name('password.rest.logout');
        Route::get('password/rest/check-code' ,'ResetPasswordController@verifyCode')->name('password.rest.check.code');
    });
    Route::group( [ 'namespace' =>'Auth' , 'middleware' => ['change_password']] , function ()
    {
        Route::get('password/change-show' ,'ChangePasswodController@show')->name('password.change.show');
        Route::get('password/change-logout' ,'ChangePasswodController@logout')->name('password.change.logout');
        Route::post('password/change' ,'ChangePasswodController@change')->name('password.change');
    });
});

