<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}">
        <!-- App title -->
        <title>Transformation Talk Radio</title>

        <!--Morris Chart CSS -->

        <link href="{{ asset('public/css/component.css')}}"/>
        <link href="{{ asset('public/css/default.css')}}"/>
        <link href="{{ asset('public/css/archive.css')}}"/>
        
        <link rel="stylesheet" href="{{ asset('public/plugins/morris/morris.css') }}">

        <link href="{{ asset('public/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/font/formhelpers.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}">
        <!-- Custom box css -->
        <link href="{{ asset('public//plugins/custombox/css/custombox.min.css') }}" rel="stylesheet">

        <!-- Jquery filer css -->
        <link href="{{ asset('public/plugins/jquery.filer/css/jquery.filer.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" rel="stylesheet" />

        <!-- App css -->
        <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/assets/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/assets/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/assets/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
        <!-- Datatable reorder CSS -->
        <link href="{{ asset('public/css/rowReorder.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
        <!--   <link href="{{ asset('public/css/rowReorder.jqueryui.css') }}" rel="stylesheet" type="text/css" /> -->
        <!--   <link href="{{ asset('public/css/datatable_editor.css') }}" rel="stylesheet"  type="text/css" /> -->

        <link rel="stylesheet" href="{{ asset('public/plugins/switchery/switchery.min.css') }}">
        <!-- Select box css -->
        <link href="{{ asset('public/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
        <!-- Date Picker css -->
        <link href="{{ asset('public/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <!-- Cropper CSS-->
        <link href="{{ asset('public/css/cropper.css') }}" rel="stylesheet"/>
        <link href="{{ asset('public/css/main.css') }}" rel="stylesheet"/>
        <!--calendar css-->
        <link href="{{ asset('public/plugins/fullcalendar/css/fullcalendar.min.css')}}" rel="stylesheet" />
        <!-- Touchspin Css-->
        <link href="{{ asset('public/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
		 <!-- Chartist Css-->
		<link href="{{ asset('public/plugins/chartist/css/chartist.min.css')}}"/>
      
        <!-- JSTree Css-->
        <link href="{{ asset('public/css/jsthemes/default/style.min.css') }}" rel="stylesheet" />
        <!-- Date range picker -->
        <link href="{{ asset('public/css/daterangepicker.css') }}" rel="stylesheet" />
        <!-- Tooltipster css -->
        <link rel="stylesheet" href="{{ asset('public/plugins/tooltipster/tooltipster.bundle.min.css') }}">

        <style>
        .dropzone .dz-preview, .dropzone-previews .dz-preview {
            -webkit-box-shadow: 1px 1px 4px rgba(0,0,0,0.16);
            box-shadow: 1px 1px 4px rgba(0,0,0,0.16);
            font-size: 14px;
            margin-top: -6px !important;
            margin-left: -11px !important;
        }
            
        .help-block{
            font-size: 12px;
            float: left;
            margin-top: 12px;
            color: #999;
            text-shadow: none;
            box-shadow: none;
            border: 1px solid transparent;
            border-radius: 3px;
            padding: 0.5em;
            width: auto;
            transition: all 0.3s;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -ms-transition: all 0.3s;
            -o-transition: all 0.3s;
            position: relative;
        }

        .error-block{
            float: left;
            font-size: 12px;
            color: #FFFFFF;
            background-color: #bb4a48;
            display: none;
            text-shadow: none;
            box-shadow: none;
            border: 1px solid transparent;
            padding: 0.5em;
            width: auto;
            transition: all 0.3s;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -ms-transition: all 0.3s;
            -o-transition: all 0.3s;
            position: relative;
        }

        span.error-block:before {
            position: absolute;
            content: "";
            border-right: 8px solid #bb4a48;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
            left: -9px;
            top: 10px;
        }

        .help-block-active{
            background: #FFE669;
            border: 1px solid #ffd91d;
             /*border-color: rgba(255, 217, 29, 0);
            border-width: 8px;
            border-bottom-color: #ffd91d;
            left: 10%;
            margin-left: -8px;*/
        }

        .help-block-active:before {
            position: absolute;
            content: "";
            border-bottom: 8px solid #FFE669;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            left: 30px;
            top: -9px;
        }

        .toast-top-full-width{width: 100% !important;}

        /*.help-block-active:after {
            position: absolute;
            content: "";
            border-bottom: 8px solid #FFFFFF;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            left: 30px;
            top: -9px;
        }*/

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: none;
        }
        .error-msg{
            width: 100%;
            float: left;
        }
        /*.glyphicon {
            font-size: 25px;
            color: #DCDCDC;
        }*/
        
        .table_operation{ text-align: center !important; vertical-align: middle !important; }
        /*div#channeltable_filter {
            width: 100%;
            float: left;
            margin-left: 256px;
        }
        div#channeltable_paginate {
            width: 100%;
            float: left;
            margin-left: 256px;
            margin-top: -18px;
        }*/
        
        </style>
        @yield('header_scripts')
        <!-- Sweet Alert -->
        <link href="{{ asset('public/plugins/bootstrap-sweetalert/sweet-alert.css') }}" rel="stylesheet" type="text/css">
        <!-- Custom JS -->
        <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{ asset('public/js/modernizr.custom.js') }}"></script>
        
        <script>
            var APP_URL = {!! json_encode(url('/')) !!}
        </script>
        {{--@stack('builder_css')
        @include('kbuilder::layouts.includes_builder_top');--}}
    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="{{url('admin')}}" class="logo"><span>Ad<span>min</span></span><i class="mdi mdi-layers"></i></a>
                    <!-- Image logo -->
                    <!--<a href="index.html" class="logo">-->
                        <!--<span>-->
                            <!--<img src="assets/images/logo.png" alt="" height="30">-->
                        <!--</span>-->
                        <!--<i>-->
                            <!--<img src="assets/images/logo_sm.png" alt="" height="28">-->
                        <!--</i>-->
                    <!--</a>-->
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <!-- Navbar-left -->
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <button class="button-menu-mobile open-left waves-effect">
                                    <i class="mdi mdi-menu"></i>
                                </button>
                            </li>
                            <!--  <li class="hidden-xs">
                                <form role="search" class="app-search">
                                    <input type="text" placeholder="Search..."
                                           class="form-control">
                                    <a href=""><i class="fa fa-search"></i></a>
                                </form>
                            </li> -->                           
                        </ul>
                        <!-- Right(Notification) -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Studio app link -->
                            <li>
                                <a href="{{route('studio_channels')}}" class="right-menu-item" title="StudioApp">
                                    <i class="ion-mic-c"></i>
                                </a>
                            </li>

                            <li class="dropdown user-box">
                                <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                    {{--
                                    @if(Config::get('constants.HOST') == getCurrentUserType())
                                        <img src="{!! srcHostProfileImage(Auth::id(), 'Host', 'photo', '001.jpg') !!}" alt="user-img" class="img-circle user-img">
                                    @else
                                        <img src="{!! Auth::user()->photo() !!}" alt="user-img" class="img-circle user-img">
                                    @endif                                    
                                    --}}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                                    <li>
                                        <h5>Hi, {{ (!empty($info = getCurrentUserInfo()) ? $info['prefix']." ".$info['full_name']." ".$info['suffix'] : "")}}</h5>
                                    </li>
                                    @if(Config::get('constants.HOST') == getCurrentUserType())
                                    <li><a href="{{ route('edithostprofileform')}}"><i class="ti-user m-r-5"></i> Profile</a></li>
                                     <li><a href="#"><i class="ti-user m-r-5"></i>My Profile Custom Content</a></li>
                                    @else
                                    <li><a href="{{ route('editprofileform')}}"><i class="ti-user m-r-5"></i> Profile</a></li>
                                    @endif
                                    @if(Config::get('constants.ADMIN') == getCurrentUserType())
                                    <li><a href="{{route('changepassform')}}"><i class="ti-user m-r-5"></i> Change Password</a></li>
                                    @endif
                                    <li><a href="{{url('logout')}}"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul> <!-- end navbar-right -->
                    </div><!-- end container -->
                </div><!-- end navbar -->
            </div>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            
            <!-- ==========  Left Sidebar End  ===========-->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="container">
                <!-- Start content -->
                @yield('content')
                <footer class="footer text-right">
                    2018 - 2019 © <a target="_blank" href="http://www.contriverz.com/">Contriverz</a>.
                </footer>
            </div>

            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
            
            <!-- Right Sidebar -->
            <div class="side-bar right-bar">
                <a href="javascript:void(0);" class="right-bar-toggle">
                    <i class="mdi mdi-close-circle-outline"></i>
                </a>
                <h4 class="">Settings</h4>
                <div class="setting-list nicescroll">
                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">Notifications</h5>
                            <p class="text-muted m-b-0"><small>Do you need them?</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">API Access</h5>
                            <p class="m-b-0 text-muted"><small>Enable/Disable access</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">Auto Updates</h5>
                            <p class="m-b-0 text-muted"><small>Keep up to date</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">Online Status</h5>
                            <p class="m-b-0 text-muted"><small>Show your status to all</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Right-bar -->
        </div>
        <!-- END wrapper -->
        <script>
            var resizefunc = [];
        </script>
        <!-- jQuery  -->
        <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
        {{--<script src="{{ asset('public/assets/js/detect.js') }}"></script>
        <script src="{{ asset('public/assets/js/fastclick.js') }}"></script>
        <script src="{{ asset('public/assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('public/assets/js/waves.js') }}"></script>
        <script src="{{ asset('public/assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('public/assets/js/jquery.scrollTo.min.js') }}"></script>
        <script src="{{ asset('public/plugins/switchery/switchery.min.js') }}"></script>
        <!-- channnel page js file -->
        <script src="{{ asset('public/js/channel.js') }}"></script>
        <!-- channnel page js file -->
        <!-- common js for all page -->
        <script src="{{ asset('public/js/form_elements_ui.js') }}"></script>
        <!-- common js for all page -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <!-- Jquery filer js -->
        <script src="{{ asset('public/plugins/jquery.filer/js/jquery.filer.min.js') }}"></script>
        <!-- Counter js  -->
        <script src="{{ asset('public/plugins/waypoints/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('public/plugins/counterup/jquery.counterup.min.js') }}"></script>
        <!--Morris Chart-->
        <script src="{{ asset('public/plugins/morris/morris.min.js') }}"></script>
        <script src="{{ asset('public/plugins/raphael/raphael-min.js') }}"></script>
        <!-- Dashboard init -->
        <!-- <script src="{{ asset('public/assets/pages/jquery.dashboard.js') }}"></script> -->
        <!-- Sweet-Alert  -->
        <script src="{{ asset('public/plugins/bootstrap-sweetalert/sweet-alert.min.js') }}"></script>
        <!--Summernote js-->
        <script src="{{ asset('public//plugins/summernote/summernote.min.js') }}"></script>
        <!-- Date Picker JQUERY-->
        <script src="{{ asset('public/plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
       
        <!-- page specific js -->
        <!-- <script src="{{ asset('public/assets/pages/jquery.fileuploads.init.js') }}"></script> -->
        <script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/js/dataTables.rowReorder.min.js') }}"></script>
        <script src="{{ asset('public/js/dataTables.rowReorder.js') }}"></script>
        <script src="{{ asset('public/js/rowReorder.jqueryui.js') }}"></script>
        <!--  <script src="{{ asset('public/js/dataTables.editor.js') }}"></script>
        -->
        <script src="{{ asset('public/plugins/datatables/dataTables.bootstrap.js') }}"></script>

        <script src="{{ asset('public/plugins/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/buttons.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/dataTables.scroller.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/dataTables.colVis.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>
       <!--  <script src="{{ asset('public/js/dataTables.editor.js') }}"></script> -->
        
        <!--Wysiwig js-->
        <script src="{{ asset('public/plugins/tinymce/tinymce.min.js') }}"></script>
        <!-- init -->
        <!--  <script src="{{ asset('public/assets/pages/jquery.datatables.init.js') }}"></script> -->
        <script src="{{ asset('public/js/datatables.mark.js') }}"></script>
        <script src="{{ asset('public/js/jquery.mark.js') }}"></script>        
        <script src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('public/plugins/dropzone/css/dropzone.min.css') }}">
        <!-- <script src="{{ asset('public/plugins/dropzone/dropzone.min.js') }}"></script> -->
        <script src="{{ asset('public/plugins/dropzone/dropzone.min2.js') }}"></script>
        <!-- Modal-Effect -->
        <script src="{{ asset('public/plugins/custombox/js/custombox.min.js') }}"></script>
        <script src="{{ asset('public/plugins/custombox/js/legacy.min.js') }}"></script>
        <!-- CROPPER JS -->
        <script src="{{ asset('public/js/cropper.js') }}"></script>
        <script src="{{ asset('public/js/main.js') }}"></script>
        <!-- SELECT BOX JQUERY-->
        <script src="{{ asset('public/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('public/plugins/timepicker/bootstrap-timepicker.js') }}"></script>
        <script src="{{ asset('public/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('public/font/formhelpers.min.js') }}"></script>
        <!--  <script src="{{ asset('public/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
        <script src="{{ asset('public/plugins/jquery-quicksearch/jquery.quicksearch.js') }}"></script> -->
        <script src="{{ asset('public/plugins/bootstrap-select/js/bootstrap-select.min.js') }}">
        </script>       
        --}}
        @if(Session::has('success'))
            @include('backend.flash_message.success', array('msg' => Session::get('success')))
        @elseif(Session::has('error'))
            @include('backend.flash_message.error', array('msg' => Session::get('error')))
        @endif  
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        {{--
        <script src="{{ asset('public/plugins/tinymce/tinymce.min.js') }}"></script> 

        <!-- Mwdia Library Jquery-->
        <script src="{{ asset('public/js/masonry.pkgd.min.js') }}"></script>
        <script src="{{ asset('public/js/imagesloaded.js') }}"></script>
        <script src="{{ asset('public/js/classie.js') }}"></script>
        <script src="{{ asset('public/js/AnimOnScroll.js') }}"></script>


          <script src="{{ asset('public/plugins/tooltipster/tooltipster.bundle.min.js') }}"></script>

        <!-- Custom JS -->
        <script src="{{ asset('public/js/custom.js') }}"></script>
        <script src="{{ asset('public/js/passwordstrength.js') }}"></script>
        <script src="{{ asset('public/plugins/chartist/js/chartist.min.js')}}"></script>
        <script src="{{ asset('public/plugins/chartist/js/chartist-plugin-tooltip.min.js')}}"></script>
        <script src="{{ asset('public/js/chart.min.js')}}"></script>
        <!-- Calendar JS -->
        <script src="{{ asset('public/plugins/fullcalendar/js/fullcalendar.min.js')}}"></script>
        <script src="{{ asset('public/js/jquery.fullcalendar.js')}}"></script> 
        <!-- Touchspin JS -->
        <script src="{{ asset('public/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"></script> 
		<!-- validate JS -->
        <script src="{{ asset('public/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script> 
        <!-- JSTree -->
        <script src="{{ asset('public/js/jstree.min.js')}}"></script>
        <!-- Load more media js -->
      
        <script src="{{ asset('public/js/load_media.js')}}"></script>
        <script src="{{ asset('public/js/daterangepicker.min.js')}}"></script>
        <!-- App js -->
        <script src="{{ asset('public/assets/js/jquery.core.js') }}"></script>
        <script src="{{ asset('public/assets/js/jquery.app.js') }}"></script>

        <script type="text/javascript">
            var APP_URL = {!! json_encode(url('/')) !!};
            csrf_token  = '{!! csrf_token() !!}';
            var ROLE    = {!! getCurrentUserType() !!};
        </script>
        --}}
        @yield('footer_scripts')
        {{--
        @stack('builder_scripts')
        @include('kbuilder::layouts.includes_builder_bottom');
        @include('kbuilder::layouts.includes_sliderlayer_bottom');
        @include('kbuilder::layouts.includes_slide_bottom');
        --}}
        <div id="loadingDiv">
            <i class="fa fa-spin fa-spinner" ></i>
        </div>
    </body>
</html>