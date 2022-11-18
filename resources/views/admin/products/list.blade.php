@extends('layouts.admin.app')



@section('content')
    <br>
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $noOfActiveProducts }}</h3>

                        <p>Total Active Products</p>

                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalActiveAmount }}</h3>

                        <p>Total Active Amount (MAD)</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $noOfProducts }}</h3>

                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalAmount }}</h3>

                        <p>Total Amount (MAD)</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

    </div><!-- /.container-fluid -->
    <!-- Main content -->

    <section class="content">

        @include('layouts.errors-and-messages')

        <!-- Default box -->

        @if (!$products->isEmpty())
            <div class="box">

                <div class="box-body">

                    <h2>Products</h2>

                    @include('layouts.search', ['route' => route('admin.products.index')])

                    @include('admin.shared.products')

                    {{ $products->links() }}

                </div>

                <!-- /.box-body -->

            </div>

            <!-- /.box -->
        @endif



    </section>

    <!-- /.content -->
@endsection
