@extends('layouts.main')
@section('title', 'Customer Specific Price')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush


@section('content')

	<div class="row">
		<div class="col-md-12">
			<!-- Begin: life time stats -->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-shopping-cart"></i>Customer Specific<span class="hidden-480">
						|</span>
					</div>
					<div class="actions">
						<a href="{{ route('customerPrice.index') }}" class="btn default yellow-stripe">
						<i class="fa fa-angle-left"></i>
						<span class="hidden-480">
						Back </span>
						</a>

					</div>
				</div>

				<div class="portlet-body">
					<div class="tabbable">
											
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">

								<div class="row">
									@if(isset($customer->first_name))
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
														 {{$customer->first_name}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														 Customer Last Name:
													</div>
													<div class="col-md-7 value">
														 {{$customer->last_name}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														 Email:
													</div>
													<div class="col-md-7 value">
														 {{$customer->email}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														 Delivery Prefer Time:
													</div>
													<div class="col-md-7 value">
														 {{$customer->delivery_prefer_time}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														 Contact No:
													</div>
													<div class="col-md-7 value">
														  {{$customer->contact_no}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														 Alternate No:
													</div>
													<div class="col-md-7 value">
														  {{$customer->alternate_no}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														 Join Date:
													</div>
													<div class="col-md-7 value">
														  {{$customer->join_date}}
													</div>
												</div>

											</div>
										</div>
									</div>
									@endif

									@if(isset($shippingAddress->address_line1))
									<div class="col-md-6 col-sm-12">
										<div class="portlet yellow-crusta box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Shipping Address
												</div>
												
											</div>
											<div class="portlet-body">
												<div class="row static-info">
													<div class="col-md-5 name">
														 Address Line 1:
													</div>
													<div class="col-md-7 value">
														  {{ $shippingAddress->address_line1}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Address Line 2:
													</div>
													<div class="col-md-7 value">
														  {{ $shippingAddress->address_line2 }}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Street:
													</div>
													<div class="col-md-7 value">
														  {{ $shippingAddress->street }}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Pin Code:
													</div>
													<div class="col-md-7 value">
														  {{ $shippingAddress->pin_code }}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Locality:
													</div>
													<div class="col-md-7 value">
														 {{  isset($shippingAddress->locality->locality_name)?$shippingAddress->locality->locality_name:'' }}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														City :
													</div>
													<div class="col-md-7 value">
														  {{   isset($shippingAddress->city->city_name)?$shippingAddress->city->city_name:''}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														State :
													</div>
													<div class="col-md-7 value">
														   {{  isset($shippingAddress->state->state_name)?$shippingAddress->state->state_name:'' }}
													</div>
												</div>
												
											</div>
										</div>
									</div>
									@endif
								</div>	

								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="portlet grey-cascade box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Customer Specific Price Details
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
															 Sr.No
														</th>
														<th>
															 Product
														</th>
														<th>
															 Product Attribute
														</th>

														<th>
															 Variable Price
														</th>
														<th>
															 Price
														</th>
														
														<th>
															 Price Type
														</th>
								
														
													</tr>
													</thead>
													<tbody>
													@php
														$i = 0;
													@endphp
												
													@foreach ($custPriceDetails as $custPriceDetail)
													<tr>
														<td>
															{{  ++$i  }}
														</td>
														<td>
															{{  $custPriceDetail->product->product_name or '' }}
														</td>
														<td>
															{{  $custPriceDetail->attribute->attribute_name.' '.$custPriceDetail->attribute->uom }}
														</td>

														<td>
															{{  $custPriceDetail->attribute->price->price or '' }}
														</td>

														<td>
															{{  $custPriceDetail->price }}
														</td>
														<td>
															{{  $custPriceDetail->default_selected_price or ''}}
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