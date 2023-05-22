<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

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

// Route::get('/', function () {
//     return view('index');
// });



Auth::routes();


Route::get('/', 'HomeController@index');
//search-ajaxx
Route::get('/searchAjax', 'LiveSearchController@index');
Route::get('/search', 'LiveSearchController@search')->name('search');
//Tim kiem 
// Route::get('/getSearch','LiveSearchController@getSearch')->name('getSearch');
//================ADMIN ===============

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard','DashboardController@show');
    Route::get('admin/order/list','AdminOrderController@list');
    //xóa đơn hàng trang dashboard
    Route::get('/dashboard/delete/{order_id}','DashboardController@delete')->name('dashboard.delete');
    Route::get('/admin/order/delete/{order_id}','AdminOrderController@delete')->name('order.delete');
    //cập nhật đơn hàng
    Route::get('admin/order/edit/{order_id}','AdminOrderController@edit')->name('order.edit');
    Route::post('admin/order/update/{id}','AdminOrderController@update')->name('order.update');
    //chi tiết đơn hàng
    Route::get('admin/order/detail/{id}','AdminOrderController@detail')->name('order.detail');
    Route::get('admin/order/action','AdminOrderController@action');
    Route::get('admin/user/list','AdminUserController@list');

    //Thêm user
    Route::get('admin/user/add','AdminUserController@add');
    //Nơi xử lý submit form
    Route::post('admin/user/store','AdminUserController@store');
    //Xóa user trong hệ thống
    Route::get('admin/user/delete/{id}','AdminUserController@delete')->name('user.delete');
    //Thao tác trên nhiều bản ghi
    Route::get('admin/user/action','AdminUserController@action');
    //Xóa vĩnh viễn user
    Route::get('admin/user/forceDelete/{id}','AdminUserController@forceDelete')->name('user.forceDelete');
    //Cập nhật thông tin ng dùng
    Route::get('admin/user/edit/{id}','AdminUserController@edit')->name('user.edit');
    Route::get('admin/user/update/{id}','AdminUserController@update')->name('user.update');
    //================PAGE=====================
    //    Thêm trang
    Route::get('admin/page/add','AdminPageController@add');
    Route::post('admin/page/store','AdminPageController@store');
    //   Hiển thị danh sách trang
    Route::get('admin/page/list','AdminPageController@list');
    //Xóa trang
    Route::get('admin/page/delete/{id}','AdminPageController@delete')->name('page.delete');
    //Xóa vĩnh viễn trang
    Route::get('admin/page/forceDelete/{id}','AdminPageController@forceDelete')->name('page.forceDelete');
    //Chỉnh sửa thông tin của trang
    Route::get('admin/page/edit/{id}','AdminPageController@edit')->name('page.edit');
    //Thao tác trên nhiều bản ghi
    Route::get('admin/page/action/','AdminPageController@action');
    //Cập nhật thông tin trang
    Route::get('admin/page/edit/{id}','AdminPageController@edit')->name('page.edit');
    Route::post('admin/page/update/{id}','AdminPageController@update')->name('page.update');
    //================END PAGE=====================

    //=================POST===================
    //=====POST CATEGORY============
    //thêm danh mục
    Route::get('admin/post/cat/list','AdminPostCategoryController@list');
    Route::post('admin/post/cat/store','AdminPostCategoryController@store');
     //Xóa vĩnh viễn danh mục bài viết
     Route::get('admin/post/cat/delete/{id}','AdminPostCategoryController@delete')->name('PostCategory.delete');
     //Sửa thông tin danh mục
     Route::get('admin/post/cat/edit/{id}','AdminPostCategoryController@edit')->name('PostCategory.edit');
     Route::post('admin/post/cat/update/{id}','AdminPostCategoryController@update')->name('PostCategory.update');
    //=====END POST CATEGORY============

     //=======POSTS==========================
     //thêm bài viết
     Route::get('admin/post/add','AdminPostController@add');
     Route::post('admin/post/store','AdminPostController@store');
     //Hiển thị danh sách bài viết
     Route::get('admin/post/list','AdminPostController@list');
     //Xóa bài viết
     //-----Xóa tạm thời------
     Route::get('admin/post/delete/{id}','AdminPostController@delete')->name('post.delete');
     //-----Xóa vĩnh viễn
     Route::get('admin/post/forceDelete/{id}','AdminPostController@delete')->name('post.forceDelete');
     //Chỉnh sửa bài viết
     Route::get('admin/post/edit/{id}','AdminPostController@edit')->name('post.edit');
     Route::post('admin/post/update/{id}','AdminPostController@update')->name('post.update');
     //Thao tác trên nhiều bản ghi
    Route::get('admin/post/action/','AdminPostController@action');
    //=======END POSTS==========================
     
    //=============PRODUCT CATEGORY
     //thêm danh mục
     Route::get('admin/product/cat/list','AdminProductCategoryController@list');
     Route::post('admin/product/cat/store','AdminProductCategoryController@store');
      //Xóa vĩnh viễn danh mục bài viết
      Route::get('admin/product/cat/delete/{id}','AdminProductCategoryController@delete')->name('ProductCategory.delete');
      //Sửa thông tin danh mục
      Route::get('admin/product/cat/edit/{id}','AdminProductCategoryController@edit')->name('ProductCategory.edit');
      Route::post('admin/product/cat/update/{id}','AdminProductCategoryController@update')->name('ProductCategory.update');
    //=============END PRODUCT CATEGORY

    //=================PRODUCT COLOR==================
    Route::get('admin/product/color/list','AdminProductController@list_color');
    Route::post('admin/product/color/store','AdminProductController@store_color');
    Route::get('admin/product/cat/color/delete/{id}','AdminProductController@delete_color')->name('product.delete_color');

    //=================END PRODUCT COLOR==================

    //****************PRODUCT ****************
    //thêm bài viết
    Route::get('admin/product/add','AdminProductController@add');
    Route::post('admin/product/store','AdminProductController@store');
    //Hiển thị danh sách bài viết
    Route::get('admin/product/list','AdminProductController@list');
    //Xóa bài viết
    //-----Xóa tạm thời------
    Route::get('admin/product/delete/{id}','AdminProductController@delete')->name('product.delete');
    //-----Xóa vĩnh viễn
    Route::get('admin/post/forceDelete/{id}','AdminPostController@delete')->name('product.forceDelete');
    //Chỉnh sửa bài viết
    Route::get('admin/product/edit/{id}','AdminProductController@edit')->name('product.edit');
    Route::post('admin/product/update/{id}','AdminProductController@update')->name('product.update');
    //Thao tác trên nhiều bản ghi
   Route::get('admin/product/action/','AdminProductController@action');
    //****************END PRODUCT ****************






});
// ===============HOME=================
//PAGE
Route::get('page/lien-he.html','PageController@lien_he');
Route::get('page/huong-dan-mua-hang-online.html','PageController@huong_dan_mua_hang_online');
Route::get('page/canh-bao-gia-mao.html','PageController@fake_warning');
Route::get('page/quy-che-hoat-dong.html','PageController@quy_che_hoat_dong');
Route::get('page/chinh-sach-bao-hanh.html','PageController@chinh_sach_bao_hanh');
Route::get('page/chinh-sach-tra-gop.html','PageController@chinh_sach_tra_gop');
Route::get('page/cau-hoi-thuong-gap.html','PageController@cau_hoi_thuong_gap');
//POST
Route::get('bai-viet.html','PostController@show');
//chi tiết bài viết
Route::get('bai-viet/{post_slug}.html','PostController@detail')->name('posts.detail');

//PRODUCT
Route::get('danh-muc/{cat_name}','ProductController@cat')->name('cat');
Route::get('san-pham.html','ProductController@show');
//chi tiết sản phẩm
Route::get('san-pham/{product_title}.html','ProductController@detail')->name('product.detail');


//CART
Route::get('gio-hang.html','CartController@show');
//add_cart
Route::get('cart/add/{id}','CartController@add')->name('cart.add');
//remove_cart
Route::get('cart/remove/{rowId}','CartController@remove')->name('cart.remove');
//destroy_cart
Route::get('cart/destroy','CartController@destroy')->name('cart.destroy');
//update_ajax
Route::get('cart/update/','CartController@update')->name('cart.update');
//CHECKOUT
Route::get('mua-ngay/{id}','CheckoutController@buynow')->name('checkout.buynow');

Route::get('thanh-toan.html','CheckoutController@show')->name('checkout.show');
Route::post('checkout/store','CheckoutController@store');
//location
// Route::get('GetSubCatAgainstMainCatEdit/{id}', 'CheckoutController@GetSubCatAgainstMainCatEdit');
// Route::get('/GetSubCatAgainstMainCatEdit/{id}', 'CheckoutController@showCitiesInCountry');
Route::get('/select_district/{province_id}', 'CheckoutController@select_district');
Route::get('/select_ward/{district_id}', 'CheckoutController@select_ward');
//send mail
Route::get('demo/sendmail','CheckoutController@sendmail');
//checkout-done
Route::get('thanks','CheckoutController@thanks');
//search
// Route::get('search/result','ProductController@search_result');
// Route::get('/search','ProductController@search');
//test
// Route::get('search/show','SearchController@show');
// Route::get('search','SearchController@search');



Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});