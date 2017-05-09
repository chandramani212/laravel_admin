@extends('layouts.main')
@section('title', 'Orders')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush


@section('content')
<input type='hidden' name="controller_url_path" id="controller_url_path" value="{{ url('product/general') }}" />

	<div class="row">
		<div class="col-md-12">
			<!-- Begin: life time stats -->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-shopping-cart"></i>Order #{{ $order->id }}<span class="hidden-480">
						| {{ $order->created_at }} </span>
						| PI #{{ $order->pi_no }}
					</div>
					<div class="actions">
						<a href="{{ route('order.index') }}" class="btn default yellow-stripe">
						<i class="fa fa-angle-left"></i>
						<span class="hidden-480">
						Back </span>
						</a>
						<div class="btn-group">
							<a class="btn default yellow-stripe dropdown-toggle" href="javascript:;" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
							<span class="hidden-480">
							Tools </span>
							<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="{{ route('OrderGeneralExcel',$order->id) }}">
									Export to Excel </a>
								</li>
								<!--
								<li>
									<a href="javascript:;">
									Export to CSV </a>
								</li>
								<li>
									<a href="javascript:;">
									Export to XML </a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="javascript:;">
									Print Invoice </a>
								</li>
								-->
							</ul>
						</div>
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
													<i class="fa fa-cogs"></i>Order Details
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
															Quantity
														</th>
														<th>
															 Price
														</th>
														<th>
															 Total Price
														</th>
														<th>
															Comment
														</th>
								
														
													</tr>
													</thead>
													<tbody>
													@php
														$i = 0;
													@endphp
												
													@foreach ($orderDetails as $orderDetail)
													<tr>
														<td>
															{{  ++$i  }}
														</td>
														<td>
															{{  $orderDetail->product_name }}
														</td>
														<td>
															{{  $orderDetail->actual_attribute_name.' '.$orderDetail->actual_uom }}
														</td>
														
														<td>
															 {{  $orderDetail->qty }}
														</td>
													
														<td>
															{{  $orderDetail->actual_mrp }}
														</td>
														<td>
															{{  $orderDetail->product_total }}
														</td>
														<td>
															{{  $orderDetail->comment or ''}}
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

								<div class="row">
									<div class="col-md-6">

										<div class="form-group">
											<label class="control-label col-md-3">Remark </label>
											<div class="col-md-9">
						   						<textarea id="remark" name="remark" class="form-control" rows="2" >{{ $order->remark or '' }} </textarea>			
												<span class="help-block">
												 </span>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3">Comment </label>
											<div class="col-md-9">
						   						<textarea id="order_comment" name="order_comment" class="form-control" rows="2" >{{ $order->comment or '' }} </textarea>			
												<span class="help-block">
												 </span>
											</div>
										</div>

									</div>
									<div class="col-md-6">
										<div class="well">
											<div class="row static-info align-reverse">
												<div class="col-md-8 name">
													 Sub Total:
												</div>
												<div class="col-md-3 value">
													 
													 <input class="form-control" type="text" id="sub_total" name="sub_total" value="{{ $order->sub_total }}" readonly="true" />
													 
												</div>


											</div>
											<div class="row static-info align-reverse">
												<div class="col-md-8 name">
													 Delivery Charge:
												</div>
												<div class="col-md-3 value">
													<input class="form-control" type="text" id="delivery_charge" name="delivery_charge" value="{{ $order->delivery_charge }}" readonly="true" />
												</div>
											</div>
											<div class="row static-info align-reverse">
												<div class="col-md-8 name">
													 Grand Total:
												</div>
												<div class="col-md-3 value">
													<input class="form-control" type="text" id="grand_total" name="grand_total" value="{{ $order->order_total }}" readonly="true" />
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