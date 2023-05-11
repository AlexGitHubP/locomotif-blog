<?php

namespace Locomotif\Blog\Controller;

use Locomotif\Media\Controller\MediaController;
use Locomotif\Blog\Models\BlogSubcategories;
use Locomotif\Blog\Models\BlogCategories;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class BlogSubcategoriesController extends Controller
{
    public function __construct()
    {   
        $this->middleware('authgate');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = BlogSubcategories::with('category')->get();
        foreach ($items as $key => $value) {
            $items[$key]->status_nice = mapStatus($value->status);
        }
        return view('blogSubcategories::list')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = BlogCategories::all();
        
        return view('blogSubcategories::create')->with('parentCategories', $parentCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subcategory_name'        => 'required',
            'subcategory_url'         => 'required',
            'status'                  => 'required',
            'subcategory_description' => 'required',
            'category_id'             => 'required'
        ]);

        $blogSubcategory = new BlogSubcategories();

        
        $blogSubcategory->category_id             = $request->category_id;
        $blogSubcategory->subcategory_name        = $request->subcategory_name;
        $blogSubcategory->subcategory_url         = $request->subcategory_url;
        $blogSubcategory->subcategory_description = $request->subcategory_description;
        $blogSubcategory->ordering                = getOrdering($blogSubcategory->getTable(), 'ordering');
        $blogSubcategory->status                  = $request->status;
        
        
        $blogSubcategory->save();

        return redirect('admin/blogSubcategories/'.$blogSubcategory->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogSubcategories  $blogSubcategories
     * @return \Illuminate\Http\Response
     */
    public function show(BlogSubcategories $blogSubcategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogSubcategories  $blogSubcategories
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogSubcategories $blogSubcategory)
    {
        $item             = BlogSubcategories::with('category')->where('id', $blogSubcategory->id)->first();
        $parentCategories = BlogCategories::all();
        $associatedMedia  = app(MediaController::class)->mediaAssociations($blogSubcategory->getTable(), $blogSubcategory->id);
        
        return view('blogSubcategories::edit')->with('item', $item)->with('parentCategories', $parentCategories)->with('associatedMedia', $associatedMedia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogSubcategories  $blogSubcategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogSubcategories $blogSubcategory)
    {
        $request->validate([
            'subcategory_name'        => 'required',
            'subcategory_url'         => 'required',
            'status'                  => 'required',
            'subcategory_description' => 'required',
            'category_id'             => 'required'
        ]);

        
        $blogSubcategory->category_id             = $request->category_id;
        $blogSubcategory->subcategory_name        = $request->subcategory_name;
        $blogSubcategory->subcategory_url         = $request->subcategory_url;
        $blogSubcategory->subcategory_description = $request->subcategory_description;
        $blogSubcategory->status                  = $request->status;
        
        $blogSubcategory->save();

        return redirect('admin/blogSubcategories/'.$blogSubcategory->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogSubcategories  $blogSubcategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogSubcategories $blogSubcategories)
    {
        //
    }
}
