@extends('layouts.main-layout')

@section('page-title')AdminPanel | Edit Product @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Edit Product {{ $product->title }}</li>
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
                <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data" id="add_product_form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value=null disabled selected>--- Select category ---</option>
                            @foreach($categories as $category)
                                <option value={{ $category->id }} @if($product->category->id == $category->id ) selected @endif>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="manufacturer">Manufacturer</label>
                        <select name="manufacturer" id="manufacturer" class="form-select" required>
                            <option value=null disabled selected>--- Select manufacturer ---</option>
                            @foreach($manufacturers as $manufacturer)
                                <option value={{ $manufacturer->id }} @if($product->manufacturer && $product->manufacturer->id == $manufacturer->id ) selected @endif>{{ $manufacturer->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_title">Title</label>
                        <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Title" required value="{{ $product->title }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control">{{ $product->description }}</textarea>
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
                    <a href="#changeExistingImages" class="admin-form-sublink">Change existing images</a>
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
                        <div class="admin-product-specifications-block" id="product_specifications_block">
                            @foreach($product->specifications as $specification)
                                <div class="input-group exist-spec-group-input">
                                    <span class="input-group-text">Title</span>
                                    <input type="text" name="title" aria-label="Title" class="form-control" required readonly disabled value="{{ $specification->title }}">
                                    <span class="input-group-text">Value</span>
                                    <input type="text" name="value" aria-label="Value" class="form-control" required readonly disabled value="{{ $specification->specification_values->where('product_id', $product->id)->first()->value }}">
                                    <span class="input-group-text">Dimension</span>
                                    <input type="text" name="dimension" aria-label="Dimension" class="form-control" readonly disabled value="{{ $specification->dimension }}">
                                    <span class="input-group-text edit-specification" style="cursor: pointer;" onclick="editProductSpec($(this))">Edit</span>
                                    <span class="input-group-text save-specification" style="display: none;" onclick="saveProductSpec($(this), {{ $specification->id }})">Save</span>
                                    <span class="input-group-text delete-specification" style="cursor: pointer;" onclick="deleteProductSpec($(this), {{ $specification->id }})">Delete</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" min="0.01" step="0.01" required value="{{ $product->price }}">
                    </div>
                    <div class="form-group">
                        <label for="price">Popular</label>
                        <select name="popular" id="popular" class="form-select">
                            <option value=1 @if($product->popular == 1) selected @endif>Yes</option>
                            <option value=0 @if($product->popular == 0) selected @endif>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="new_to_date">New to date (optional)</label>
                        <input type="date" name="new_to_date" id="new_to_date" class="form-control" value="{{ $product->new_to_date }}">
                    </div>
                    <div class="form-group">
                        <label for="price">In Stock</label>
                        <select name="in_stock" id="in_stock" class="form-select">
                            <option value=1 @if($product->in_stock == 1) selected @endif>Yes</option>
                            <option value=0 @if($product->in_stock == 0) selected @endif>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="seo_title">SEO Title</label>
                        <textarea name="seo_title" id="seo_title" rows="3" class="form-control">{{ $product->seo_title }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="seo_description">SEO Description</label>
                        <textarea name="seo_description" id="seo_description" rows="3" class="form-control">{{ $product->seo_description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="seo_keywords">SEO Keywords</label>
                        <textarea name="seo_keywords" id="seo_keywords" rows="3" class="form-control">{{ $product->seo_description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" required value="{{ $product->slug }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block" id="add_product_form_button">Save</button>
                    </div>
                </form>
                <p class="admin-subheader" id="changeExistingImages">Edit images for product:</p>
                <div class="admin-image-form-container gb-3">
                    @foreach($product->images as $image)
                        <div class="admin-item">
                            <div class="admin-item-image">
                                <img src="{{ Storage::url($image->image_path) }}" id="productImage_{{ $image->id }}">
                            </div>
                            <div class="admin-item-subform">
                                <form action="{{ route('product-image.update', $image->id) }}" method="post" enctype="multipart/form-data" id="productImageForm_{{ $image->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input type="file" placeholder="Change image" class="form-control admin-change-image" name="image" id="image_{{ $image->id }}" data-slider-image-id="productImage_{{ $image->id }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Image position</label>
                                        <input type="number" min="0" step="1" value="{{ $image->position }}" class="form-control" name="position" id="position">
                                    </div>
                                </form>
                            </div>
                            <div class="admin-item-control">
                                <ul>
                                    <li><button type="submit" form="productImageForm_{{ $image->id }}" class="admin-item-control-edit"><i class="fa-solid fa-floppy-disk"></i></button></li>
                                    <li><form action="{{ route('product-image.destroy', $image->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn admin-item-control-delete" data-title="Image for product {{ $product->title }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </section>

    <script>
        $(document).ready(function () {
            deleteSpec = function(element){
                element.closest('.input-group').remove();
            }

            editProductSpec = function (element) {
                element.hide();
                let saveBtn = element.next('.save-specification');
                saveBtn.show();
                saveBtn.css('cursor', 'pointer');
                let parentContainer = element.closest('.exist-spec-group-input');
                parentContainer.children('input').each(function() {
                    $(this).removeAttr('readonly');
                    $(this).removeAttr('disabled');
                })
            }
            saveProductSpec = function (element, specificationId) {
                let parentContainer = element.closest('.exist-spec-group-input');
                let title = parentContainer.children('input[name="title"]').val();
                let value = parentContainer.children('input[name="value"]').val();
                let dimension = parentContainer.children('input[name="dimension"]').val();

                $.ajax({
                    url: "{{ route('edit-specification') }}",
                    type: "POST",
                    data: {
                        'id': specificationId,
                        'product_id': {{ $product->id }},
                        'title': title,
                        'value': value,
                        'dimension': dimension
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    },
                    success: (data) => {
                        alert('Specification changed!');
                        location.reload();
                    },
                    error: (data) => {
                        console.log('error')
                    },
                    dataType: "json"
                });
            }
            deleteProductSpec = function (element, specificationId) {
                let parentContainer = element.closest('.exist-spec-group-input');
                let title = parentContainer.children('input[name="title"]').val();
                let res = confirm('Are you sure you want to delete the "' + title + '"? This will also remove child entries!');
                if (!res) {
                    return false;
                } else {
                    $.ajax({
                        url: "{{ route('delete-specification') }}",
                        type: "POST",
                        data: {
                            'id': specificationId,
                            'product_id': {{ $product->id }}
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                        },
                        success: (data) => {
                            alert('Specification deleted!');
                            location.reload();
                        },
                        error: (data) => {
                            console.log('error')
                        },
                        dataType: "json"
                    });
                }
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
                if (specGroupInput.length !== 0) {
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
                }
                $(this).unbind('submit').submit();
            })
        });
    </script>
@endsection
