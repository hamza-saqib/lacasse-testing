@extends('layouts.admin.app')



@section('content')

    <!-- Main content -->

    <section class="content">

        @include('layouts.errors-and-messages')

        <div class="box">

            <form action="{{ route('admin.addresses.store') }}" method="post" class="form" enctype="multipart/form-data">

                <div class="box-body">

                    {{ csrf_field() }} 
                    <meta name="_token" content="{{ csrf_token() }}" />

                    <div class="form-group">

                        <label for="customer">Customers </label>

                        <select name="customer" id="status" class="form-control select2">

                            @foreach($customers as $customer)

                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="alias">Alias <span class="text-danger">*</span></label>

                        <input type="text" name="alias" id="alias" placeholder="Home or Office" class="form-control" value="{{ old('alias') }}">

                    </div>

                    <div class="form-group">

                        <label for="address_1">Address 1 <span class="text-danger">*</span></label>

                        <input type="text" name="address_1" id="address_1" placeholder="Address 1" class="form-control" value="{{ old('address_1') }}">

                    </div>

                    <div class="form-group">

                        <label for="address_2">Address 2 </label>

                        <input type="text" name="address_2" id="address_2" placeholder="Address 2" class="form-control" value="{{ old('address_2') }}">

                    </div>

                    <div class="form-group">

                        <label for="country_id">Country </label>

                        <select name="country_id" id="country_id" class="form-control">
                        
                        <option value="">Select Country</option>

                            @foreach($countries as $country)

                                <option value="{{ $country->id }}">{{ $country->name }}</option>

                            @endforeach

                        </select>

                    </div>

                    <!-- <div class="form-group">

                        <label for="province_id">Province </label>

                        <select name="province_id" id="province_id" class="form-control" disabled>

                            @foreach($provinces as $province)

                                <option value="{{ $province->id }}">{{ $province->name }}</option>

                            @endforeach

                        </select>

                    </div> -->

                   <div class="form-group">

                     <label for="province_id">Province </label>

                        <select name="province_id" id="province_id" class="form-control" >  

                            <option value="">Select Province</option>

                        </select>

                    </div>

                    <div class="form-group">

                     <label for="province_id">City </label>

                        <select name="city_id" id="city_id" class="form-control" >  

                            <option value="">Select City</option>

                        </select>

                    </div>

                 <!--    <div id="cities" class="form-group">

                        <label for="city_id">City </label>

                        <select name="city_id" id="city_id" class="form-control" disabled>

                            @foreach($cities as $city)

                                <option value="{{ $city->id }}">{{ $city->name }}</option>

                            @endforeach

                        </select>

                    </div> -->

                    <div class="form-group">

                        <label for="zip">Zip Code </label>

                        <input type="text" name="zip" id="zip" placeholder="Zip code" class="form-control" value="{{ old('zip') }}">

                    </div>

                    <div class="form-group">

                        <label for="status">Status </label>

                        <select name="status" id="status" class="form-control">

                            <option value="0">Disable</option>

                            <option value="1">Enable</option>

                        </select>

                    </div>

                </div>

                <!-- /.box-body -->

                <div class="box-footer">

                    <div class="btn-group">

                        <a href="{{ route('admin.addresses.index') }}" class="btn btn-default">Back</a>

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


    </script>

     <script>
        jQuery(document).ready(function(){
            jQuery('#country_id').change(function(e){
             var id = $('#country_id').val();
             e.preventDefault();
            $.ajax({
                           type:'POST',
                           url: "{{ url('admin/addresses/province') }}" ,             
                           data: {id : id , _token : $('meta[name="_token"]').attr('content') } ,
                           success:function(data) {
                              $('#province_id').html(data);
                           }
                        });
               });
            });

    </script>


     <script>
        jQuery(document).ready(function(){
            jQuery('#province_id').change(function(e){
             var id = $('#province_id').val();
             e.preventDefault();
            $.ajax({
                           type:'POST',
                           url: "{{ url('admin/addresses/city') }}" ,             
                           data: {id : id , _token : $('meta[name="_token"]').attr('content') } ,
                           success:function(data) {
                              $('#city_id').html(data);
                           }
                        });
               });
            });

    </script>

@endsection

