<?php

namespace Locomotif\Blog\Controller;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Locomotif\Blog\Models\BlogCategories;
use Locomotif\Media\Controller\MediaController;

class BlogCategoriesController extends Controller
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
        $items = BlogCategories::all();
        foreach ($items as $key => $value) {
            $items[$key]->status_nice = mapStatus($value->status);
        }
        return view('blogCategories::list')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogCategories  $blogCategories
     * @return \Illuminate\Http\Response
     */
    public function show(BlogCategories $blogCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogCategories  $blogCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogCategories $blogCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogCategories  $blogCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogCategories $blogCategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogCategories  $blogCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogCategories $blogCategories)
    {
        //
    }
}
