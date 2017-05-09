@extends('layouts.main')
@section('title', 'Stocks')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')

<input type='hidden' name="controller_url_path" id="controller_url_path" value="{{ url('stock/general/history') }}" />
<input type='hidden' name="stock_id" id="stock_id" value="{{ $stock->id }}"/>

	<div class="row">
		<div class="col-md-12">
			<!-- Begin: life time stats -->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-shopping-cart"></i>Stock #{{ $stock->id }}<span class="hidden-480">
						| {{ $stock->created_at }} </span>
					</div>
					<div class="actions">
						<a href="{{ route('stock.index') }}" class="btn default yellow-stripe">
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
							<!--
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="">
									Export to Excel </a>
								</li>
								
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
								
							</ul>
							-->
						</div>
					</div>
				</div>

				<div class="portlet-body">
					<div class="tabbable">	

						<ul class="nav nav-tabs nav-tabs-lg">
							<li class="active">
								<a href="#tab_1" data-toggle="tab">
								Details </a>
							</li>
							<li>
								<a href="#tab_2" data-toggle="tab">
								History 
								</a>
							</li>
							
						</ul>	

						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
	
								<div class="row">

									<div class="col-md-6 col-sm-12">
										<div class="portlet blue-hoki box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Stock Information
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
														 Total Qty In Hand:
													</div>
													<div class="col-md-7 value">
														 {{ $stock->total_qty_in_hand }}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														 Updated By:
													</div>
													<div class="col-md-7 value">
														 {{ isset($stock->updatedBy->name)?$stock->updatedBy->name:'' }}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Added By
													</div>
													<div class="col-md-7 value">
														 {{ isset($stock->addedBy->name)?$stock->addedBy->name:'' }}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Product Name
													</div>
													<div class="col-md-7 value">
														{{ $stock->product->product_name }}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Attribute Name
													</div>
													<div class="col-md-7 value">
														  {{ $stock->attribute->attribute_name.' '. $stock->attribute->uom }}
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
													<i class="fa fa-cogs"></i>Stock Wastage
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
															Quantity
														</th>
														
														<th>
															Reason
														</th>
														<th>
															Added By
														</th>
														<th>
															Updated By
														</th>
									
														
													</tr>
													</thead>
													<tbody>
													@foreach ($wastages as $wastage)
													<tr>
														<td>
															{{  $wastage->basic_qty }}
														</td>
													
														<td>
															 {{  $wastage->reason }}
														</td>

														<td>
															{{  isset($wastage->addedBy->name)?$wastage->addedBy->name:''}}
														</td>
														<td>
															 {{  isset($wastage->updatedBy->name)?$wastage->updatedBy->name:'' }}
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

							<div class="tab-pane" id="tab_2">
								<div class="table-container">
									<div class="table-actions-wrapper">
										<span>
										</span>
										
									</div>
									<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
									<thead>
									<tr role="row" class="heading">
										<th width="5%">
											<input type="checkbox" class="group-checkable">
										</th>
									
										<th width="5%">
											 Total Qty in Hand
										</th>
										<th width="15%">
											 Updated By
										</th>
										<th width="15%">
											 Created At
										</th>
										<th width="10%">
											 Actions
										</th>
					
									</tr>
									<input type="hidden" name="_token" value="{{ csrf_token() }} " />
									<tr role="row" class="filter">
										<td>
										</td>
										
										<td>
											<input type="text" class="form-control form-filter input-sm" name="total_qty_in_hand">
											
										</td>
										<td>
											<input type="text" class="form-control form-filter input-sm" name="updated_by">
										</td>
										<td>
											<input type="hidden" class="form-control form-filter input-sm" name="created_at">
										</td>
										<td>
											<div class="margin-bottom-5">
												<button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button>
											</div>
											<button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</button>
										</td>

									</tr>
									</thead>
									<tbody>
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
<script src="{{ URL::asset('assets/global/scripts/datatable.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/stock-history-table-ajax.js') }}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   TableManaged.init();
   TableAjax.init();
});
</script>

@endpush