@extends('layouts.admin.app')



@section('content')

    <!-- Main content -->

    <section class="content">

    @include('layouts.errors-and-messages')

    <!-- Default box -->

        @if(!$shops->isEmpty())

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
                
                                    <div class="btn-group">

                                        <a href="{{ route('admin.shops.products', $shop->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Products</a>
                                        <a href="{{ route('admin.shops.show', $shop->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Shop</a>
            
            
                                    </div>
                
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

