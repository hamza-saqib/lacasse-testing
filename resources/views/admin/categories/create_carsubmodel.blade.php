@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.categories.store') }}" method="post" class="form" enctype="multipart/form-data" onsubmit="$('select').attr('disabled', false);">
                <div class="box-body">
                    <!-- <input type="hidden" name="_method" value="put"> -->
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="{{$type}}">
                    <input type="hidden" name="mid" value="{{$mid}}">
                    <input type="hidden" name="bid" value="{{$bid}}">
                    <div class="form-group">
                        <label for="parent">Brand</label>
                        <select name="brand" id="brand" class="form-control" disabled="">
                            @foreach($brands as $cat)
                                <option value="{{$cat->id}}" @if($bid == $cat->id) selected="selected" @endif>{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="parent">Car Model</label>
                        <select name="parent" id="parent" class="form-control" required=""  disabled="">
                            @foreach($carmodels as $cm)
                                <option value="{{$cm->id}}" data-chained="{{$cm->parent_id}}"  @if($mid == $cm->id) selected="selected" @endif>{{$cm->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">{{ ucwords($type) }} Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="" required="">
                    </div>
                    <div class="form-group hide">
                        <label for="description">Description </label>
                        <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group hide">
                        <label for="cover">Cover </label>
                        <input type="file" name="cover" id="cover" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status">Status </label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">Disable</option>
                            <option value="1">Enable</option>
                        </select>
                    </div>
                    @if($type == 'carsubmodel')
                        <input type="hidden" name="is_part" value="0">
                        <input type="hidden" name="show_on_product" value="0">
                        <input type="hidden" name="available_part[]" value="">
                    @else
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
                            <?php 
                            //$available_part = explode(',', $category->available_part);
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
                        <a href="{{ url('admin/categories/'.$mid.'?type=carsubmodel') }}" class="btn btn-default">Back</a>
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
    <script type="text/javascript" src="{{ asset('js/jquery.chained.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            /* For jquery.chained.js */
            //$("#parent").chained("#brand");
        });
    </script>

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