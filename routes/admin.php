<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

define('PAGINATION_COUNT',10);
	 	################ 	panel Admin ######################



Route::group(['namespace' => 'Admin', 'prefix' =>LaravelLocalization::setLocale(),'middleware' =>[  'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function () {
    Route::group( [ 'prefix' =>'Dashboard' , 'middleware' => 'auth:admin'] , function ()
    {
	Route::get('/', 'dashboardController@dashboard')->name('admin.dashboard');
	Route::get('/logout', 'dashboardController@logout')->name('admin.logout');
			######## Begin Languages Route #########

	Route::group(['prefix' => 'languages',], function ()
	{
			Route::get('/', 'languagesController@index')->name('admin.languages');
			 Route::get('create','LanguagesController@create') -> name('admin.languages.create');
			Route::post('store','LanguagesController@store') -> name('admin.languages.store');
			Route::get('edit/{id?}','LanguagesController@edit') -> name('admin.languages.edit');
			Route::post('update/{id}','LanguagesController@update') -> name('admin.languages.update');
			Route::get('delete/{id}','LanguagesController@delete') -> name('admin.languages.delete');
					// addos to prives
			Route::get('change_state_lang/{id}','LanguagesController@change_state_lang') -> name('admin.change.state.lang');
	});
			######## End Languages Route #########

			######## Begin maincategories Route #########change_state_lang

	Route::group(['prefix' => 'main_categories','middleware'=>'can:'], function ()
	{
			Route::get('/', 'mainCategoryController@index')->name('admin.maincategories');
			 Route::get('create','mainCategoryController@create') -> name('admin.maincategories.create');
			Route::post('store','mainCategoryController@store') -> name('admin.maincategories.store');
			Route::get('edit/{id?}','mainCategoryController@edit') -> name('admin.maincategories.edit');
			Route::post('update/{id}','mainCategoryController@update') -> name('admin.maincategories.update');
			Route::get('delete/{id}','mainCategoryController@delete') -> name('admin.maincategories.delete');
					// addos to prives
			Route::get('change_state_cat/{id}/{value?}','mainCategoryController@change_state_cat') -> name('admin.change.state.cat');
	});
	######## End maincategories Route #########

	######## Begin maincategories Route #########change_state_lang

	Route::group(['prefix' => 'sub_categories','middleware'=>'can:categories'], function ()
	{
			Route::get('/', 'subcategoriesController@index')->name('admin.subcategories');
			 Route::get('create','subcategoriesController@create') -> name('admin.subcategories.create');
			Route::post('store','subcategoriesController@store') -> name('admin.subcategories.store');
			Route::get('edit/{id?}','subcategoriesController@edit') -> name('admin.subcategories.edit');
			Route::post('update/{id}','subcategoriesController@update') -> name('admin.subcategories.update');
			Route::get('delete/{id}','subcategoriesController@delete') -> name('admin.subcategories.delete');
					// addos to prives
			Route::get('change_state_cat/{id}/{value?}','subcategoriesController@change_state_cat') -> name('admin.change.state.cat');
            Route::get('get-categories' ,'subcategoriesController@getCategories') -> name('admin.subcategories.get.categories');

    });
	######## End maincategories Route #########
	######## Begin vendors Route #########change_state_lang

	Route::group(['prefix' => 'vendors','middleware'=>'can:categories'], function ()
	{
			Route::get('/', 'vendorsController@index')->name('admin.vendors');
			 Route::get('create','vendorsController@create') -> name('admin.vendors.create');
			Route::post('store','vendorsController@store') -> name('admin.vendors.store');
			Route::get('edit/{id?}','vendorsController@edit') -> name('admin.vendors.edit');
			Route::post('update/{id}','vendorsController@update') -> name('admin.vendors.update');
			Route::get('delete/{id}','vendorsController@destroy') -> name('admin.vendors.delete');
					// addos to prives
			Route::get('change_active/{id}/{value?}','vendorsController@change_active') -> name('admin.change.state.cat');
	});
	######## End maincategories Route #########

		######## Begin vendors Route #########change_state_lang

	Route::group(['prefix' => 'protucts','middleware'=>'can:items'], function ()
	{
			Route::get('/', 'itemsController@index')->name('admin.items');

			Route::get('general-information-create','itemsController@create') -> name('admin.items.general.create');
			Route::post('general-information-store','itemsController@store') -> name('admin.items.general.store');
			Route::post('general-information-store-translation','itemsController@save_translation') -> name('admin.items.general.store.translation');
            Route::get('general-information-edit/{id}','itemsController@edit') -> name('admin.items.general.edit');
            Route::post('general/information-update','itemsController@update') -> name('admin.items.general.update');

            Route::get('general-delete/{id}','itemsController@delete') -> name('admin.items.delete');

			Route::get('stock-create/{id}','itemsController@create_stock') -> name('admin.items.stock.create');
			Route::post('stock-store','itemsController@store_stock') -> name('admin.items.stock.store');

			Route::get('offer-add/{id}','itemsController@add_offer') -> name('admin.items.offer.add');
			Route::post('offer-save','itemsController@offer_save') -> name('admin.items.offer.save');
			Route::post('offer-store-translation','itemsController@stor_offer_translation') -> name('admin.items.offer.store.translation');

			Route::get('images-add/{id}','itemsController@add_images') -> name('admin.items.images.add');
			Route::post('images/save-direction','itemsController@save_images_direction') -> name('admin.items.images.save.direction');
			Route::post('images/save-database','itemsController@save_images_database') -> name('admin.items.images.save.database');
			Route::get('image/delete','itemsController@delete_image') -> name('admin.items.images.delete');
            Route::get('images/delete-direction','itemsController@delete_images_direction') -> name('admin.items.images.delete.direction');


			Route::get('delete/{id}','itemsController@destroy') -> name('admin.items.delete');
					// addos to prives
			//Route::get('change_active/{id}/{value?}','itemsController@change_active') -> name('admin.change.state.items');
			Route::get('change-active-offer/{item_id}/{offer_id}/{value?}','itemsController@change_active_offer') -> name('admin.change.state.items.offer');
			Route::get('deleted-offer/{item_id}/{offer_id}','itemsController@deleted_offer') -> name('admin.items.offer.deleted');
	});
	######## End maincategories Route #########

	######## Begin vendors Route #########change_state_lang

	Route::group(['prefix' => 'offers',], function ()
	{

			Route::get('/','OffersController@index') -> name('admin.offers');

			Route::get('create','OffersController@create') -> name('admin.offers.create');
			Route::post('store','OffersController@store') -> name('admin.offers.store');
			Route::post('store-translation','OffersController@stor_translation') -> name('admin.offers.store.translation');

		Route::get('change-active/{id}','OffersController@change_active') -> name('admin.offers.change.active');


	});
	######## End maincategories Route #########
	######## Begin Attributes Route #########change_state_lang

	Route::group(['prefix' => 'Attributes','middleware'=>'can:Attributes'], function ()
	{

			Route::get('/','AttributesController@index') -> name('admin.attributes');

			Route::get('create','AttributesController@create') -> name('admin.attributes.create');
			Route::post('store','AttributesController@store') -> name('admin.attributes.store');
			Route::get('edit/{id?}','AttributesController@edit') -> name('admin.attributes.edit');
			Route::post('update/{id}','AttributesController@update') -> name('admin.attributes.update');
			Route::get('delete/{id}','AttributesController@destroy') -> name('admin.attributes.delete');

			Route::get('change-active/{id}','AttributesController@change_active') -> name('admin.attributes.change.active');
				######## Begin options Route #########
			Route::group(['prefix' => 'options','middleware'=>'can:options'], function ()
			{

				Route::get('/{id}','ItemOptionsController@index') -> name('admin.attributes.options');

				Route::get('create/{item_id}','ItemOptionsController@create') -> name('admin.attributes.options.create');
				Route::post('store','ItemOptionsController@store') -> name('admin.attributes.options.store');
				Route::get('edit/{option_id}','ItemOptionsController@edit') -> name('admin.attributes.options.edit');
				Route::post('update/{id}','ItemOptionsController@update') -> name('admin.attributes.options.update');
				Route::get('delete/{id}','ItemOptionsController@destroy') -> name('admin.attributes.options.delete');

				Route::get('change-active/{id}','ItemOptionsController@change_active') -> name('admin.attributes.change.active');

			});

	});
	######## End Attributes Route #########
		######## Begin vendors Route #########change_state_lang

	Route::group(['prefix' => 'brands','middleware'=>'can:brands'], function ()
	{
			Route::get('/', 'brandsController@index')->name('admin.brands');
			 Route::get('create','brandsController@create') -> name('admin.brands.create');
			Route::post('store','brandsController@store') -> name('admin.brands.store');
			Route::get('edit/{id?}','brandsController@edit') -> name('admin.brands.edit');
			Route::post('update/{id}','brandsController@update') -> name('admin.brands.update');
			Route::get('delete/{id}','brandsController@destroy') -> name('admin.brands.delete');
					// addos to prives
			Route::get('change_active/{id}/{value?}','brandsController@change_active') -> name('admin.change.state.brends');
	});
	######## End maincategories Route #########

	######## Begin vendors Route #########change_state_lang

	Route::group(['prefix' => 'sliders','middleware'=>'can:sliders'], function ()
	{
			Route::get('/', 'SliderController@index')->name('admin.sliders');
			 Route::get('create/images','SliderController@create') -> name('admin.sliders.images.create');
			Route::post('store/images-folder','SliderController@storeFolder') -> name('admin.sliders.images.store.folder');
			Route::post('save/images-db','SliderController@saveImgpathDB') -> name('admin.sliders.images.save.db');
			Route::get('delete/{id}','SliderController@destroy') -> name('admin.sliders.delete');
					// addos to prives
	});
	######## End maincategories Route #########
	######## Begin Rule Route #########change_state_lang

	Route::group(['prefix' => 'rules',], function ()
	{
			Route::get('/', 'RuleController@index')->name('admin.rules');
			Route::get('create','RuleController@create') -> name('admin.rules.create');
			Route::get('store','RuleController@store') -> name('admin.rules.store');
			Route::get('edit/{id}','RuleController@edit') -> name('admin.rules.edit');
			Route::post('update/{id}','RuleController@update') -> name('admin.rules.update');
			Route::get('delete/{id}','RuleController@delete') -> name('admin.rules.delete');
					// addos to prives
	});
	######## End maincategories Route #########
	######## Begin Rule Route #########change_state_lang

	Route::group(['prefix' => 'users','middleware'=>'can:users'], function ()
	{
			Route::get('/', 'RuleUsersController@index')->name('admin.users');
			Route::get('create','RuleController@create') -> name('admin.users.create');

					// addos to prives
	});
	######## End maincategories Route #########

});
});

################ 	Auth Admin ######################

Route::group(['namespace' => 'Admin','prefix' =>'Dashboard', 'middleware' => 'guest:admin'], function () {

	Route::get('login', 'LoginController@getLogin')->name('get.admin.login');
	Route::post('login', 'LoginController@login')->name('admin.login');


});


