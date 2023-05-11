<?php

namespace Locomotif\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogSubcategories extends Model
{
    public function category(){
        return $this->belongsTo('Locomotif\Blog\Models\BlogCategories', 'category_id');
    }
    
    public function blogs(){
        return $this->belongsToMany('Locomotif\Blog\Models\Blog', 'blog_to_subcategories');
    }
}
