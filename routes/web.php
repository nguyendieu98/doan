<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Authenticate
Auth::routes(); 
// USER 
// Thanh toan online return 
Route::get('/return-vnpay','User\CartController@return');
// End thanh toan online
// Xu ly Login Logout CLIENTS
Route::group(array('namespace'=>'Auth'),function(){
	Route::get('/login', 'LoginController@showClientLoginForm');
	Route::post('/login', 'LoginController@clientLogin');
	Route::get('/register', 'RegisterController@showClientRegisterForm');
	Route::post('/register', 'RegisterController@createClient');
	Route::get('/logout', 'LoginController@clientLogout')->name('logout');
});
// End Authenticate
// -------------------------------------------------------------------------------
Route::group(array('namespace'=>'User'),function(){
	//View client
	Route::get('lang/{lang}','LangController@changeLang')->name('lang');
	Route::get('/','HomeController@homepage');
	Route::get('/product_sale','HomeController@product_sale');
	Route::post('/checkout','CartController@checkout');
	Route::post('/placeorder','CartController@placeorder');
	Route::resource('products','HomeController');
	Route::resource('cart','CartController');
	Route::resource('/profile','ClientController');   
	Route::get('/about','HomeController@about');
	Route::get('/order/{id}','ClientController@orderdetail');   
	Route::post('/comment','ClientController@comment');
	Route::post('/received','ClientController@received');
	Route::post('/cancelorder','ClientController@cancelOrder');
	//End view client
	// CART
	Route::patch('update-cart', 'CartController@update');
	Route::get('add-to-cart/{id}', 'CartController@addToCart');
	Route::delete('remove-from-cart', 'CartController@remove');
	// END CART
	// Change Password route
	Route::get('/changepassword', 'ClientController@showChangePassForm');
	Route::post('/changepassword','ClientController@changePassword')->name('changepassword');
	// Contact
	Route::get('/contact','HomeController@contact'); 
	Route::post('/contact','HomeController@sendContact')->name('sendcontact');
	// End Contact
}); 
// -------------------------------------------------------------------------------
// END USER
//ADMIN
Route::group(array('prefix'=>'admin','namespace'=>'Auth'),function(){
	// Xu ly Login Logut ADMIN
	Route::get('/login', 'LoginController@showAdminLoginForm');
	Route::post('/login', 'LoginController@adminLogin');
	// Admin ko co register de tam day test thu
	Route::get('/register', 'RegisterController@showAdminRegisterForm');
	Route::post('/register', 'RegisterController@createAdmin');
	Route::get('/logout', 'LoginController@adminLogout')->name('admin.logout');
});
// function ajax
Route::group(array('namespace'=>'Admin','middleware'=>'auth:admin'),function(){
	Route::get('/setvalue', 'ProductController@setvalue');
	Route::get('/getcolor', 'ProductController@getcolor');
	Route::get('/get_list_size', 'StoreController@getListSize');
	Route::get('/get_list_color', 'StoreController@getListColor');
	Route::get('/get_quantity', 'StoreController@getQuantity');
	Route::get('/get_quantity_order', 'OrderController@getQuantity');
	Route::post('/move_image', 'ProductController@moveImage');
	Route::post('/get_list_image', 'ProductController@getListImage');
	Route::post('/save_image', 'ProductController@saveImage');
	Route::post('/delete_image', 'ProductController@deleteImage');
	Route::post('/get_order_detail', 'OrderController@getOrderDetail');
	Route::post('/edit_comment', 'CommentController@editComment');
}); 
Route::get('/get_color_in_productdetail', 'User\HomeController@getListColor');
Route::get('/get_quantity_in_productdetail', 'User\HomeController@getQuantity');
//END ajax
// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------
Route::group(array('prefix'=>'admin','namespace'=>'Admin'),function(){
	Route::resource('about','AboutController'); 
	Route::resource('comment','CommentController');  
	//Start About-------------------------------------------------------------------------------------------------
	Route::get('/about',[
		'as' => 'about.index',
		'uses' => 'AboutController@index',
		'middleware' => 'checkpermission:about_list'
	]);
	Route::get('/about/create',[
		'as' => 'about.create',
		'uses' => 'AboutController@create',
		'middleware' => 'checkpermission:about_create'
	]);
	Route::post('about',[
		'as' => 'about.store',
		'uses' => 'AboutController@store',
		'middleware' => 'checkpermission:about_create'
	]);
	Route::get('/about/{about}/show',[
		'as' => 'about.show',
		'uses' => 'AboutController@show',
		'middleware' => 'checkpermission:about_list'
	]);
	Route::get('/about/{about}/edit',[
		'as' => 'about.edit',
		'uses' => 'AboutController@edit',
		'middleware' => 'checkpermission:about_edit'
	]);
	Route::put('about/{about}',[
		'as' => 'about.update',
		'uses' => 'AboutController@update',
		'middleware' => 'checkpermission:about_edit'
	]); 
	//End About--------------------------------------------------------------------------------------------------- 
	//Start Brand-------------------------------------------------------------------------------------------------
	Route::get('/brand',[
		'as' => 'brand.index',
		'uses' => 'BrandController@index',
		'middleware' => 'checkpermission:brand_list'
	]);
	Route::get('/brand/create',[
		'as' => 'brand.create',
		'uses' => 'BrandController@create',
		'middleware' => 'checkpermission:brand_create'
	]);
	Route::post('brand',[
		'as' => 'brand.store',
		'uses' => 'BrandController@store',
		'middleware' => 'checkpermission:brand_create'
	]);
	Route::get('/brand/{brand}/show',[
		'as' => 'brand.show',
		'uses' => 'BrandController@show',
		'middleware' => 'checkpermission:brand_list'
	]);
	Route::get('/brand/{brand}/edit',[
		'as' => 'brand.edit',
		'uses' => 'BrandController@edit',
		'middleware' => 'checkpermission:brand_edit'
	]);
	Route::put('brand/{brand}',[
		'as' => 'brand.update',
		'uses' => 'BrandController@update',
		'middleware' => 'checkpermission:brand_edit'
	]);
	Route::delete('brand_delete_modal',[
		'as' => 'brand_delete_modal',
		'uses' => 'BrandController@destroy',
		'middleware' => 'checkpermission:brand_delete'
	]); 
	//End Brand--------------------------------------------------------------------------------------------------- 
	//Start Category----------------------------------------------------------------------------------------------
	Route::get('/category',[
		'as' => 'category.index',
		'uses' => 'CategoryController@index',
		'middleware' => 'checkpermission:category_list'
	]);
	Route::get('/category/create',[
		'as' => 'category.create',
		'uses' => 'CategoryController@create',
		'middleware' => 'checkpermission:category_create'
	]);
	Route::post('category',[
		'as' => 'category.store',
		'uses' => 'CategoryController@store',
		'middleware' => 'checkpermission:category_create'
	]);
	Route::get('/category/{category}/show',[
		'as' => 'category.show',
		'uses' => 'CategoryController@show',
		'middleware' => 'checkpermission:category_list'
	]);
	Route::get('/category/{category}/edit',[
		'as' => 'category.edit',
		'uses' => 'CategoryController@edit',
		'middleware' => 'checkpermission:category_edit'
	]);
	Route::put('category/{category}',[
		'as' => 'category.update',
		'uses' => 'CategoryController@update',
		'middleware' => 'checkpermission:category_edit'
	]);
	Route::delete('category_delete_modal',[
		'as' => 'category_delete_modal',
		'uses' => 'CategoryController@destroy',
		'middleware' => 'checkpermission:category_delete'
	]); 
	//End Category----------------------------------------------------------------------------------------------- 
	//Start Order------------------------------------------------------------------------------------------------
	Route::get('/order',[
		'as' => 'order.index',
		'uses' => 'OrderController@index',
		'middleware' => 'checkpermission:order_list'
	]);
	Route::get('/order/create',[
		'as' => 'order.create',
		'uses' => 'OrderController@create',
		'middleware' => 'checkpermission:order_create'
	]);
	Route::post('order',[
		'as' => 'order.store',
		'uses' => 'OrderController@store',
		'middleware' => 'checkpermission:order_create'
	]);
	Route::get('/order/{order}/edit',[
		'as' => 'order.edit',
		'uses' => 'OrderController@edit',
		'middleware' => 'checkpermission:order_edit'
	]);
	Route::put('order/{order}',[
		'as' => 'order.update',
		'uses' => 'OrderController@update',
		'middleware' => 'checkpermission:order_edit'
	]); 
	//End Order------------------------------------------------------------------------------------------------- 
	//Start Orderdetail-----------------------------------------------------------------------------------------
	Route::get('/orderdetail',[
		'as' => 'orderdetail.index',
		'uses' => 'OrderDetailController@index',
		'middleware' => 'checkpermission:orderdetail_list'
	]); 
	//End Orderdetail-------------------------------------------------------------------------------------------
	//Start Product---------------------------------------------------------------------------------------------
	Route::get('/product',[
		'as' => 'product.index',
		'uses' => 'ProductController@index',
		'middleware' => 'checkpermission:product_list'
	]);
	Route::get('/product/create',[
		'as' => 'product.create',
		'uses' => 'ProductController@create',
		'middleware' => 'checkpermission:product_create'
	]);
	Route::post('product',[
		'as' => 'product.store',
		'uses' => 'ProductController@store',
		'middleware' => 'checkpermission:product_create'
	]);
	Route::get('/product/{product}/edit',[
		'as' => 'product.edit',
		'uses' => 'ProductController@edit',
		'middleware' => 'checkpermission:product_edit'
	]);
	Route::get('/product/{product}/show',[
		'as' => 'product.show',
		'uses' => 'ProductController@show',
		'middleware' => 'checkpermission:product_list'
	]);
	Route::put('product/{product}',[
		'as' => 'product.update',
		'uses' => 'ProductController@update',
		'middleware' => 'checkpermission:product_edit'
	]);
	Route::delete('product_delete_modal',[
		'as' => 'product_delete_modal',
		'uses' => 'ProductController@destroy',
		'middleware' => 'checkpermission:product_delete'
	]); 
	Route::get('/product_sale',[
		'as' => 'product_sale',
		'uses' => 'ProductController@sale',
		'middleware' => 'checkpermission:product_list'
	]);
	//End Product---------------------------------------------------------------------------------------------- 
	//Start ProductDetail--------------------------------------------------------------------------------------
	Route::get('/productdetail',[
		'as' => 'productdetail.index',
		'uses' => 'ProductDetailController@index',
		'middleware' => 'checkpermission:productdetail_list'
	]);
	Route::get('/productdetail/create',[
		'as' => 'productdetail.create',
		'uses' => 'ProductDetailController@create',
		'middleware' => 'checkpermission:productdetail_create'
	]);
	Route::post('productdetail',[
		'as' => 'productdetail.store',
		'uses' => 'ProductDetailController@store',
		'middleware' => 'checkpermission:productdetail_create'
	]);
	Route::get('/productdetail/{productdetail}/edit',[
		'as' => 'productdetail.edit',
		'uses' => 'ProductDetailController@edit',
		'middleware' => 'checkpermission:productdetail_edit'
	]);
	Route::put('productdetail/{productdetail}',[
		'as' => 'productdetail.update',
		'uses' => 'ProductDetailController@update',
		'middleware' => 'checkpermission:productdetail_edit'
	]);
	Route::delete('product_detail_delete_modal',[
		'as' => 'product_detail_delete_modal',
		'uses' => 'ProductDetailController@destroy',
		'middleware' => 'checkpermission:productdetail_delete'
	]); 
	//End ProductDetail---------------------------------------------------------------------------------------- 
	//Start Slide----------------------------------------------------------------------------------------------
	Route::get('/slide',[
		'as' => 'slide.index',
		'uses' => 'SlideController@index',
		'middleware' => 'checkpermission:slide_list'
	]);
	Route::get('/slide/create',[
		'as' => 'slide.create',
		'uses' => 'SlideController@create',
		'middleware' => 'checkpermission:slide_create'
	]);
	Route::post('slide',[
		'as' => 'slide.store',
		'uses' => 'SlideController@store',
		'middleware' => 'checkpermission:slide_create'
	]);
	Route::get('/slide/{slide}/edit',[
		'as' => 'slide.edit',
		'uses' => 'SlideController@edit',
		'middleware' => 'checkpermission:slide_edit'
	]);
	Route::put('slide/{slide}',[
		'as' => 'slide.update',
		'uses' => 'SlideController@update',
		'middleware' => 'checkpermission:slide_edit'
	]);
	Route::delete('slide_delete_modal',[
		'as' => 'slide_delete_modal',
		'uses' => 'SlideController@destroy',
		'middleware' => 'checkpermission:slide_delete'
	]); 
	//End Slide------------------------------------------------------------------------------------------------
	//Start Banner---------------------------------------------------------------------------------------------
	Route::get('banner',[
		'as' => 'banner.index',
		'uses' => 'BannerController@index',
		'middleware' => 'checkpermission:slide_list'
	]);
	Route::get('/banner/create',[
		'as' => 'banner.create',
		'uses' => 'BannerController@create',
		'middleware' => 'checkpermission:banner_create'
	]);
	Route::post('banner',[
		'as' => 'banner.store',
		'uses' => 'BannerController@store',
		'middleware' => 'checkpermission:banner_create'
	]);
	Route::get('/banner/{banner}/edit',[
		'as' => 'banner.edit',
		'uses' => 'BannerController@edit',
		'middleware' => 'checkpermission:banner_edit'
	]);
	Route::put('banner/{banner}',[
		'as' => 'banner.update',
		'uses' => 'BannerController@update',
		'middleware' => 'checkpermission:bannere_edit'
	]);
	Route::delete('banner_delete_modal',[
		'as' => 'banner_delete_modal',
		'uses' => 'BannerController@destroy',
		'middleware' => 'checkpermission:banner_delete'
	]); 
	//End Banner-----------------------------------------------------------------------------------------------

	//Start Stote----------------------------------------------------------------------------------------------
	Route::get('/store',[
		'as' => 'store.index',
		'uses' => 'StoreController@index',
		'middleware' => 'checkpermission:store_list'
	]);
	Route::get('/store/create',[
		'as' => 'store.create',
		'uses' => 'StoreController@create',
		'middleware' => 'checkpermission:store_create'
	]);
	Route::post('store',[
		'as' => 'store.store',
		'uses' => 'StoreController@store',
		'middleware' => 'checkpermission:store_create'
	]);
	Route::get('/store/{store}/edit',[
		'as' => 'store.edit',
		'uses' => 'StoreController@edit',
		'middleware' => 'checkpermission:store_edit'
	]);
	Route::put('store/{store}',[
		'as' => 'store.update',
		'uses' => 'StoreController@update',
		'middleware' => 'checkpermission:store_edit'
	]);
	Route::delete('store_delete_modal',[
		'as' => 'store_delete_modal',
		'uses' => 'StoreController@destroy',
		'middleware' => 'checkpermission:store_delete'
	]); 
	//End Stote------------------------------------------------------------------------------------------------
	//Start User-----------------------------------------------------------------------------------------------
	Route::get('/user',[
		'as' => 'user.index',
		'uses' => 'UserController@index',
		'middleware' => 'checkpermission:user_list'
	]);
	Route::get('/user/create',[
		'as' => 'user.create',
		'uses' => 'UserController@create',
		'middleware' => 'checkpermission:user_create'
	]);
	Route::post('user',[
		'as' => 'user.store',
		'uses' => 'UserController@store',
		'middleware' => 'checkpermission:user_create'
	]);
	Route::get('/user/{user}/edit',[
		'as' => 'user.edit',
		'uses' => 'UserController@edit',
		'middleware' => 'checkpermission:user_edit'
	]);
	Route::put('user/{user}',[
		'as' => 'user.update',
		'uses' => 'UserController@update',
		'middleware' => 'checkpermission:user_edit'
	]);
	Route::delete('user_delete_modal',[
		'as' => 'user_delete_modal',
		'uses' => 'UserController@destroy',
		'middleware' => 'checkpermission:user_delete'
	]); 
	//End User-------------------------------------------------------------------------------------------------
	//Start Role-----------------------------------------------------------------------------------------------
	Route::get('/role',[
		'as' => 'role.index',
		'uses' => 'RoleController@index',
		'middleware' => 'checkpermission:role_list'
	]);
	Route::get('/role/create',[
		'as' => 'role.create',
		'uses' => 'RoleController@create',
		'middleware' => 'checkpermission:role_create'
	]);
	Route::post('role',[
		'as' => 'role.store',
		'uses' => 'RoleController@store',
		'middleware' => 'checkpermission:role_create'
	]);
	Route::get('/role/{role}/edit',[
		'as' => 'role.edit',
		'uses' => 'RoleController@edit',
		'middleware' => 'checkpermission:role_edit'
	]);
	Route::put('role/{role}',[
		'as' => 'role.update',
		'uses' => 'RoleController@update',
		'middleware' => 'checkpermission:role_edit'
	]);
	Route::delete('role_delete_modal',[
		'as' => 'role_delete_modal',
		'uses' => 'RoleController@destroy',
		'middleware' => 'checkpermission:role_delete'
	]); 
	//End Role-------------------------------------------------------------------------------------------------
	//Start Statistical----------------------------------------------------------------------------------------
	Route::get('/report/byorder',[ 
		'uses' => 'ReportController@byOrder',
		'middleware' => 'checkpermission:report'
	]);
	Route::get('/report/byproduct',[ 
		'uses' => 'ReportController@byProduct',
		'middleware' => 'checkpermission:report'
	]);
	Route::get('/report/byrevenue',[ 
		'uses' => 'ReportController@index',
		'middleware' => 'checkpermission:report'
	]);
	//End Statistical------------------------------------------------------------------------------------------
	Route::get('/home', 'HomeController@index')->name('admin.home');
	Route::get('/report/chart','ReportController@chartTotalmonth');
	Route::get('/report/chart_by_year','ReportController@chartTotalYear');
	//Admin Change Password------------------------------------------------------------------------------------------
	Route::get('/changepassword', 'UserController@showAdminChangePassForm');
	Route::post('/changepassword', 'UserController@changeAdminPassword')->name('admin.changepass');
	//End Admin Change Password------------------------------------------------------------------------------------------
});
// -------------------------------------------------------------------------------
// END ADMIN
// -------------------------------------------------------------------------------

//BOT MAN
Route::match(['get', 'post'], '/botman', 'User\BotManController@handle');
