@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <style type="text/css">
        .checkbox-list {list-style-type: none;padding-left: 0;min-height: 350px;height: auto;overflow: auto;}
        .checkbox-list li{ width: 33%; float: left; }
        input#select-all {margin: 0 8px 0 0; position: relative; float: left;top: 4px;}
    </style>
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <div class="box-body">
                <ul class="breadcrumb wizard">
                    <li class="completed"><a href="{{ url('admin/categories') }}">Brands</a></li>
                    <li class="completed"><a href="{{ url('admin/categories/'.$brand->id.'?type=carmodel') }}">{{ $brand->name }}</a></li>
                    <li class="completed"><a href="{{ url('admin/categories/'.$subModel->id.'?type=carsubmodel') }}"> {{ $subModel->name }}</a></li>
                    <li class="completed"><a href="javascript:void(0);"> {{ $category->name }}</a></li>
                </ul>
            </div>
            <hr>
            <form action="{{ url('admin/saveParts') }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="type" value="{{$type}}">
                    <input type="hidden" name="smid" value="{{$smid}}">
                    <div class="form-group" id="available_part_group" >
                        <label for="available_part">Available Parts category </label>
                        <br/><br/>
                        <label for="available_part">Include All <input type="checkbox" id="select-all"></label>
                        @php
                        $available_parts = explode(',', $category->available_part);
                        @endphp
                        {{--
                        <select name="available_part[]" id="available_part" class="form-control select2" multiple="multiple">
                            <option value=""></option>
                            @foreach($carParts as $ispart)
                                <option @if(in_array($ispart->id, $available_parts)) selected="selected" @endif value="{{ $ispart->id }}">{{ $ispart->name }}</option>
                            @endforeach
                        </select>
                        --}}
                        <ul class="checkbox-list">
                            @foreach($carParts as $ispart)
                                <li class="">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"
                                                    @if(in_array($ispart->id, $available_parts))checked="checked" @endif
                                                    name="available_part[]"
                                                    value="{{ $ispart->id }}" >
                                            {{ $ispart->name }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ url('admin/categories/'.$smid.'?type=carparts') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Assign</button>
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
            $('#select-all').on('click', function(){
                if($(this).prop("checked") == true){
                    //console.log("Checkbox is checked.");
                    $('input[name="available_part[]"]').prop('checked', true);
                }
                else if($(this).prop("checked") == false){
                    $('input[name="available_part[]"]').prop('checked', false);
                    //console.log("Checkbox is unchecked.");
                }
            })
        });
    </script>
@endsection