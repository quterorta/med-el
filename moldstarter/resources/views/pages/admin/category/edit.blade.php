@extends('layouts.main-layout')

@section('page-title')AdminPanel | Edit Category @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Edit Category "{{ $category->title }}"</li>
                    <li class="admin-navbar-link"><a href="{{ route('category.index') }}">All Categories</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Title" required value="{{ $category->title }}">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <img src="{{ Storage::url($category->image) }}" alt="" id="admin-item-image-preview" style="display: block; width: 30vw; margin-bottom: 1rem;">
                        <input type="file" name="image" id="image" class="form-control admin-item-image-input" placeholder="Image">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control">{{ $category->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="seo_title">SEO Title</label>
                        <textarea name="seo_title" id="seo_title" rows="3" class="form-control">{{ $category->seo_title }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="seo_description">SEO Description</label>
                        <textarea name="seo_description" id="seo_description" rows="3" class="form-control">{{ $category->seo_description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="seo_keywords">SEO Keywords</label>
                        <textarea name="seo_keywords" id="seo_keywords" rows="3" class="form-control"> {{ $category->seo_keywords }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" required value="{{ $category->slug }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Save</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
@endsection
