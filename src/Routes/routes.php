<?php

Route::group(['middleware'=>'web'], function(){
	Route::resource('/admin/blog',              'Locomotif\Blog\Controller\BlogController');	
	Route::resource('/admin/blogCategories',    'Locomotif\Blog\Controller\BlogCategoriesController');
	Route::resource('/admin/blogSubcategories', 'Locomotif\Blog\Controller\BlogSubcategoriesController');

	Route::POST('/admin/blogCategories/addCategoriesAndSubcategories', 'Locomotif\Blog\Controller\BlogCategoriesController@addCategoriesAndSubcategories');
	
});
