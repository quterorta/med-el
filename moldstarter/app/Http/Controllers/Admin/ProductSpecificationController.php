<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSpecification;
use App\Models\ProductSpecificationValue;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductSpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\ProductSpecification  $productSpecification
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSpecification $productSpecification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductSpecification  $productSpecification
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSpecification $productSpecification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductSpecification  $productSpecification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductSpecification $productSpecification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductSpecification  $productSpecification
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductSpecification $productSpecification)
    {
        //
    }

    public function editSpecification(Request $request)
    {
        $productSpecification = ProductSpecification::find($request->id);
        $newTitle = $request->title;
        $newValue = $request->value;
        $newDimension = $request->dimension;
        $productId = $request->product_id;

        if ($productSpecification->title !== $newTitle) {
            $productSpecification->title = $newTitle;
            $productSpecification->save();
        }

        if ($productSpecification->dimension && $productSpecification->dimension !== $newDimension) {
            $productSpecifications = ProductSpecification::where('title', $productSpecification->title)->get();
            foreach ($productSpecifications as $spec) {
                $spec->dimension = $newDimension;
                $spec->save();
            }
        }

        if ($productSpecification->specification_values->where('product_id', $request->product_id)->first()->value !== $newValue) {
            $specValue = ProductSpecificationValue::find($productSpecification->specification_values->where('product_id', $request->product_id)->first()->id);
            $specValue->value = $newValue;
            $specValue->save();
        }

        return response()->json(['success']);
    }

    public function deleteSpecification(Request $request)
    {
        $productSpecification = ProductSpecification::find($request->id);
        $product = Product::find($request->product_id);
        $product->specifications()->detach($request->id);
        $productSpecification->delete();
        return response()->json(['success']);
    }
}
