@extends('layouts.main-layout')

@section('page-title')AdminPanel | Create Partner @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Add Partner</li>
                    <li class="admin-navbar-link"><a href="{{ route('partner.index') }}">All Partners</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('partner.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Title (Name)</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Title (Name)" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <img src="" alt="" id="admin-item-image-preview">
                        <input type="file" name="image" id="image" class="form-control admin-item-image-input" placeholder="Image">
                    </div>
                    <div class="form-group">
                        <label for="url">Url</label>
                        <input type="text" name="url" id="url" class="form-control" placeholder="Link for partner website">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Create</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
@endsection
