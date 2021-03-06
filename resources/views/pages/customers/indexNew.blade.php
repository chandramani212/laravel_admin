@extends('layouts.main')
@section('title', 'Customers')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12">
		    <div class="note note-danger">
				<p>
					 NOTE: The below datatable is not connected to a real database so the filter and sorting is just simulated for demo purposes only.
				</p>
			</div>
			<!-- Begin: life time stats -->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-shopping-cart"></i>Order Listing
					</div>
					<div class="actions">
						<a href="javascript:;" class="btn default yellow-stripe">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">
						New Order </span>
						</a>
						<div class="btn-group">
							<a class="btn default yellow-stripe" href="javascript:;" data-toggle="dropdown">
							<i class="fa fa-share"></i>
							<span class="hidden-480">
							Tools </span>
							<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="javascript:;">
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
									Print Invoices </a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-container">
						<div class="table-actions-wrapper">
							<span>
							</span>
							<select class="table-group-action-input form-control input-inline input-small input-sm">
								<option value="">Select...</option>
								<option value="Cancel">Cancel</option>
								<option value="Cancel">Hold</option>
								<option value="Cancel">On Hold</option>
								<option value="Close">Close</option>
							</select>
							<button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i> Submit</button>
						</div>
						<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
						<thead>
						<tr role="row" class="heading">
							<th width="2%">
								<input type="checkbox" class="group-checkable">
							</th>
							<th width="5%">
								 Record&nbsp;#
							</th>
							<th width="15%">
								 Date
							</th>
							<th width="15%">
								 Customer
							</th>
							<th width="10%">
								 Ship&nbsp;To
							</th>
							<th width="10%">
								 Price
							</th>
							<th width="10%">
								 Amount
							</th>
							<th width="10%">
								 Status
							</th>
							<th width="10%">
								 Actions
							</th>
						</tr>
						<tr role="row" class="filter">
							<td>
							</td>
							<td>
								<input type="text" class="form-control form-filter input-sm" name="order_id">
							</td>
							<td>
								<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
									<input type="text" class="form-control form-filter input-sm" readonly name="order_date_from" placeholder="From">
									<span class="input-group-btn">
									<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
								<div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
									<input type="text" class="form-control form-filter input-sm" readonly name="order_date_to" placeholder="To">
									<span class="input-group-btn">
									<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</td>
							<td>
								<input type="text" class="form-control form-filter input-sm" name="order_customer_name">
							</td>
							<td>
								<input type="text" class="form-control form-filter input-sm" name="order_ship_to">
							</td>
							<td>
								<div class="margin-bottom-5">
									<input type="text" class="form-control form-filter input-sm" name="order_price_from" placeholder="From"/>
								</div>
								<input type="text" class="form-control form-filter input-sm" name="order_price_to" placeholder="To"/>
							</td>
							<td>
								<div class="margin-bottom-5">
									<input type="text" class="form-control form-filter input-sm margin-bottom-5 clearfix" name="order_quantity_from" placeholder="From"/>
								</div>
								<input type="text" class="form-control form-filter input-sm" name="order_quantity_to" placeholder="To"/>
							</td>
							<td>
								<select name="order_status" class="form-control form-filter input-sm">
									<option value="">Select...</option>
									<option value="pending">Pending</option>
									<option value="closed">Closed</option>
									<option value="hold">On Hold</option>
									<option value="fraud">Fraud</option>
								</select>
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
@endsection
@push('footerJs')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/scripts/datatable.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/table-ajax.js') }}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {    
           Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
           TableAjax.init();
        });
    </script>

@endpush