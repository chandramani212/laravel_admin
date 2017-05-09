@extends('layouts.main')
@section('title', 'Set Role to user')
@section('subTitle', 'Assign Role')
@push('headCss')

<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css')}}"/>
<!-- BEGIN THEME STYLES -->
<link href="{{ URL::asset('assets/global/css/components.css')}}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/admin/layout/css/layout.css')}}" rel="stylesheet" type="text/css"/>
<link id="style_color" href="{{ URL::asset('assets/admin/layout/css/themes/darkblue.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/admin/layout/css/custom.css')}}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
@endpush

@section('content')
<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Assign role || {{ session('status') }}
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
							<form action="{{ url('/set_userpermission') }}"  method="post" class="form-horizontal form-row-seperated">
							 {{ csrf_field() }}
								<div class="form-body">

									<div class="form-group">
										<label class="control-label col-md-3">User</label>
										<div class="col-md-4">
											<select class="form-control input-medium select2me" data-placeholder="Select..." name="user">
												<option value=""></option>
												@foreach($users as $user)
												<option value="{{ $user->id }}">{{ $user->name }}</option>
												@endforeach
											</select>
											
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Role</label>
										<div class="col-md-4">
											<select class="form-control input-medium select2me" data-placeholder="Select..." name="role">
												<option value=""></option>
												@foreach($roles as $role)
												<option value="{{$role->id}}">{{$role->name}}</option>
												@endforeach
											</select>
											
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Permission</label>
										<div class="col-md-9">
											<select multiple="multiple" class="multi-select" id="my_multi_select1" name="permission[]">
												
												@foreach($permissions as $permission)

												<option>{{$permission->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
											<button type="button" class="btn default">Cancel</button>
										</div>
									</div>
								</div>
							</form>
							<!-- END FORM-->
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
			</div>
@endsection

@push('footerJs')

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {       
           // initiate layout and plugins
           Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
           ComponentsDropdowns.init();
        });   
    </script>

@endpush