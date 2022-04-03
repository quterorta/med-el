@extends('layouts.main-layout')

@section('page-title')AdminPanel | Create Manufacturer @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Add Manufacturer</li>
                    <li class="admin-navbar-link"><a href="{{ route('manufacturer.index') }}">All Manufacturers</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('manufacturer.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <img src="" alt="" id="admin-item-image-preview">
                        <input type="file" name="image" id="image" class="form-control admin-item-image-input" placeholder="Image">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Create</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
@endsection
