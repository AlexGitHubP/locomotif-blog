<?php

namespace Locomotif\Blog\Controller;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Locomotif\Blog\Models\BlogCategories;
use Locomotif\Media\Controller\MediaController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        return view('blogCategories::create');
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
            'category_name'        => 'required',
            'category_url'         => 'required',
            'category_description' => 'required',
            'status'               => 'required',
        ]);

        $blogCategory = new BlogCategories();

        $blogCategory->category_name        = $request->category_name;
        $blogCategory->category_url         = $request->category_url;
        $blogCategory->category_description = $request->category_description;
        $blogCategory->ordering             = getOrdering($blogCategory->getTable(), 'ordering');
        $blogCategory->status               = $request->status;
        
        
        $blogCategory->save();

        return redirect('admin/blogCategories/'.$blogCategory->id.'/edit');
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
    public function edit(BlogCategories $blogCategory)
    {
        $associatedMedia      = app(MediaController::class)->mediaAssociations($blogCategory->getTable(), $blogCategory->id);
        return view('blogCategories::edit')->with('item', $blogCategory)->with('associatedMedia', $associatedMedia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogCategories  $blogCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogCategories $blogCategory)
    {
        $request->validate([
            'category_name'        => 'required',
            'category_url'         => 'required',
            'category_description' => 'required',
            'status'               => 'required',
        ]);

        $blogCategory->category_name        = $request->category_name;
        $blogCategory->category_url         = $request->category_url;
        $blogCategory->category_description = $request->category_description;
        $blogCategory->status               = $request->status;
        $blogCategory->save();
        
        return redirect('admin/blogCategories/'.$blogCategory->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogCategories  $blogCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogCategories $blogCategory)
    {
        $blogCategory->delete();
        return redirect('/admin/blogCategories');
    }

    public function getCategAndSubcateg($parent_id){

        $categories = BlogCategories::with('subcategories')->get();
        
        foreach ($categories as $key => $category) {
            $categories[$key]->selected = DB::table('blog_to_categories')->where([
                ['blog_id',     '=', $parent_id],
                ['category_id', '=', $category->id]
            ])->exists();
            foreach ($category->subcategories as $kk => $subcategory) {
                $category->subcategories[$kk]->selected = DB::table('blog_to_subcategories')->where([
                    ['blog_id',  '=', $parent_id],
                    ['subcategory_id', '=', $subcategory->id]
                ])->exists();
            }
        }
        

        return view('blogCategories::categoriesAndSubcategories')->with('parent_id', $parent_id)->with('categories', $categories);
    }

    public function addCategoriesAndSubcategories(Request $request){
        
        if(isset($request->categories) && count($request->categories) !=0){
            $this->insertCategoryToBlog($request);
        }else{
            $this->clearAllCategories($request);
        }

        if(isset($request->subcategories) && count($request->subcategories) !=0){
            $this->insertSubcategoriesToBlog($request);
        }else{
            $this->clearAllSubcategories($request);
        }

        $response['success'] = true;
        $response['message'] = 'Asocieri cu succes.';
        $response['type'] = 'category';

        return response()->json($response);
        
    }

    public function insertCategoryToBlog($request){
        DB::table('blog_to_categories')->where([
            ['blog_id',  '=', $request->pid]
        ])->delete();

        $now = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($request->categories as $key => $value) {
            DB::table('blog_to_categories')->insert([
                'blog_id'  => $request->pid,
                'category_id' => $value,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
    public function clearAllCategories($request){
        DB::table('blog_to_categories')->where([
            ['blog_id',  '=', $request->pid]
        ])->delete();
    }

    public function insertSubcategoriesToBlog($request){
        DB::table('blog_to_subcategories')->where([
            ['blog_id',  '=', $request->pid]
        ])->delete();

        $now = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($request->subcategories as $key => $value) {
            DB::table('blog_to_subcategories')->insert([
                'blog_id'     => $request->pid,
                'subcategory_id' => $value,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }

    public function clearAllSubcategories($request){
        DB::table('blog_to_subcategories')->where([
            ['blog_id',  '=', $request->pid]
        ])->delete();
    }
}
