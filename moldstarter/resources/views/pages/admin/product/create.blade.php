@extends('layouts.main-layout')

@section('page-title')AdminPanel | Create Product @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Add Product</li>
                    <li class="admin-navbar-link"><a href="{{ route('product.index') }}">All Products</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data" id="add_product_form">
                    @csrf
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value=null disabled selected>--- Select category ---</option>
                            @foreach($categories as $category)
                            <option value={{ $category->id }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="manufacturer">Manufacturer</label>
                        <select name="manufacturer" id="manufacturer" class="form-select" required>
                            <option value=null disabled selected>--- Select manufacturer ---</option>
                            @foreach($manufacturers as $manufacturer)
                                <option value={{ $manufacturer->id }}>{{ $manufacturer->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_title">Title</label>
                        <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Select images for product</label>
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
                        <label for="">Specifications</label>
                        <div class="add-specifications-button-container">
                            <button type="button" class="add-specifications-button" id="add_specifications_button">
                                <i class="fa-solid fa-plus"></i> Add new
                            </button>
                            <button type="button" class="add-existing-specifications-button" id="add_existing_specifications_button">
                                <i class="fa-solid fa-plus"></i> Choose from existing ones
                            </button>
                        </div>
                        <input type="text" hidden readonly name="specifications" id="product_specifications">
                        <div class="admin-product-specifications-block" id="product_specifications_block"></div>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" min="0.01" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Popular</label>
                        <select name="popular" id="popular" class="form-select">
                            <option value=1>Yes</option>
                            <option value=0 selected>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="new_to_date">New to date (optional)</label>
                        <input type="date" name="new_to_date" id="new_to_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="price">In Stock</label>
                        <select name="in_stock" id="in_stock" class="form-select">
                            <option value=1 selected>Yes</option>
                            <option value=0>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="seo_title">SEO Title</label>
                        <textarea name="seo_title" id="seo_title" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="seo_description">SEO Description</label>
                        <textarea name="seo_description" id="seo_description" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="seo_keywords">SEO Keywords</label>
                        <textarea name="seo_keywords" id="seo_keywords" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block" id="add_product_form_button">Create</button>
                    </div>
                </form>
            </div>
        </section>
    </section>

    <script>
        $(document).ready(function () {
            deleteSpec = function(element){
                element.closest('.input-group').remove();
            }

            $('#add_specifications_button').click(function () {
                $('#product_specifications_block').append(
                    '<div class="input-group spec-group-input">' +
                    '<span class="input-group-text">Title</span>' +
                    '<input type="text" name="title" aria-label="Title" class="form-control" required>' +
                    '<span class="input-group-text">Value</span>' +
                    '<input type="text" name="value" aria-label="Value" class="form-control" required>' +
                    '<span class="input-group-text">Dimension</span>' +
                    '<input type="text" name="dimension" aria-label="Dimension" class="form-control spec-dimension">' +
                    '<span class="input-group-text delete-specification" style="cursor: pointer;" onclick="deleteSpec($(this))">Delete</span>' +
                    '</div>');
            });

            $('#add_existing_specifications_button').click(function () {
                $('#product_specifications_block').append(
                    '<div class="input-group spec-group-input">' +
                    '<span class="input-group-text">Title</span>' +
                    '<select class="select-specification" name="title" aria-label="Title">' +
                    @foreach($specifications as $specification)
                        '<option value={{ $specification->title }}>{{ $specification->title }}</option>' +
                    @endforeach
                        '</select>' +
                    '<span class="input-group-text">Value</span>' +
                    '<input type="text" name="value" aria-label="Value" class="form-control">' +
                    '<span class="input-group-text">Dimension</span>' +
                    '<input type="text" name="dimension" aria-label="Dimension" class="form-control spec-dimension" placeholder="Auto">' +
                    '<span class="input-group-text delete-specification" style="cursor: pointer;" onclick="deleteSpec($(this))">Delete</span>' +
                    '</div>');
                $('.select-specification').select2({
                    width: '20vw'
                });
            });

            $('#add_product_form').submit(function(event) {
                event.preventDefault();
                let specGroupInput = $('.spec-group-input');
                if (specGroupInput.length === 0) {
                    alert('You must add at least one specification!');
                    let addButton = $('#add_specifications_button');
                    addButton.focus();
                } else {
                    let specificationsList = [];
                    specGroupInput.each(function(index){
                        let title = $(this).children('input[name="title"]').val();
                        if (title === undefined) {
                            title = $(this).children('.select-specification').find(':selected').val();
                        }
                        let value = $(this).children('input[name="value"]').val();
                        let dimension = $(this).children('input[name="dimension"]').val();
                        let data = {
                            'title': title,
                            'value': value,
                            'dimension': dimension
                        };
                        specificationsList.push(data);
                    });
                    $('#product_specifications').val(JSON.stringify(specificationsList));
                    $(this).unbind('submit').submit();
                }
            })
        });
    </script>
@endsection
