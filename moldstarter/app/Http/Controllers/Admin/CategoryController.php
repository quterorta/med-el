<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        return view('pages.admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();

        $category->title = $request->title;
        $path_image = $request->file('image')->store('category');
        $category->image = $path_image;
        $category->description = $request->description;
        $category->seo_title = $request->seo_title;
        $category->seo_description = $request->seo_description;
        $category->seo_keywords = $request->seo_keywords;
        $category->slug = $request->slug;

        $category->save();

        return redirect()->route('category.index')->withSuccess('Category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('pages.admin.category.edit', compact('category'));
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
        $category->title = $request->title;
        if ($request->file('image')) {
            Storage::delete($category->image);
            $path_image = $request->file('image')->store('category');
            $category->image = $path_image;
        }
        $category->description = $request->description;
        $category->seo_title = $request->seo_title;
        $category->seo_description = $request->seo_description;
        $category->seo_keywords = $request->seo_keywords;
        $category->slug = $request->slug;

        $category->save();

        return redirect()->route('category.index')->withSuccess('Category changed successfully');
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
        return redirect()->back()->withSuccess('Category deleted!');
    }
}
