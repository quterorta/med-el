@extends('layouts.main-layout')

@section('page-title')AdminPanel | Manufacturers @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All Manufacturers</li>
                    <li class="admin-navbar-link"><a href="{{ route('manufacturer.create') }}">Add</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-items-container">
                @foreach($manufacturers as $manufacturer)
                    <div class="admin-item">
                        <div class="admin-item-image">
                            <a class="admin-item-header-link" href="{{ route('manufacturer.edit', $manufacturer->id) }}"><img src="{{ Storage::url($manufacturer->image) }}" alt=""></a>
                        </div>
                        <a class="admin-item-header-link" href="{{ route('manufacturer.edit', $manufacturer->id) }}">{{ $manufacturer->title }}</a>
                        <div class="admin-item-text">
                            <p>{{ $manufacturer->description }}</p>
                        </div>
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('manufacturer.edit', $manufacturer->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('manufacturer.destroy', $manufacturer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="{{ $manufacturer->title }}">
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
