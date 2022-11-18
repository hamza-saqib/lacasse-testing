@extends('layouts.admin.app')



@section('content')

    <!-- Main content -->

    <section class="content">

        @include('layouts.errors-and-messages')

        <!-- Default box -->

        @if (!$shops->isEmpty())
            <div class="box">

                <div class="box-body">

                    <h2>Shops</h2>

                    @include('layouts.search', ['route' => route('admin.products.index')])

                    <table class="table">

                        <thead>

                            <tr>

                                <td>ID</td>

                                <td>Name</td>

                                <td>No of Products</td>

                                <td>Total Orders</td>
                                <td>Completed Orders</td>
                                <td>Amount Recieved</td>
                                <td>Actions</td>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($shops as $shop)
                                <tr>

                                    <td>{{ $shop->id }}</td>
                                    <td>{{ $shop->name }}</td>
                                    <td>{{ $shop->noOfProducts }}</td>
                                    <td>{{ $shop->noOfOrders }}</td>
                                    <td>{{ $shop->noOfCompletedOrders }}</td>
                                    <td>{{ $shop->totalCompletedOrdersAmount }}</td>


                                    <td>
                                        <form action="{{ route('admin.shops.destroy', $shop['id']) }}" method="post"
                                            class="form-horizontal">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">

                                                <a href="{{ route('admin.shops.products', $shop->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Products</a>
                                                <a href="{{ route('admin.shops.orders', $shop->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Order</a>
                                                <a href="{{ route('admin.shops.edit', $shop->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <button onclick="return confirm('Are you sure?')" type="submit"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-times"></i>
                                                    Delete</button>

                                            </div>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                    {{ $shops->links() }}

                </div>

                <!-- /.box-body -->

            </div>

            <!-- /.box -->
        @endif



    </section>

    <!-- /.content -->

@endsection
