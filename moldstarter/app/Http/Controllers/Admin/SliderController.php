<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Slider;
use App\Models\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('id')->get();
        return view('pages.admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::orderBy('title')->get();
        return view('pages.admin.slider.create', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slider = new Slider();
        $slider->page_id = $request->page;
        $slider->save();
        $sliderId = $slider->id;
        foreach ($request->file('images') as $image) {
            $sliderImage = new SliderImage();
            $sliderImage->slider_id = $sliderId;
            $sliderImage->position = 0;
            $path_image_cover = $image->store('slider-images');
            $sliderImage->image_path = $path_image_cover;
            $sliderImage->save();
        }
        return redirect()->route('slider.index')->withSuccess('New slider created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $pages = Page::orderBy('title')->get();
        $sliderImages = $slider->images;
        return view('pages.admin.slider.edit', compact('slider', 'pages', 'sliderImages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $slider->page_id = $request->page;
        $slider->save();
        return redirect()->route('slider.index')->withSuccess('Slider for '.$slider->page->title.' change successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $pageTitle = $slider->page->title;
        foreach ($slider->images as $image) {
            Storage::delete($image->image_path);
        }
        $slider->delete();
        return redirect()->back()->withSuccess('Slider for '.$pageTitle.' is deleted!');
    }
}
