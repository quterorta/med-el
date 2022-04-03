@extends('layouts.main-layout')

@section('page-title')AdminPanel | Products @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All Products</li>
                    <li class="admin-navbar-link"><a href="{{ route('product.create') }}">Add</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="admin-items-container">
                @foreach($products as $product)
                    <div class="admin-item">
                        <a class="admin-item-header-link" href="{{ route('product.edit', $product->id) }}">{{ $product->title }}</a>
                        <p class="admin-item-description">{{ $product->description }}</p>
                        <div class="admin-item-accordion" id="admin-item-accordion_{{ $product->id }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="imgCollapseHeading_{{ $product->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#imgCollapse_{{ $product->id }}" aria-expanded="true" aria-controls="imgCollapse_{{ $product->id }}">
                                        All images
                                    </button>
                                </h2>
                                <div id="imgCollapse_{{ $product->id }}" class="accordion-collapse collapse" aria-labelledby="imgCollapseHeading_{{ $product->id }}" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        @foreach($product->images as $image)
                                            <img src="{{ Storage::url($image->image_path) }}" alt="" width="100%">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="specCollapseHeading_{{ $product->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#specCollapse_{{ $product->id }}" aria-expanded="true" aria-controls="specCollapse_{{ $product->id }}">
                                        All specifications
                                    </button>
                                </h2>
                                <div id="specCollapse_{{ $product->id }}" class="accordion-collapse collapse" aria-labelledby="specCollapseHeading_{{ $product->id }}" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        @foreach($product->specifications as $specification)
                                            <p>{{ $specification->title }}: {{ $specification->specification_values->where('product_id', $product->id)->first()->value }} {{ $specification->dimension }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="admin-item-price">{{ $product->price }} MDL</p>
                        @if($product->manufacturer)
                        <img class="admin-item-manufacturer" src="{{ Storage::url($product->manufacturer->image) }}" alt="">
                        @endif
                        <p class="admin-item-popular">Popular:@if($product->popular == 1) Yes @else No @endif</p>
                        <p class="admin-item-popular">@if($product->in_stock == 1) In Stock @else Out of stock @endif</p>
                        @if($product->new_to_date)
                        <p class="admin-item-new-to-date">New to date: {{$product->new_to_date}}</p>
                        @endif
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('product.edit', $product->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="Product {{ $product->title }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Пагинация -->
            <div class="shop_page__paginate">
                {{ $products->links('layouts.pagination.paginate') }}
            </div>
            <!-- Пагинация -->
        </section>
    </section>
@endsection
