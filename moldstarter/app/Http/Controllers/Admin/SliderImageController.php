<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderImageController extends Controller
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
        $sliderId = $request->sliderId;
        foreach ($request->file('images') as $image) {
            $sliderImage = new SliderImage();
            $sliderImage->slider_id = $sliderId;
            $sliderImage->position = 0;
            $path_image_cover = $image->store('slider-images');
            $sliderImage->image_path = $path_image_cover;
            $sliderImage->save();
        }
        return redirect()->back()->withSuccess('Images for slider successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SliderImage  $sliderImage
     * @return \Illuminate\Http\Response
     */
    public function show(SliderImage $sliderImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SliderImage  $sliderImage
     * @return \Illuminate\Http\Response
     */
    public function edit(SliderImage $sliderImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SliderImage  $sliderImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SliderImage $sliderImage)
    {
        $sliderImage->position = $request->position;
        if ($request->file('image')) {
            Storage::delete($sliderImage->image_path);
            $path = $request->file('image')->store('slider-images');
            $sliderImage->image_path = $path;
        }
        $sliderImage->save();
        return redirect()->back()->withSuccess('Image successfully changed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SliderImage  $sliderImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SliderImage $sliderImage)
    {
        Storage::delete($sliderImage->image_path);
        $sliderImage->delete();
        return redirect()->back()->withSuccess('Slider image deleted!');
    }
}
