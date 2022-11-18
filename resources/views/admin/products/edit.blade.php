@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="form" enctype="multipart/form-data" id="update_product">
                <div class="box-body">
                    <div class="row">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist" id="tablist">
                                <li role="presentation" @if(!request()->has('combination')) class="active" @endif><a href="#info" aria-controls="home" role="tab" data-toggle="tab">Info</a></li>
                                <li role="presentation" @if(request()->has('combination')) class="active" @endif><a href="#combinations" aria-controls="profile" role="tab" data-toggle="tab">Combinations</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content" id="tabcontent">
                                <div role="tabpanel" class="tab-pane @if(!request()->has('combination')) active @endif" id="info">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>{{ ucfirst($product->name) }}</h2>
                                            <div class="form-group">
                                                <label for="item_number">Item Number <span class="text-danger">*</span></label>
                                                <input type="text" name="item_number" id="item_number" placeholder="xxxxx" class="form-control" value="{!! $product->item_number !!}" required="">
                                            </div>
                                            @if(!$shops->isEmpty())
                                                <div class="form-group">
                                                    <label for="shop_id">Shop </label>
                                                    <select name="shop_id" id="shop_id" class="form-control " onchange="selectCheck(this,'custom_b_t')">
                                                        <option value=""></option>
                                                        @foreach($shops as $shop)
                                                            <option @if($shop->id == $product->shop_id) selected="selected" @endif value="{{ $shop->id }}">{{ $shop->name }}</option>
                                                        @endforeach
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    <input type="text" id="custom_b_t" style="display: none;" placeholder="Shop" value="" class="form-control">
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="sku">Article Number <span class="text-danger">*</span></label>
                                                <input type="text" name="sku" id="sku" placeholder="xxxxx" class="form-control" value="{!! $product->sku !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name of Product <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $product->name !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="summary">Summary</label>
                                                <input type="text" name="summary" id="summary" placeholder="Short Description" class="form-control" value="{{ $product->summary }}" >
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description </label>
                                                <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description">{!! $product->description  !!}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <img src="{{ $product->cover }}" alt="" class="img-responsive img-thumbnail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"></div>
                                            <div class="form-group">
                                                <label for="cover">Cover </label>
                                                <input type="file" name="cover" id="cover" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                @foreach($images as $image)
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <img src="{{ asset("storage/$image->src") }}" alt="" class="img-responsive img-thumbnail"> <br /> <br>
                                                            <a onclick="return confirm('Are you sure?')" href="{{ route('admin.product.remove.thumb', ['src' => $image->src]) }}" class="btn btn-danger btn-sm btn-block">Remove?</a><br />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row"></div>
                                            <div class="form-group">
                                                <label for="image">Images </label>
                                                <input type="file" name="image[]" id="image" class="form-control" multiple>
                                                <span class="text-warning">You can use ctr (cmd) to select multiple images</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="Quality">Quality <span class="text-danger">* </span></label>
                                                @if($productAttributes->isEmpty())
                                                <input type="text" name="quality"
                                                id="quality" placeholder="Quality" class="form-control" value="{!! $product->quality!!}"
                                                    >
                                                @else
                                                    <input type="hidden" name="quality" value="{{ $product->quality }}">
                                                    <input type="text" value="{{ $product->quality }}" class="form-control" disabled>
                                                @endif
                                                @if(!$productAttributes->isEmpty())<span class="text-danger">Note: Quantity is disabled. Total quantity is calculated by the sum of all the combinations.</span> @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                @if($productAttributes->isEmpty())
                                                    <div class="input-group">
                                                        <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                        <input type="text" name="price" id="price" placeholder="Price" class="form-control" value="{!! $product->price !!}">
                                                    </div>
                                                @else
                                                    <input type="hidden" name="price" value="{!! $product->price !!}">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                        <input type="text" id="price" placeholder="Price" class="form-control" value="{!! $product->price !!}" disabled>
                                                    </div>
                                                @endif
                                                @if(!$productAttributes->isEmpty())<span class="text-danger">Note: Price is disabled. Price is derived based on the combination.</span> @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="sale_price">Sale Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                    <input type="text" name="sale_price" id="sale_price" placeholder="Sale Price" class="form-control" value="{{ $product->sale_price }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="transportation_price">Transportation price </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">MAD</span>
                                                    <input type="text" name="transportation_price" id="transportation_price" placeholder="Price" class="form-control" value="{{ $product->transportation_price }}" >
                                                </div>
                                            </div>
                                            @if(!$brands->isEmpty())
                                                <div class="form-group">
                                                    <label for="brand_id">Car Brand </label>
                                                    <select name="brand_id" id="brand_id" class="form-control ">
                                                        <option value=""></option>
                                                        @foreach($brands as $brand)
                                                            <option @if($brand->id == $product->brand_id) selected="selected" @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="car_model">Car Model </label>
                                                <select id="car_model" name="car_model" class="form-control ">
                                                    <option value="">--</option>
                                                    @foreach($carModels as $cm)
                                                        <option @if($product->car_model == $cm->id) selected="selected" @endif value="{{ $cm->id }}" data-chained="{{$cm->parent_id}}">{{ $cm->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="car_submodel">Car Sub-model </label>
                                                <select id="car_submodel" name="car_submodel" class="form-control ">
                                                    <option value="">--</option>
                                                    @foreach($carSubModels as $csm)
                                                        <option @if($product->car_submodel == $csm->id) selected="selected" @endif value="{{ $csm->id }}" data-chained="{{$csm->parent_id}}" data-parts="{{ $csm->available_part}}">{{ $csm->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Is parts -->
                                            @if(!$isparts->isEmpty())
                                                <div class="form-group">
                                                    <label for="is_part">Car Part </label>
                                                    <select name="is_part[]" id="is_part" class="form-control">
                                                        <?php 
                                                        $isprt = explode(',',$product->is_part);
                                                        ?>
                                                        <option value=""></option>
                                                        @foreach($isparts as $ispart)
                                                        {{--@foreach($isprt as $part)--}}
                                                            <option value="{{ $ispart->id }}">{{ $ispart->name }}</option>
                                                        {{--@endforeach--}}

                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="sub_part">Sub-part </label>
                                                <select id="sub_part" name="sub_part" class="form-control">
                                                    <option value="">--</option>
                                                    @foreach($sub_parts as $sp)
                                                        <option @if($product->sub_part == $sp->id) selected="selected" @endif value="{{ $sp->id }}" data-chained="{{$sp->parent_id}}">{{ $sp->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="C">Piece </label>
                                                @include('admin.shared.categories', ['categories' => $categories, 'ids' => $product])
                                            </div>
                                            <div class="form-group">
                                                @include('admin.shared.status-select', ['status' => $product->status])
                                            </div>
                                            @include('admin.shared.attribute-select', [compact('default_weight')])
                                            <!-- /.box-body -->
                                        </div>
                                        {{--
                                        <div class="col-md-4">
                                            <h2>Categories</h2>
                                            @include('admin.shared.categories', ['categories' => $categories, 'ids' => $product])
                                        </div>--}}
                                    </div>
                                    <div class="row">
                                        <div class="box-footer">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.products.index') }}" class="btn btn-default btn-sm">Back</a>
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane @if(request()->has('combination')) active @endif" id="combinations">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @include('admin.products.create-attributes', compact('attributes'))
                                        </div>
                                        <div class="col-md-8">
                                            @include('admin.products.attributes', compact('productAttributes'))
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
@section('css')
    <style type="text/css">
        label.checkbox-inline {
            padding: 10px 5px;
            display: block;
            margin-bottom: 5px;
        }
        label.checkbox-inline > input[type="checkbox"] {
            margin-left: 10px;
        }
        ul.attribute-lists > li > label:hover {
            background: #3c8dbc;
            color: #fff;
        }
        ul.attribute-lists > li {
            background: #eee;
        }
        ul.attribute-lists > li:hover {
            background: #ccc;
        }
        ul.attribute-lists > li {
            margin-bottom: 15px;
            padding: 15px;
        }
        .checkbox-list {
            /*display: none;*/
            list-style-type: none;
            padding-left: 0;
            max-height: 300px;
            height: auto;
            overflow-y: auto;
            /*display: inline-block;*/
            width: 100%;
        }
        .checkbox-list li {
            width: 33%;
            display: inline-block;
            float: left;
        }
    </style>
@endsection
@section('js')
    <script type="text/javascript" src="{{ asset('js/toast-notify.js')}}"></script>
    <script type="text/javascript">
        function backToInfoTab() {
            $('#tablist > li:first-child').addClass('active');
            $('#tablist > li:last-child').removeClass('active');

            $('#tabcontent > div:first-child').addClass('active');
            $('#tabcontent > div:last-child').removeClass('active');
        }
        $(document).ready(function () {
            var selectedIsPart = [];
            @if(!$isparts->isEmpty())
            @foreach($isprt as $isp)
                selectedIsPart.push('{{ $isp }}');
            @endforeach
            @endif
            $('#is_part').val(selectedIsPart).trigger('change');
            const checkbox = $('input.attribute');
            $(checkbox).on('change', function () {
                const attributeId = $(this).val();
                if ($(this).is(':checked')) {
                    $('#attributeValue' + attributeId).attr('disabled', false);
                } else {
                    $('#attributeValue' + attributeId).attr('disabled', true);
                }
                const count = checkbox.filter(':checked').length;
                if (count > 0) {
                    $('#productAttributeQuantity').attr('disabled', false);
                    $('#productAttributePrice').attr('disabled', false);
                    $('#salePrice').attr('disabled', false);
                    $('#default').attr('disabled', false);
                    $('#createCombinationBtn').attr('disabled', false);
                    $('#combination').attr('disabled', false);
                } else {
                    $('#productAttributeQuantity').attr('disabled', true);
                    $('#productAttributePrice').attr('disabled', true);
                    $('#salePrice').attr('disabled', true);
                    $('#default').attr('disabled', true);
                    $('#createCombinationBtn').attr('disabled', true);
                    $('#combination').attr('disabled', true);
                }
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/jquery.chained.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {

            //alert(car_submodel)
            /* For jquery.chained.js */
            $('#is_part option').prop('disabled', true);
            $("#car_model").chained("#brand_id");
            
            $("#brand_id").on('change', function(){
                //$('#is_part option').prop('disabled', false);
                $('#is_part').val('').change();
                $('#is_part option').prop('disabled', true);
                $('.checkbox-list').hide();
            });
            $("#car_model").on('change', function(){
                //$('#is_part option').prop('disabled', false);
                $('#is_part').val('').change();
                $('#is_part option').prop('disabled', true);
                $('.checkbox-list').hide();
            });
            $("#car_submodel").chained("#car_model");
            //$('#car_submodel').val(car_submodel).trigger('change');
            $('#car_submodel').on('change', function(){
                $('.checkbox-list').hide();
                $('#is_part').val('').change();
                var parts = $(this).find(':selected').data('parts');
                console.log(parts);
                if(parts != '' && parts != undefined){
                    $('#is_part option').prop('disabled', true);
                    parts = parts.split(',');
                    $.each(parts, function(index, value){
                        $('#is_part option[value="'+value+'"]').attr("disabled", false);
                    })
                }
            })
            $("#sub_part").chained("#is_part");
            $('#sub_part').on('change', function(){
                $('.checkbox-list').show();
                $('.checkbox-list li').hide();
                $('input[type=checkbox]:checked').removeAttr('checked');
                var piece = $(this).val();
                $('.piece-'+piece).show();
            });

            var car_submodel = parseInt('{{$product->car_submodel}}');
            var available_part = $('#car_submodel').find(':selected').data('parts')
            if(available_part != '' && available_part != undefined){
                $('#is_part option').prop('disabled', true);
                available_part = available_part.split(',');
                $.each(available_part, function(index, value){
                    $('#is_part option[value="'+value+'"]').attr("disabled", false);
                })
            }
            var sub_part = parseInt('{{$product->sub_part}}');
            if(sub_part){
                $('.checkbox-list').show();
                $('.checkbox-list li').hide();
                //var piece = $(this).val();
                $('.piece-'+sub_part).show();
            }
            $('#update_product').on('submit', function(){
                var selCat = $('input[name="categories[]"]:checked').length;
                //alert(selCat);
                /*return false;*/
                if(selCat == 0){
                    toast('Please select at-least one piece', 'error');
                    return false;
                }
            })
        });

        function selectCheck(ob, id){
            if(ob.value == "Other"){
                document.getElementById(id).style.display = 'block';
                document.getElementById(id).value = '';
                document.getElementById(id).setAttribute('name', 'shop_id');
            }
            else{
                document.getElementById(id).style.display = 'none';
                document.getElementById(id).removeAttribute('name');
            }
        }
    </script>
@endsection