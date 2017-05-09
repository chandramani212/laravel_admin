@extends('layouts.main')
@section('title', 'Orders History')
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
					</div>
					<div class="actions">
						<a href="{{ route('orderHistory.index') }}" class="btn default yellow-stripe">
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
							<div class="panel-group accordion" id="accordion1">
							@if($orderHistory !== null)
							@foreach($orderHistory as $history)
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#collapse_{{$history->id}}">
									Order History #{{$history->id}} </a>
									</h4>
								</div>
								<div id="collapse_{{$history->id}}" class="panel-collapse in">
									<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="portlet blue-hoki box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Order  Information
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
														 Sub Total:
													</div>
													<div class="col-md-7 value">
														{{ $history->sub_total}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														 Delivery Charge:
													</div>
													<div class="col-md-7 value">
														 {{ $history->delivery_charge}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														 Ordet Total:
													</div>
													<div class="col-md-7 value">
														 {{ $history->order_total}}
													</div>
												</div>

												<div class="row static-info">
													<div class="col-md-5 name">
														Comment
													</div>
													<div class="col-md-7 value">
														 {{ $history->comment}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Order Stage:
													</div>
													<div class="col-md-7 value">
														{{ $history->order_stage}}
													</div>
												</div>
												

											</div>
										</div>
									</div>

									<div class="col-md-6 col-sm-12">
										<div class="portlet yellow-crusta  box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Other  Information
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
														Customer Name:
													</div>
													<div class="col-md-7 value">
														{{ $history->customer->first_name." ".$history->customer->last_name}}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Customer Address
													</div>
													<div class="col-md-7 value">
														{{
																														
															$history->address->address_line1 or ""
															
													 }}
													 {{
															$history->address->address_line2 or ""
															
													 }}
													 {{
															$history->address->street or ""
															
													 }}
													 
													
													 {{ 
														 $history->address->locality->locality_name or ''
														}}
														 {{ 
														  $history->address->city->city_name or ''
														}}
														 {{ 
															$history->address->state->state_name or ''
														}}
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
															 Product
														</th>
														<th>
															 Product Attribute
														</th>
														<th>
															Comment
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
								
														
													</tr>
													</thead>
													<tbody>
													@foreach ($history->orderDetailHistory as $orderDetail)
													<tr>
														<td>
															{{  $orderDetail->product_name }}
														</td>
														<td>
															{{  $orderDetail->actual_attribute_name.' '.$orderDetail->actual_uom }}
														</td>
														<td>
															{{  $orderDetail->comment or ''}}
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
								<hr/>							
							@endforeach
							@endif	

								

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