@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.categories.store') }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="{{$type}}">
                    @if($type == 'carparts')
                        <input type="hidden" name="parent" value="">
                    @else
                        <div class="form-group">
                            <label for="parent">Parent Category</label>
                            <select name="parent" id="parent" class="form-control select2">
                                <option value="">-- Select --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="name">{{ ucwords($type) }} Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group hide">
                        <label for="description">Description </label>
                        <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
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
                    @if($type == 'carparts')
                        <input type="hidden" name="is_part" value="1">
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
                    @endif
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ url('admin/partgroups') }}" class="btn btn-default">Back</a>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#available_part_group').hide();
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
            });
        });
    </script>
@endsection