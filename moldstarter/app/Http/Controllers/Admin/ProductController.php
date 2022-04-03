<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\ProductSpecificationValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(12);
        return view('pages.admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $manufacturers = Manufacturer::all();
        $specifications = ProductSpecification::all()->unique('title');
        return view('pages.admin.product.create', compact('categories', 'specifications', 'manufacturers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();

        $product->category_id = $request->category;
        $product->manufacturer_id = $request->manufacturer;
        $product->title = $request->product_title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->popular = $request->popular;
        $product->in_stock = $request->in_stock;
        $product->new_to_date = $request->new_to_date;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->seo_keywords = $request->seo_keywords;
        $product->slug = $request->slug;

        $product->save();
        $productId = $product->id;

        $images = $request->file('images');
        foreach ($images as $image) {
            $productImage = new ProductImage();
            $productImage->product_id = $productId;
            $productImage->position = 0;
            $productImagePath = $image->store('product-images');
            $productImage->image_path = $productImagePath;
            $productImage->save();
        }

        $specifications = json_decode($request->specifications, true);
        foreach ($specifications as $specification) {
            if (!ProductSpecification::where('title', $specification['title'])->exists()) {
                $productSpecification = new ProductSpecification();
                $productSpecification->title = $specification['title'];
                $productSpecification->dimension = $specification['dimension'];
                $productSpecification->save();
            } else {
                $productSpecification = ProductSpecification::where('title', $specification['title'])->first();
            }

            $specificationId = $productSpecification->id;
            if (!$product->specifications->find($specificationId)) {
                $product->specifications()->attach($specificationId);
            }

            $productSpecificationValue = new ProductSpecificationValue();
            $productSpecificationValue->product_id = $product->id;
            $productSpecificationValue->product_specification_id = $specificationId;
            $productSpecificationValue->value = $specification['value'];
            $productSpecificationValue->save();
        }

        return redirect()->route('product.index')->withSuccess('Product successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::get();
        $manufacturers = Manufacturer::get();
        $specifications = ProductSpecification::all()->unique('title');
        return view('pages.admin.product.edit', compact('product', 'specifications', 'categories', 'manufacturers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->category_id = $request->category;
        $product->manufacturer_id = $request->manufacturer;
        $product->title = $request->product_title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->popular = $request->popular;
        $product->in_stock = $request->in_stock;
        $product->new_to_date = $request->new_to_date;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->seo_keywords = $request->seo_keywords;
        $product->slug = $request->slug;
        $product->save();
        $productId = $product->id;

        if ($request->file('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $productImage = new ProductImage();
                $productImage->product_id = $productId;
                $productImage->position = 0;
                $productImagePath = $image->store('product-images');
                $productImage->image_path = $productImagePath;
                $productImage->save();
            }
        }

        if ($request->specifications) {
            $specifications = json_decode($request->specifications, true);
            foreach ($specifications as $specification) {
                if (!ProductSpecification::where('title', $specification['title'])->exists()) {
                    $productSpecification = new ProductSpecification();
                    $productSpecification->title = $specification['title'];
                    $productSpecification->dimension = $specification['dimension'];
                    $productSpecification->save();
                } else {
                    $productSpecification = ProductSpecification::where('title', $specification['title'])->first();
                }

                $specificationId = $productSpecification->id;
                if (!$product->specifications->find($specificationId)) {
                    $product->specifications()->attach($specificationId);
                }

                $productSpecificationValue = new ProductSpecificationValue();
                $productSpecificationValue->product_id = $product->id;
                $productSpecificationValue->product_specification_id = $specificationId;
                $productSpecificationValue->value = $specification['value'];
                $productSpecificationValue->save();
            }
        }

        return redirect()->route('product.index')->withSuccess('Product successfully changed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        foreach ($product->images as $image) {
            Storage::delete($image->image_path);
        }
        return redirect()->back()->withSuccess('Product deleted!');
    }
}
