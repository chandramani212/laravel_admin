@extends('layouts.main')
@section('title', 'Stock')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')
	<input type='hidden' name="controller_url_path" id="controller_url_path" value="{{ url('stock/general/stock') }}" />

	<div class="row">
		<div class="col-md-12 col-sm-12">
		    <div class="note note-danger">
				<!--
				<p>
					 NOTE: The below datatable is not connected to a real database so the filter and sorting is just simulated for demo purposes only.
				</p>
				-->
			</div>
			<!-- Begin: life time stats -->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-shopping-cart"></i>Stock Listing
					</div>
					<div class="actions">
						<a href="{{ route('stock.create') }}" class="btn default yellow-stripe">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">
						Add Stock </span>
						</a>

					</div>
				</div>
				<div class="portlet-body">
					<div class="table-container">
						<div class="table-actions-wrapper">
							<span>
							</span>

						</div>
						<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
						<thead>
						<tr role="row" class="heading">
							<th width="2%">
								<input type="checkbox" class="group-checkable">
							</th>
							<th width="5%">
								 Stock &nbsp;Id
							</th>
							<th width="15%">
								 Quantity In Hand
							</th>
							<th width="15%">
								 Product Name
							</th>
							<th width="10%">
								Attribute Name
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
								<input type="text" class="form-control form-filter input-sm" name="stock_id">
							</td>
							<td>
								<input type="text" class="form-control form-filter input-sm" name="total_qty_in_hand">
							</td>
							<td>
								<input type="text" class="form-control form-filter input-sm" name="product_name">
							</td>
							<td>
								<input type="text" class="form-control form-filter input-sm" name="attribute_name">
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
<script src="{{ URL::asset('assets/admin/pages/scripts/stock-table-ajax.js') }}"></script>
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