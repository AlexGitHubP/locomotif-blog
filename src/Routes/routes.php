<?php

Route::group(['middleware'=>'web'], function(){
	Route::resource('/admin/blog',              'Locomotif\Blog\Controller\BlogController');	
	Route::resource('/admin/blogCategories',    'Locomotif\Blog\Controller\BlogCategoriesController');
	// Route::resource('/admin/blogSubcategories', 'Locomotif\blog\Controller\BlogSubcategoriesController');
});
