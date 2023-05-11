<?php

namespace Locomotif\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';
    
    public function categories(){
        return $this->belongsToMany('Locomotif\Blog\Models\BlogCategories', 'blog_to_categories', 'blog_id', 'category_id');
    }
    
    public function subcategories(){
        return $this->belongsToMany('Locomotif\Blog\Models\BlogCategories', 'blog_to_subcategories', 'blog_id', 'subcategory_id');
    }
}
