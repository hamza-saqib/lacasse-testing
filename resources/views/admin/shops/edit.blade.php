@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.shops.update', $shop->id) }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" required name="name" id="name" placeholder="Name" class="form-control" value="{!! $shop->name ?: old('name')  !!}">
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" required id="status" class="form-control">
                            <option value="0" @if($shop->status == 0) selected @endif>Disable</option>
                            <option value="1" @if($shop->status == 1) selected @endif>Enable</option>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.shops.index') }}" class="btn btn-default btn-sm">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
