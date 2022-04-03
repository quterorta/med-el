@extends('layouts.main-layout')

@section('page-title')AdminPanel | Create Slider @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Add Slider</li>
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
                <form action="{{ route('slider.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="page">Page</label>
                        <select name="page" id="page" class="form-select" required>
                            <option value=null disabled selected>--- Select page ---</option>
                            @foreach($pages as $page)
                            <option value={{ $page->id }}>{{ $page->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Select images for slider</label>
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
                        <button type="submit" class="btn btn-success btn-block">Create</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
@endsection
