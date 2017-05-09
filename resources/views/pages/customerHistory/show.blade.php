@extends('layouts.main')
@section('title', 'Customer History')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')
		@if($customerHistory !== null)
		@foreach($customerHistory as $history)
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#collapse_{{$history->id}}">
				Customer History #{{$history->id}} </a>
				</h4>
			</div>
			<div id="collapse_{{$history->id}}" class="panel-collapse in">
				<div class="panel-body">

		<div class="row">

			<div class="col-md-6 col-sm-12">
				<div class="portlet blue-hoki box">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Customer Information
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
								 Customer First Name:
							</div>
							<div class="col-md-7 value">
								 {{$history->first_name}}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 Customer Last Name:
							</div>
							<div class="col-md-7 value">
								 {{$history->last_name}}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 Email:
							</div>
							<div class="col-md-7 value">
								 {{$history->email}}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 Delivery Prefer Time:
							</div>
							<div class="col-md-7 value">
								 {{$history->delivery_prefer_time}}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 Contact No:
							</div>
							<div class="col-md-7 value">
								  {{$history->contact_no}}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 Alternate No:
							</div>
							<div class="col-md-7 value">
								  {{$history->alternate_no}}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 Join Date:
							</div>
							<div class="col-md-7 value">
								  {{$history->join_date}}
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-12">
				<div class="portlet yellow-crusta box">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Customer Other Details
						</div>
						
					</div>
					<div class="portlet-body">
						<div class="row static-info">
							<div class="col-md-5 name">
								 Introduce By:
							</div>
							<div class="col-md-7 value">
								  {{ isset($history->introduceUser->name)?$history->introduceUser->name:''}}
							</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">
								 Managed By:
							</div>
							<div class="col-md-7 value">
								  {{ isset($history->manageUser->name)?$history->manageUser->name:''}}
							</div>
						</div>

						<div class="row static-info">
							<div class="col-md-5 name">
								 Created By:
							</div>
							<div class="col-md-7 value">
								 {{ $history->createdBy->name or ''}}
							</div>
						</div>


						<div class="row static-info">
							<div class="col-md-5 name">
								 Updated By:
							</div>
							<div class="col-md-7 value">
								  {{ $history->updatedBy->name or ''}}
							</div>
						</div>
						
					</div>
				</div>
			</div>

		</div>	

		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="portlet grey-cascade box">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Customer Address
						</div>
						<!--<div class="actions">
							<a href="javascript:;" class="btn btn-default btn-sm">
							<i class="fa fa-pencil"></i> Edit </a>
						</div>-->
					</div>
					<div class="portlet-body">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped">
							<thead>
							<tr>
								<th>
									 Address Line1
								</th>
								<th>
									 Address Line2
								</th>
								<th>
									Street
								</th>
								<th>
									 Locality
								</th>
								<th>
									 City
								</th>
								<th>
									 State
								</th>
								<th>
									Pin Code
								</th>
								<th>
									Status
								</th>
								
							</tr>
							</thead>
							<tbody>
							@foreach ($history->address as $addres)
							<tr>
								<td>
									{{  $addres->address_line1 }}
								</td>
								<td>
									{{  $addres->address_line2 }}
								</td>
								<td>
									 {{  $addres->street }}
								</td>
								<td>
									 {{  isset($addres->locality->locality_name)?$addres->locality->locality_name:'' }}
								</td>
								<td>
									 {{   isset($addres->city->city_name)?$addres->city->city_name:''}}
								</td>
								<td>
									 {{  isset($addres->state->state_name)?$addres->state->state_name:'' }}
								</td>
								<td>
									{{  $addres->pin_code }}
								</td>
								<td>
									{{  $addres->status }}
								</td>

							</tr>
							@endforeach
							</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>	


				</div>
			</div>
		</div>
		@endforeach	
		@endif
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