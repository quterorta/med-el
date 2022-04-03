@extends('layouts.main-layout')

@section('page-title')AdminPanel | Edit Slider @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Edit Slider for {{ $slider->page->title }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('slider.index') }}">All Sliders</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('slider.update', $slider->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="page">Page</label>
                        <select name="page" id="page" class="form-select" required>
                            <option value=null disabled>--- Select page ---</option>
                            @foreach($pages as $page)
                                <option value={{ $page->id }} @if($slider->page->id == $page->id) selected @endif>{{ $page->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Edit</button>
                    </div>
                </form>
                <p class="admin-subheader">Edit images for slider:</p>
                <div class="admin-image-form-container gb-3">
                    @foreach($sliderImages as $image)
                        <div class="admin-item">
                            <div class="admin-item-image">
                                <img src="{{ Storage::url($image->image_path) }}" id="sliderImage_{{ $image->id }}">
                            </div>
                            <div class="admin-item-subform">
                                <form action="{{ route('slider-image.update', $image->id) }}" method="post" enctype="multipart/form-data" id="sliderImageForm_{{ $image->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input type="file" placeholder="Change image" class="form-control admin-change-image" name="image" id="image_{{ $image->id }}" data-slider-image-id="sliderImage_{{ $image->id }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Image position</label>
                                        <input type="number" min="0" step="1" value="{{ $image->position }}" class="form-control" name="position" id="position">
                                    </div>
                                </form>
                            </div>
                            <div class="admin-item-control">
                                <ul>
                                    <li><button type="submit" form="sliderImageForm_{{ $image->id }}" class="admin-item-control-edit"><i class="fa-solid fa-floppy-disk"></i></button></li>
                                    <li><form action="{{ route('slider-image.destroy', $image->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn admin-item-control-delete" data-title="Slider Image for {{ $slider->page->title }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
                <form action="{{ route('slider-image.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="number" readonly hidden value={{ $slider->id }} name="sliderId">
                    <div class="form-group">
                        <label for="">Add images for slider</label>
                        <div class="select-image-block">
                            <input type="file" id="images" multiple="true" name="images[]">
                            <input type="hidden" name="images-hidden" value="images-hidden">
                            <ul id="uploadImagesList">
                                <li class="item template">
                                <span class="img-wrap">
                                    <img src="image.jpg" alt="">
                                </span>
                                    <span class="delete-link" title="Delete">Delete</span>
                                </li>
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Add</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
@endsection
