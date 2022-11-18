@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($category)
            <div class="box">
                <div class="box-body">
                    <ul class="breadcrumb wizard">
                        <li class="completed"><a href="{{ url('admin/categories') }}">Brands</a></li>
                        <li class="completed"><a href="{{ url('admin/categories/'.$brand->id.'?type=carmodel') }}">{{ $brand->name }}</a></li>
                        <li class="completed"><a href="{{ url('admin/categories/'.$model->id.'?type=carsubmodel') }}"> {{ $model->name }}</a></li>
                        <li class="completed"><a href="{{ url('admin/categories/'.$subModel->id.'?type=carparts') }}"> {{ $subModel->name }}</a></li>
                        <li class="completed"><a href="{{ url('admin/categories/'.$subpart->id.'?type=sub_part&pid='.$partId) }}"> {{ $subpart->name }}</a></li>
                        <li class="completed"><a href="javascript:void(0);"> {{ $category->name }}</a></li>
                    </ul>
                    <p style="color: #f00;margin: 0 12px;">Note: You can not add/delete piece in this section as you can add sub-parts under part group section</p>
                </div>
                <hr>
                <div class="box-body">
                    <h2>Piece</h2>
                    <table class="table1">
                        <thead>
                        <tr>
                            <td class="col-md-3">Name</td>
                            <td class="col-md-3">Status</td>
                            <td class="col-md-3">Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!$categories->isEmpty())
                                @foreach($categories as $cat)
                                    <tr>
                                        <td>
                                            {{--<a href="{{route('admin.categories.show', $cat->id)}}">{{ $cat->name }}</a>--}}
                                            {{ $cat->name }}
                                        </td>
                                        <td>@include('layouts.status', ['status' => $cat->status])</td>
                                        <td>N/A
                                            {{--
                                            <a class="btn btn-primary" href="{{route('admin.categories.edit', $cat->id)}}"><i class="fa fa-edit"></i> Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="post" class="form-horizontal" style="display: inline-block;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="delete">
                                                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                            </form>
                                            --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="2">There are no sub parts for this Car sub-model</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
               
                @if(!$products->isEmpty())
                    <div class="box-body">
                        <h2>Products</h2>
                        @include('admin.shared.products', ['products' => $products])
                    </div>
                @endif
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default btn-sm">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
