<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'StoryController@index')->name('index');

Route::prefix('admin')->middleware('auth')->group(function(){
	// menampilkan semua informasi mengenai (jumlah tulisan, dibaca, like) dan lainnya
	Route::get('dashboard', 'AdminController@index')->name('admin.index');
	// menu untuk menambahkan tulisan baru 

	Route::get('new', 'AdminController@new')->name('admin.new');
	// menerima request untuk menyimpan tulisan baru
	Route::post('save', 'AdminController@save')->name('admin.save');

	// menampilkan semua tulisan setiap anggota
	Route::get('all', 'AdminController@all')->name('admin.all');
	// menu untuk melakukan edit tulisan
	Route::get('edit/{story:id}', 'AdminController@edit')->name('admin.edit');
	// menerima request untuk update tulisan
	Route::patch('edit/{story:id}', 'AdminController@update');

	// hapus sebuah tulisan
	Route::delete('delete', 'AdminController@delete')->name('admin.delete');

	// menampilkan profile pengguna
	Route::get('profile', 'AdminController@profile')->name('admin.profile');
	// menyimpan profile pengguna
	Route::post('profile/save', 'AdminController@save_profile')->name('admin.profile.save');

	Route::get('settings', 'AdminController@settings')->name('admin.settings');
});


Route::get('/search', 'StoryController@search')->name('stories.search');
Route::prefix('stories')->group(function(){
	Route::get('{story:slug}', 'StoryController@show')->name('stories.show');
	Route::get('genre/{category:slug}', 'StoryController@indexByCategory')->name('stories.category');
	Route::get('type/{type}', 'StoryController@indexByType')->name('stories.type');
	Route::post('like', 'StoryController@like')->name('stories.like');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
