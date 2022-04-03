@extends('layouts.main-layout')

@section('page-title')AdminPanel | Sliders @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All Sliders</li>
                    <li class="admin-navbar-link"><a href="{{ route('slider.create') }}">Add</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-items-container">
                @foreach($sliders as $slider)
                    <div class="admin-item">
                        <a class="admin-item-header-link" href="{{ route('slider.edit', $slider->id) }}">Slider for {{ $slider->page->title }}</a>
                        <div class="admin-item-accordion" id="admin-item-accordion_{{ $slider->id }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="imgCollapseHeading_{{ $slider->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#imgCollapse_{{ $slider->id }}" aria-expanded="true" aria-controls="imgCollapse_{{ $slider->id }}">
                                        All images
                                    </button>
                                </h2>
                                <div id="imgCollapse_{{ $slider->id }}" class="accordion-collapse collapse" aria-labelledby="imgCollapseHeading_{{ $slider->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @foreach($slider->images as $image)
                                            <img src="{{ Storage::url($image->image_path) }}" alt="" width="100%">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('slider.edit', $slider->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('slider.destroy', $slider->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="Slider for {{ $slider->page->title }}">
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
