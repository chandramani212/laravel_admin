@extends('layouts.main')
@section('title', 'Locality')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')
		<div class="row">

			<div class="col-md-6 col-sm-12">
				<div class="portlet blue-hoki box">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Locality Information
						</div>
						<div class="actions">
						<!--	<a href="javascript:;" class="btn btn-default btn-sm">
							<i class="fa fa-pencil"></i> Edit </a>
							-->
						</div>
					</div>
					<div class="portlet-body">
						<div class="row static-info">
							<div class="col-md-5 name">
								 Locality Name:
							</div>
							<div class="col-md-7 value">
								 {{$locality->locality_name}}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 City Name:
							</div>
							<div class="col-md-7 value">
								 {{$locality->city->city_name or '' }}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 State Name:
							</div>
							<div class="col-md-7 value">
								 {{$locality->city->state->state_name or ''}}
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-12">
				<div class="portlet yellow-crusta box">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Locality Other Details
						</div>
						
					</div>
					<div class="portlet-body">
						<div class="row static-info">
							<div class="col-md-5 name">
								 Created By:
							</div>
							<div class="col-md-7 value">
								  {{ $locality->createdBy->name or '' }}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 Updated By:
							</div>
							<div class="col-md-7 value">
								  {{ $locality->updatedBy->name or ''}}
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>	

	
@endsection
@push('footerJs')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/table-managed.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   TableManaged.init();
});
</script>

@endpush