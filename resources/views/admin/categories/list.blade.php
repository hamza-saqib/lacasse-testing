@extends('layouts.admin.app')



@section('content')

    <!-- Main content -->

    <section class="content">

    @include('layouts.errors-and-messages')

    <!-- Default box -->

        @if($categories)

            <div class="box">

                <div class="box-body">

                    <h2>Brands

                        <a style="float:right;" class="btn btn-success btn-sm" href="{{ url('admin/categories/create?type=brand') }}"><i class="fa fa-plus"></i> Create Brand</a>

                    </h2>

                    <table class="table1">

                        <thead>

                            <tr>

                                <td class="col-md-3">Name </td>

                                <!-- <td class="col-md-3">Cover</td>

                                <td class="col-md-3">Status</td> -->

                                <td class="col-md-3">Actions</td>

                            </tr>

                        </thead>

                        <tbody>

                        @foreach ($categories as $category)

                            <tr>

                                <td>

                                    {{--<a href="{{ route('admin.categories.show', $category->id) }}">{{ $category->name }}</a></td>--}}

                                    {{ $category->name }}

                                {{--

                                <td>

                                    @if(isset($category->cover)  && !empty($category->cover))

                                        <img src="{{ asset("storage/$category->cover") }}" alt="" class="img-responsive">

                                    @endif

                                </td>--}}

                                {{--<td>@include('layouts.status', ['status' => $category->status])</td>--}}

                                <td>

                                    <a href="{{ url('admin/categories/'.$category->id.'?type=carmodel') }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> View Car Models</a>

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" class="form-horizontal" style="display: inline-block;">

                                        {{ csrf_field() }}

                                        <input type="hidden" name="_method" value="delete">

                                        <div class="btn-group">

                                            <!-- <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a> -->

                                            <a href="{{ url('admin/categories/'.$category->id.'/edit?type=brand') }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>

                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>

                                        </div>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                    {{ $categories->links() }}

                </div>

                <!-- /.box-body -->

            </div>

            <!-- /.box -->

        @endif



    </section>

    <!-- /.content -->

@endsection

