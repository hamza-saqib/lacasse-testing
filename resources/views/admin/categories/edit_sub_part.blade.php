@extends('layouts.admin.app')



@section('content')

    <!-- Main content -->

    <section class="content edit-sub">

        @include('layouts.errors-and-messages')

        <div class="box">

            <form action="{{ route('admin.categories.update', $category->id) }}" method="post" class="form" enctype="multipart/form-data" onsubmit="$('select').attr('disabled', false);">

                <div class="box-body">

                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="put">

                    <input type="hidden" name="type" value="{{$type}}">

                    <input type="hidden" name="pid" value="{{$pid}}">

                    <div class="form-group">

                        <label for="parent">Selected Car Part</label>

                        <select name="parent" id="parent" class="form-control select2" disabled="">

                            <option value="">-- Select --</option>

                            @foreach($carParts as $cat)

                                <option @if($cat->id == $pid) selected="selected" @endif value="{{ $cat->id }}">{{ $cat->name }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="name">{{ ucwords($type) }} Name <span class="text-danger">*</span></label>

                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $category->name !!}" required="">

                    </div>

                    <div class="form-group hide">

                        <label for="description hide">Description </label>

                        <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description">{{ old('description') }}</textarea>

                    </div>

                    <div class="form-group hide">


                       
                        
                        <label for="cover">Cover {{$category->cover}} </label>

                        <input type="file" name="cover" id="cover" class="form-control">
               
                    </div>

                    <div class="form-group">

                        <label for="status">Status </label>

                        <select name="status" id="status" class="form-control">

                            <option value="0" @if($category->status == 0) selected="selected" @endif>Disable</option>

                            <option value="1" @if($category->status == 1) selected="selected" @endif>Enable</option>

                        </select>

                        <input type="hidden" name="old_cover" value="{{$cat_data->id}}"/>

                    </div>

                    @if($type == 'sub_part')

                        <input type="hidden" name="is_part" value="0">

                        <input type="hidden" name="show_on_product" value="0">

                        <input type="hidden" name="available_part[]" value="">

                    @else

                        {{--

                        <div class="form-group">

                            <label for="status">Is Part Group </label>

                            <select name="is_part" id="is_part" class="form-control">

                                <option value="0">No</option>

                                <option value="1">Yes</option>

                            </select>

                        </div>

                        <div class="form-group">

                            <label for="status">Show in Products</label>

                            <select name="show_on_product" id="show_on_product" class="form-control">

                                <option value="0">No</option>

                                <option value="1">Yes</option>

                            </select>

                        </div>



                        @if(!$isparts->isEmpty())

                        <div class="form-group" id="available_part_group" >

                            <label for="available_part">Available Parts category </label>

                            <select name="available_part[]" id="available_part" class="form-control select2" multiple="multiple">

                                <option value=""></option>

                                @foreach($isparts as $ispart)

                                    <option value="{{ $ispart->id }}">{{ $ispart->name }}</option>

                                @endforeach

                            </select>

                        </div>

                        @endif

                        --}}

                    @endif

                </div>

                <!-- /.box-body -->

                <div class="box-footer">

                    <div class="btn-group">

                        <a href="{{ url('admin/categories/'.$pid.'?type=car_subpart') }}" class="btn btn-default">Back</a>

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

            /*$('#available_part_group').hide();

            $('#is_part').on('change', function () {

                var isPart = parseInt($(this).val());

                //alert(typeof(isPart)+" "+isPart)

                if(isPart){

                    $('#available_part_group').show();

                }

                else

                {

                    $('#available_part_group').hide();

                }

            });*/

        });

    </script>

@endsection