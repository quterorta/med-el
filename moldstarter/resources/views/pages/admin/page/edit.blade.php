@extends('layouts.main-layout')

@section('page-title')AdminPanel | Edit Page @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Edit Page {{ $page->title }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('page.index') }}">All Pages</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('page.update', $page->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Title" required value="{{ $page->title }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Edit</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
@endsection
