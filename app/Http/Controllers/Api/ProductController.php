<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsWithCategoriesResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
    */
    public function index(Request $request)
    {
        //Dönüş türleri
        //return Product::all();
        //return response()->json(Product::all(), 200);
        //return response(Product::all(), 200);

        //laravel sayfalandırma
        //return response()->json(Product::paginate(10), 200);

        //manuel sayfalandırma
        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit : 10;

        $qb = Product::query()->with('categories');
        if ($request->has('q')){
            $qb->where('name','like','%'. $request->query('q'). '%');
        }

        if ($request->has('sortBy')){
            $qb->orderBy($request->query('sortBy'),$request->query('sort', 'DESC'));
        }
        $data = $qb->offset($offset)->limit($limit)->get();
        $data = $data->makeHidden('slug');
        return response($data, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //Elequent Yapısı
        //$data = $request->all();
        //$product = Product::create($data);

        //ORM yapısı
        $product = new Product;
        $product->name          = $request->name;
        $product->slug          = Str::slug($request->slug);
        $product->price         = $request->price;
        $product->description   = $request->description;
        $product->save();

        return $this->apiResponse(ResultTypeController::Success, $product, 'Ürün Eklendi', 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($product)
    {
        try {
            $product = Product::findOrFail($product);
            return $this->apiResponse(ResultTypeController::Success, $product, 'Ürün bulundu', 200);
        } catch (ModelNotFoundException $exception){
            return $this->apiResponse(ResultTypeController::Error, null, 'Ürün bulunamadı', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {

        //$data = $request->all();
        //$product->update($data);

        $product->name          = $request->name;
        $product->slug          = Str::slug($request->slug);
        $product->price         = $request->price;
        $product->description   = $request->description;
        $product->save();

        return $this->apiResponse(ResultTypeController::Success, $product, 'Ürün Güncellendi', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->apiResponse(ResultTypeController::Success, null, 'Ürün Silindi', 200);

    }

    public function custom1()
    {
        //return Product::select('id', 'name')->orderBy('created_at', 'desc')->take(10)->get();
        return Product::selectRaw('id as product_id, name as product_name')->orderBy('created_at', 'desc')->take(10)->get();
    }

    public function custom2()
    {
        //return Product::select('id', 'name')->orderBy('created_at', 'desc')->take(10)->get();
        $products =  Product::orderBy('created_at', 'desc')->take(10)->get();

        $mapped = $products->map(function($product){
            return [
                '_id' => $product['id'],
                'product_name' => $product['name'],
                'product_price' => $product['price'] * 1.03,
            ];
        });

    }

    public function custom3()
    {
        $products = Product::paginate(10);
        return ProductResource::collection($products);

    }
    public function listWithCategories()
    {
        $products = Product::with('categories')->paginate(10);
        return ProductsWithCategoriesResource::collection($products);

    }
}
