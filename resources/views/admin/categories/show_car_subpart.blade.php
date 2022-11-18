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
                        <li class="completed"><a href="{{ url('admin/partgroups') }}">Part Groups</a></li>
                        <li class="completed"><a href="javascript:void(0);"> {{ $category->name }}</a></li>
                    </ul>
                </div>
                <hr>
                <div class="box-body">
                    <h2>Sub Parts
                         <a style="float:right;" class="btn btn-success btn-sm" href="{{ url('admin/categories/create?type=sub_part&pid='.$category->id) }}"><i class="fa fa-plus"></i> Create Sub Part</a>
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
                                            <a class="btn btn-primary" href="{{url('admin/categories/'.$cat->id.'?type=part_piece&pid='.$partId)}}">View Piece</a>
                                            <a class="btn btn-primary" href="{{ url('admin/categories/'.$cat->id.'/edit?type=sub_part&pid='.$category->id)}}"><i class="fa fa-edit"></i> Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="post" class="form-horizontal" style="display: inline-block;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="delete">
                                                <input type="hidden" name="type" value="car_subpart">
                                                <input type="hidden" name="pid" value="{{$category->id}}">
                                                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="2">There are no sub parts for this Car sub-model</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                {{--
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
