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
						<a href="{{ route('customPrice.index') }}" class="btn default yellow-stripe">
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
									<div class="col-md-12 col-sm-12">
										<div class="portlet grey-cascade box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Customer list
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
															 SrNo
														</th>
														<th>
															 Name
														</th>
														<th>
															 Email
														</th>
														<th>
															 Delivery Time
														</th>

														<th>
															Contact No
														</th>
														<th>
															Alternate No
														</th>
														<th>
															 Join Date
														</th>
														
														<th>
															 Address
														</th>
								
														
													</tr>
													</thead>
													<tbody>
													@php
														$i = 0;
													@endphp
												
													@foreach ($customerLists as $customerList)
													<tr>
														<td>
															{{  ++$i  }}
														</td>
														<td>
															{{  $customerList->customer->fullName() }}
														</td>
														<td>
															{{  $customerList->customer->email or ''  }}
														</td>

														<td>
															{{  $customerList->customer->delivery_prefer_time or ''  }}
														</td>

														<td>
															{{  $customerList->customer->contact_no or ''  }}
														</td>
														<td>
															{{  $customerList->customer->alternate_no or ''  }}
														</td>
														<td>
															{{  $customerList->customer->join_date or ''  }}
														</td>

														<td>
															{{  $customerList->address->getFullAddress()  }}
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
									<div class="col-md-12 col-sm-12">
										<div class="portlet grey-cascade box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Customer Specific Price Details
												</div>
												
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
												
													@foreach ($customPriceLists as $customPriceList)
													<tr>
														<td>
															{{  ++$i  }}
														</td>
														<td>
															{{  $customPriceList->product->product_name or '' }}
														</td>
														<td>
															{{  $customPriceList->attribute->attribute_name.' '.$customPriceList->attribute->uom }}
														</td>

														<td>
															{{  $customPriceList->attribute->price->price or '' }}
														</td>

														<td>
															{{  $customPriceList->price }}
														</td>
														<td>
															{{  $customPriceList->default_selected_price or ''}}
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