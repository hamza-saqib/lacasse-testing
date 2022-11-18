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
                        <li class="completed"><a href="javascript:void(0);"> {{ $category->name }}</a></li>
                    </ul>
                </div>
                <hr>
                <div class="box-body">
                    <h2>Car Sub-Models
                        <a style="float:right;" class="btn btn-success btn-sm" href="{{ url('admin/categories/create?type=carsubmodel&mid='.$category->id.'&bid='.$brand->id) }}"><i class="fa fa-plus"></i> Create Car Sub-model</a>
                    </h2>
                    <table class="table1">
                        <thead>
                        <tr>
                            <td class="col-md-3">Name</td>
                            {{--<td class="col-md-3">Status</td>--}}
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
                                        {{--<td>@include('layouts.status', ['status' => $cat->status])</td>--}}
                                        <td>
                                            <a class="btn btn-primary" href="{{url('admin/categories/'.$cat->id.'?type=carparts')}}">View Car Parts</a>
                                            <a class="btn btn-primary" href="{{url('admin/categories/'.$cat->id.'/edit?type=carsubmodel&mid='.$category->id.'&bid='.$brand->id) }}"><i class="fa fa-edit"></i> Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="post" class="form-horizontal" style="display: inline-block;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="delete">
                                                    <input type="hidden" name="type" value="carsubmodel">
                                                    <input type="hidden" name="mid" value="{{$category->id}}">
                                                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                                </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="2">There are no sub-models for this Car model</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                {{--
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
                --}}
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
