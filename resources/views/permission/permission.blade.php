@extends('layouts.main')

@section('title', 'Permission')
@section('subTitle', 'create new permission')

@push('headCss')
 <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
@endpush
@section('content')
<div class="row">
 	<div class="col-md-12">
                            <div class="tabbable-line boxless tabbable-reversed">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_0" data-toggle="tab">
                                            Create Permission </a>
                                    </li>
                                   
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_0">
                                        <div class="portlet box green">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-gift"></i>Permission  {{ session('status') }}
                                                </div>
                                                <div class="tools">
                                                    <a href="javascript:;" class="collapse">
                                                    </a>
                                                    <a href="#portlet-config" data-toggle="modal" class="config">
                                                    </a>
                                                    <a href="javascript:;" class="reload">
                                                    </a>
                                                    <a href="javascript:;" class="remove">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                                                <form method="POST" class="form-horizontal" action="{{ url('/create_permission') }}">
                                                {{ csrf_field() }}
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Permission Name</label>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control input-circle" placeholder="Name of permission" name="name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label"> permission display name</label>
                                                            <div class="col-md-4">
                                                                
                                                                 <input type="text" class="form-control input-circle" placeholder="Permission display name" name="display_name">
                                                                   
                                                                
                                                            </div>
                                                        </div>
                                                      
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">description</label>
                                                            <div class="col-md-4">
                                                                <div class="input-icon">
                                                                    <input type="text" class="form-control input-circle" placeholder="description" name="description">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn btn-circle blue">Submit</button>
                                                                <button type="button" class="btn btn-circle default">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- END FORM-->
                                            </div>
                                        </div>
                                        
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
</div>
@endsection
@push('footerJs')
 <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
  <script>
            jQuery(document).ready(function () {
                // initiate layout and plugins
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                QuickSidebar.init(); // init quick sidebar
                Demo.init(); // init demo features
                FormSamples.init();
            });
 </script>
@endpush