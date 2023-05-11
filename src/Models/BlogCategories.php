<?php

namespace Locomotif\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategories extends Model
{
    public function subcategories(){
        return $this->hasMany('Locomotif\Blog\Models\BlogSubcategories', 'category_id');
    }
    
    public function blogs(){
        return $this->belongsToMany('Locomotif\Blog\Models\Blog', 'blog_to_categories');
    }
}
