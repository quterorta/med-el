@extends('layouts.main-layout')

@section('page-title')AdminPanel | Categories @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All Categories</li>
                    <li class="admin-navbar-link"><a href="{{ route('category.create') }}">Add</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-items-container">
                @foreach($categories as $category)
                    <div class="admin-item">
                        <div class="admin-item-image">
                            <a class="admin-item-header-link" href="{{ route('category.edit', $category->id) }}"><img src="{{ Storage::url($category->image) }}" alt=""></a>
                        </div>
                        <a class="admin-item-header-link" href="{{ route('category.edit', $category->id) }}">{{ $category->title }}</a>
                        <div class="admin-item-text">
                            <p>{{ $category->description }}</p>
                        </div>
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('category.edit', $category->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="{{ $category->title }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </section>
@endsection
