@extends('layouts.main-layout')

@section('page-title')AdminPanel | Partners @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All Partners</li>
                    <li class="admin-navbar-link"><a href="{{ route('partner.create') }}">Add</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-items-container">
                @foreach($partners as $partner)
                    <div class="admin-item">
                        <div class="admin-item-image">
                            <a class="admin-item-header-link" href="{{ route('partner.edit', $partner->id) }}"><img src="{{ Storage::url($partner->image) }}" alt=""></a>
                        </div>
                        <a class="admin-item-header-link" href="{{ route('partner.edit', $partner->id) }}">{{ $partner->name }}</a>
                        <div class="admin-item-text">
                            <p>{{ $partner->url }}</p>
                        </div>
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('partner.edit', $partner->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('partner.destroy', $partner->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="{{ $partner->title }}">
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
