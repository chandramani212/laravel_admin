@extends('layouts.main')
@section('title', 'Invoice')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')
	<input type='hidden' name="controller_url_path" id="controller_url_path" value="{{ url('invoice/general') }}" />
	<input type='hidden' name="order_controller_url_path" id="order_controller_url_path" value="{{ url('order/general') }}" />
	<input type='hidden' name="cust_controller_url_path" id="cust_controller_url_path" value="{{ url('customer/general') }}" />

	<div class="row">
		<div class="col-md-12 col-sm-12">
			<!--
		    <div class="note note-danger">
				<p>
					 NOTE: The below datatable is not connected to a real database so the filter and sorting is just simulated for demo purposes only.
				</p>
			</div>
			-->
			<!-- Begin: life time stats -->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-shopping-cart"></i>Order Listing
					</div>
					<div class="actions">
					<!--
						<a href="{{ route('order.create') }}" class="btn default yellow-stripe">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">
						Create Order </span>
						</a>
					-->

						<div class="btn-group">
							<a class="btn default yellow-stripe" href="javascript:;" data-toggle="dropdown">
							<i class="fa fa-share"></i>
							<span class="hidden-480">
							Tools </span>
							<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="javascript:bulk_export('EXCEL');" >
									Export to Excel </a>
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

						</div>
						<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
						<thead>
						<tr role="row" class="heading">
							<th width="2%">
								<input type="checkbox" class="group-checkable">
							</th>
							<th width="5%">
								 Order &nbsp;Id
							</th>
							<th width="5%">
								 Order Total
							</th>
							<th width="15%">
								 Customer Name
							</th>
							<th width="10%">
								 Current Status
							</th>
							<th width="15%">
								 Created At
							</th>
							<th width="15%">
								 Actions
							</th>
						</tr>
						<input type="hidden" name="_token" value="{{ csrf_token() }} " />
						<tr role="row" class="filter">

							<td>
							</td>
							<td>
								<input type="text" class="form-control form-filter input-sm" name="order_id" id="order_id">
							</td>
							<td>
								<input type="text" class="form-control form-filter input-sm" name="order_total" id="order_total">
							</td>
							<td>
								<input class="customer_id form-filter input-sm" id="customer_id" name="customer_id" type="hidden" class="form-control">
							</td>
							<td>
						
								<select name="order_stage" id="order_stage" class="form-control form-filter input-sm">
									<option value="" >Select </option>
									<option value="CREATED" >Created </option>
									<option value="UPDATED" >Updated </option>
									<option value="INVOICE_CONFIRMED" >Invoice Confirmed </option>
								</select>

							</td>
							<td>
                                <div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
                                    <input type="text" class="form-control form-filter input-sm" readonly name="created_from" id="created_from" placeholder="From">
                                    <span class="input-group-btn">
                                    <button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>

                                <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                    <input type="text" class="form-control form-filter input-sm" readonly name="created_to" id="created_to" placeholder="To">
                                    <span class="input-group-btn">
                                    <button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>

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
<script src="{{ URL::asset('assets/admin/pages/scripts/invoice-table-ajax.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns-customer.js') }}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {    
           Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
           TableAjax.init();
           ComponentsDropdowns.init();
        });
    </script>

<script>
function bulk_export(method){

	var customer_id,token,url;
	customer_id = $('#customer_select').val();
	token = $('input[name=_token]').val();
	url =  $('#order_controller_url_path').val()+'/bulkinvoice?';
	order_id = $('#order_id').val();
	order_total = $('#order_total').val();
	customer_id = $('#customer_id').val();
	created_from = $('#created_from').val();
	created_to = $('#created_to').val();
	//data = {order_id:order_id,order_total:order_total,customer_id:customer_id, created_from: created_from,created_to:created_to,};

	if(order_id!=''){
		url += '&order_id='+order_id;
	}
	if(order_total!=''){
		url += '&order_total='+order_total;
	}
	if(customer_id!=''){
		url += '&customer_id='+customer_id;
	}

	if(created_from!=''){
		url += '&created_from='+created_from;
	}
	if(created_to!=''){
		url += '&created_to='+created_to;
	}
	/*$.ajax({

		headers: {'X-CSRF-TOKEN': token},
		url:url,
		type:'POST',
		contentType: "text/csv",
		contentDisposition: "attachment",
		data:data,
		beforeSend:function(){
			//$('#customer_address').html('Loading....');
		},
		success:function(data,textStatus, jqXHR){
			//$('#customer_address').html(data);

			window.location.replace(data) ; 
		}
	});*/

	window.location.href = url;
}

function confirm_invoice(order_id,elem){
	var customer_id,token,url;
	customer_id = $('#customer_select').val();
	token = $('input[name=_token]').val();
	//order_id = 
	url =  $('#order_controller_url_path').val()+'/invoiceconfirm';
	
	if(order_id!=''){
		url += '/'+order_id;
	}

	data = {order_stage:'INVOICE_CONFIRMED',};

	$.ajax({

		headers: {'X-CSRF-TOKEN': token},
		url:url,
		type:'POST',
		data:data,
		beforeSend:function(){
			//$('#customer_address').html('Loading....');
		},
		success:function(data){
			//$('#customer_address').html(data);
			$(elem).parent('td').parent('tr').find('.invoice-confirm').removeClass('label-danger');
			$(elem).parent('td').parent('tr').find('.invoice-confirm').addClass('label-default');
			$(elem).parent('td').parent('tr').find('.invoice-confirm').html('INVOICE_CONFIRMED');
		}
	});

}

</script>
@endpush