@extends('layouts.admin.app')



@section('content')

    <!-- Main content -->

    <section class="content">

        @include('layouts.errors-and-messages')

        <div class="box">

            <form action="{{ route('admin.categories.update', $category->id) }}" method="post" class="form" enctype="multipart/form-data"  onsubmit="$('select').attr('disabled', false);">

                <div class="box-body">

                    <input type="hidden" name="_method" value="put">

                    {{ csrf_field() }}

                    <input type="hidden" name="type" value="{{$type}}">

                    @if($type == 'brand')

                        <input type="hidden" name="parent" value="0">

                    @else

                        <div class="form-group">

                            <label for="parent">Select Brand </label>

                            <select name="parent" id="parent" class="form-control select2" disabled="">

                                @foreach($brands as $cat)

                                    <option @if($cat->id == $category->parent_id) selected="selected" @endif value="{{$cat->id}}">{{$cat->name}}</option>

                                @endforeach

                            </select>

                        </div>

                    @endif

                    <div class="form-group">

                        <label for="name">{{ ucwords($type) }} Name <span class="text-danger">*</span></label>

                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $category->name ?: old('name')  !!}">

                    </div>

                    <div class="form-group hide">

                        <label for="description">Description </label>

                        <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description">{!! $category->description ?: old('description')  !!}</textarea>

                    </div>

                    @if(isset($category->cover) && $category->cover != '')

                    <div class="form-group hide">

                        <img src="{{ asset("storage/$category->cover") }}" alt="" class="img-responsive"> <br/>
                        @if(isset($category->cover) && $category->cover != '')
                        <a onclick="return confirm('Are you sure?')" href="{{ route('admin.category.remove.image', ['category' => $category->id]) }}" class="btn btn-danger">Remove image?</a>
                        @endif
                    </div>

                    @endif

                    <div class="form-group hide">

                        <label for="cover">Cover </label>

                        <input type="file" name="cover" id="cover" class="form-control">

                    </div>

                    <div class="form-group">

                        <label for="status">Status </label>

                        <select name="status" id="status" class="form-control">

                            <option value="0" @if($category->status == 0) selected="selected" @endif>Disable</option>

                            <option value="1" @if($category->status == 1) selected="selected" @endif>Enable</option>

                        </select>

                    </div>

                    @if($type == 'carmodel')

                        <input type="hidden" name="is_part" value="0">

                        <input type="hidden" name="show_on_product" value="0">

                        <input type="hidden" name="available_part[]" value="">

                    @else



                        <div class="form-group">

                            <label for="status">Is Part Group </label>

                            <select name="is_part" id="is_part" class="form-control">

                                <option value="0" @if($category->is_part == 0) selected="selected" @endif>No</option>

                                <option value="1" @if($category->is_part == 1) selected="selected" @endif>Yes</option>

                            </select>

                        </div>

                        <div class="form-group">

                            <label for="status">Show in Products</label>

                            <select name="show_on_product" id="show_on_product" class="form-control">

                                <option value="0" @if($category->show_on_product == 0) selected="selected" @endif>No</option>

                                <option value="1" @if($category->show_on_product == 1) selected="selected" @endif>Yes</option>

                            </select>

                        </div>

                        @if(!$isparts->isEmpty())

                            <?php 

                            $available_part = explode(',', $category->available_part);

                            ?>

                            <div class="form-group" id="available_part_group" >

                                <label for="available_part">Available Parts Group </label>

                                <select name="available_part[]" id="available_part" class="form-control select2" multiple="multiple">

                                    <option value=""></option>

                                    @foreach($isparts as $ispart)

                                        <option value="{{ $ispart->id }}">{{ $ispart->name }}</option>

                                    @endforeach

                                </select>

                            </div>

                        @endif

                    @endif

                </div>

                <!-- /.box-body -->

                <div class="box-footer">

                    <div class="btn-group">

                        <a href="{{ url('admin/categories/'.$category->parent_id.'?type=carmodel') }}" class="btn btn-default">Back</a>

                        <button type="submit" class="btn btn-primary">Update</button>

                    </div>

                </div>

            </form>

        </div>

        <!-- /.box -->



    </section>

    <!-- /.content -->

@endsection

@section('js')

    <script type="text/javascript">

        $(document).ready(function () {

            <?php /*

            var temp = parseInt($('#is_part').val());

            //alert(temp)

            if(temp) $('#available_part_group').hide();

            else $('#available_part_group').show();

            var selectedIsPart = [];

            @foreach($available_part as $isp)

                selectedIsPart.push('{{ $isp }}');

            @endforeach

            $('#available_part').val(selectedIsPart).trigger('change');

            //$('#available_part_group').hide();

            $('#is_part').trigger('change');

            $('#is_part').on('change', function () {

                var isPart = parseInt($(this).val());

                //alert(typeof(isPart)+" "+isPart)

                if(isPart){

                    $('#available_part').val([]).trigger('change');

                    $('#available_part_group').hide();

                }

                else{

                    $('#available_part_group').show();

                }

            });

            */?>

        });

    </script>

@endsection