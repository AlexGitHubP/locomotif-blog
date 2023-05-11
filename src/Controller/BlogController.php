<?php

namespace Locomotif\Blog\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Locomotif\Blog\Models\Blog;
use Locomotif\Media\Controller\MediaController;
use Locomotif\Blog\Controller\BlogCategoriesController;

class BlogController extends Controller
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
        $blog = Blog::with('categories', 'subcategories')->orderBy('ordering', 'desc')->get();
        foreach ($blog as $key => $value) {
            $blog[$key]->status_nice = mapStatus($value->status);
        }
        //echo '<pre>';print_r($blog);exit;
        return view('blog::list')->with('items', $blog);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog::create');
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
            'name' => 'required',
            'url'  => 'required',
            'status'=>'required'
        ]);
        
        $blog = new Blog();

        $blog->name              = $request->name;
        $blog->url               = $request->url;
        $blog->description       = $request->description;
        $blog->short_description = $request->short_description;
        $blog->ordering          = getOrdering($blog->getTable(), 'ordering');
        $blog->status            = $request->status;
        
        
        $blog->save();

        return redirect('admin/blog/'.$blog->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $associatedMedia      = app(MediaController::class)->mediaAssociations($blog->getTable(), $blog->id);
        $associatedCategories = app(BlogCategoriesController::class)->getCategAndSubcateg($blog->id);
        return view('blog::edit')->with('item', $blog)->with('associatedMedia', $associatedMedia)->with('associatedCategories', $associatedCategories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        
        $request->validate([
            'name' => 'required',
            'url'  => 'required',
            'status' => 'required',
        ]);

        $blog->name              = $request->name;
        $blog->url               = $request->url;
        $blog->description       = $request->description;
        $blog->short_description = $request->short_description;
        $blog->status            = $request->status;
        
        $blog->save();

        return redirect('admin/blog/'.$blog->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
