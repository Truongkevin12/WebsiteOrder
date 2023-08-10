<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsManufacture;
use App\Models\ProductsUnit;
use App\Models\Status;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::query();
        if ($keyword) {
            $products->where('prd_name', 'like', "%{$keyword}%");
            $products->orWhere('prd_code', 'like', "%{$keyword}%");
            $products->orWhere('prd_active', 'like', "%{$keyword}%");
        }
        $products = $products->paginate(50);
        $category = Category::paginate(50);
        $producer = ProductsManufacture::paginate(50);
        $status = Status::all();
        $data = [
            'product' => $products,
            'producer' => $producer,
            'category' => $category,
            'status' => $status,
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producer = ProductsManufacture::paginate(50);
        $product_unit = ProductsUnit::paginate(50);
        $category = Category::paginate(50);
        $data = [
            'producer' => $producer,
            'product_unit' => $product_unit,
            'category' => $category,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'prd_name' => 'required|max:255',
                'prd_sell_price' => 'required|numeric|min:0',
                'prd_pack' => 'required|max:100',
            ],
            [
                "prd_name.required" => "Hãy nhập tên sản phẩm",
                "prd_name.max" => "Ký tự tối đa là 255",
                "prd_sell_price.required" => "Hãy nhập số tiền sản phẩm",
                "prd_sell_price.numeric" => "Số tiền sản phẩm phải là số",
                "prd_sell_price.min" => "Số tiền sản phẩm không được nhỏ hơn 0",
                "prd_pack.required" => "Hãy nhập quy cách đóng gói",
                "prd_pack.max" => "Quy cách đóng gói tối đa là 100 ký tự",
            ]
        );
        Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producer = ProductsManufacture::paginate(50);
        $product_unit = ProductsUnit::paginate(50);
        $products = Product::find($id);
        $category = Category::paginate(50);
        return response()->json([
            "products" => $products,
            "producer" => $producer,
            "product_unit" => $product_unit,
            "category" => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producer = ProductsManufacture::paginate(50);
        $product_unit = ProductsUnit::paginate(50);
        $products = Product::find($id);
        return response()->json([
            "products" => $products,
            "producer" => $producer,
            "product_unit" => $product_unit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Product::where('id' , $id)->update($request->all());
        return response()->json(['message' => 'Store updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id',$id)->delete();
        return response()->json('The post successfully deleted');
    }
}
