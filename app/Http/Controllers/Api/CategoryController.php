<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->apiResponse(ResultTypeController::Success, Category::all(),'Kategoriler', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name          = $request->name;
        $category->slug          = Str::slug($request->slug);
        $category->save();

        return $this->apiResponse(ResultTypeController::Success, $category, "Kategori Eklendi", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->apiResponse(ResultTypeController::Success, $category,'Kategoriler',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name          = $request->name;
        $category->slug          = Str::slug($request->slug);
        $category->save();

        return $this->apiResponse(ResultTypeController::Success, $category,"Kategori Güncellendi",200 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->apiResponse(ResultTypeController::Success, null,'Kategori Silindi', 200);
    }

    public function custom1()
    {
        //return Category::pluck('id');
        //return Category::pluck('id', 'name');
        return Category::pluck('name', 'id');
    }

    public function report1()
    {
       return DB::table('product_categories as pc')
           ->selectRaw('c.name, COUNT(*) as total')
           ->join('categories as c','c.id','=', 'pc.category_id')
           ->join('products as p','p.id','=', 'pc.product_id')
           ->groupBy('c.name')
           ->orderByRaw('COUNT(*) DESC')
           ->get();
    }
}
