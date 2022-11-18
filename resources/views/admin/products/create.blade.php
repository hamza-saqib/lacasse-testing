@extends('layouts.admin.app')

@section('content')
    <style type="text/css">
        .checkbox-list {
            display: none;
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
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.products.store') }}" method="post" class="form" enctype="multipart/form-data" id="create_product">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <h2>Product</h2>
                        <div class="form-group">
                            <label for="item_number">Item Number <span class="text-danger">*</span></label>
                            <input type="text" name="item_number" id="item_number" placeholder="xxxxx" class="form-control" value="{{ old('item_number') }}" required="">
                        </div>
                        @if(!$shops->isEmpty())
                        <div class="form-group">
                            <label for="shop_id">Shop </label>
                            <select name="shop_id" id="shop_id" class="form-control " required="" onchange="selectCheck(this,'custom_b_t')">
                                <option value=""></option>
                                @foreach($shops as $shop)
                                    <option @if(old('shop_id') == $shop->id) selected="selected" @endif value="{{ $shop->id }}">{{ $shop->name }}</option>
                                @endforeach
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" id="custom_b_t" style="display: none;" placeholder="Shop" value="" class="form-control"> 
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="sku">Article Number <span class="text-danger">*</span></label>
                            <input type="text" name="sku" id="sku" placeholder="xxxxx" class="form-control" value="{{ old('sku') }}" required="">
                        </div>
                        <div class="form-group">
                            <label for="name">Name of Product <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ old('name') }}"  required="">
                        </div>
                        <div class="form-group">
                            <label for="summary">Summary</label>
                            <input type="text" name="summary" id="summary" placeholder="Short Description" class="form-control" value="{{ old('summary') }}" >
                        </div>
                        <div class="form-group">
                            <label for="description">Description </label>
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="cover">Cover </label>
                            <input type="file" name="cover" id="cover" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Images</label>
                            <input type="file" name="image[]" id="image" class="form-control" multiple>
                            <small class="text-warning">You can use ctr (cmd) to select multiple images</small>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quality <span class="text-danger">*</span></label>
                            <input type="text" name="quality" id="quality" placeholder="Quality" class="form-control" value="{{ old('quality') }}"  required="">
                        </div>
                        <div class="form-group">
                            <label for="price">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon">MAD</span>
                                <input type="text" name="price" id="price" placeholder="Price" class="form-control" value="{{ old('price') }}" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="transportation_price">Transportation price </label>
                            <div class="input-group">
                                <span class="input-group-addon">MAD</span>
                                <input type="text" name="transportation_price" id="transportation_price" placeholder="Price" class="form-control" value="{{ old('transportation_price') }}" >
                            </div>
                        </div>
                        @if(!$brands->isEmpty())
                        <div class="form-group">
                            <label for="brand_id">Car Brand </label>
                            <select name="brand_id" id="brand_id" class="form-control " required="">
                                <option value=""></option>
                                @foreach($brands as $brand)
                                    <option @if(old('brand_id') == $brand->id) selected="selected" @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="car_model">Car Model </label>
                            <select id="car_model" name="car_model" class="form-control " required="">
                                <option value="">--</option>
                                @foreach($carModels as $cm)
                                    <option @if(old('car_model') == $cm->id) selected="selected" @endif value="{{ $cm->id }}" data-chained="{{$cm->parent_id}}">{{ $cm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="car_submodel">Car Sub-model </label>
                            <select id="car_submodel" name="car_submodel" class="form-control " required="">
                                <option value="">--</option>
                                @foreach($carSubModels as $csm)
                                    <option @if(old('car_model') == $cm->id) selected="selected" @endif value="{{ $csm->id }}" data-chained="{{$csm->parent_id}}" data-parts="{{ $csm->available_part}}">{{ $csm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Is part field -->
                        @if(!$isparts->isEmpty())
                        <div class="form-group">
                            <label for="is_part">Car Part </label>
                            <!-- <select name="is_part[]" id="is_part" class="form-control select2" multiple="multiple"> -->
                            <select name="is_part[]" id="is_part" class="form-control " required="">
                                <option value="">--</option>
                                @foreach($isparts as $ispart)
                                    <option @if(old('is_part') == $brand->id) selected="selected" @endif value="{{ $ispart->id }}" data-chained="{{ available_parts($ispart->parent_id) }}">{{ $ispart->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="sub_part">Sub-part </label>
                            <select id="sub_part" name="sub_part" class="form-control " required="">
                                <option value="">--</option>
                                @foreach($sub_parts as $sp)
                                    <option @if(old('car_model') == $sp->id) selected="selected" @endif value="{{ $sp->id }}" data-chained="{{$sp->parent_id}}">{{ $sp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="C">Piece </label>
                            @include('admin.shared.categories', ['categories' => $categories, 'selectedIds' => []])
                        </div>


                        @include('admin.shared.status-select', ['status' => 0])
                        @include('admin.shared.attribute-select', [compact('default_weight')])
                    </div>
                    {{--
                    <div class="col-md-4">
                        <h2>Categories</h2>
                        @include('admin.shared.categories', ['categories' => $categories, 'selectedIds' => []])
                    </div>
                    --}}
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
@section('js')
    <script type="text/javascript" src="{{ asset('js/toast-notify.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.chained.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
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
            $('#car_submodel').on('change', function(){
                $('.checkbox-list').hide();
                $('#is_part').val('').change();
                var parts = $(this).find(':selected').data('parts');
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
                var piece = $(this).val();
                $('.piece-'+piece).show();
            });
            $('#create_product').on('submit', function(){
                var selCat = $('input[name="categories[]"]:checked').length;
                //alert(selCat);
                /*return false;*/
                if(selCat == 0){
                    toast('Please select at-least one piece', 'error');
                    return false;
                }
            })
        });

        $(document).ready(function(){
            // if(document.getElementById("business_type").value == "Other"){
            //     document.getElementById("custom_b_t").style.display = 'block';
            //     // document.getElementById(id).setAttribute('name', 'business_type');
            // }
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