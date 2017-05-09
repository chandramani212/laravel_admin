@extends('layouts.main')
@section('title', 'Customer Specific Price')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')
	<input type='hidden' name="controller_url_path" id="controller_url_path" value="{{ url('customPrice/general') }}" />

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
						<i class="fa fa-shopping-cart"></i>Customer Listing
					</div>
					<div class="actions">
						<a href="{{ route('customPrice.create') }}" class="btn default yellow-stripe">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">
						Create Specific Price </span>
						</a>
						<!--
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
						-->

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
							<th width="3%">
								id
							</th>
							<th width="15%">
								Description
							</th>
							<th width="50%">
								customer Name
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
								<input type="text" class="form-control form-filter input-sm" name="custom_price_id" id="custom_price_id">
							</td>
							<td>
								<input type="text" class="form-control form-filter input-sm" name="description" id="description">
							</td>
							<td>
								<input class="customer_id form-filter input-sm" id="customer_id" name="customer_id" type="hidden" class="form-control">
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
<script src="{{ URL::asset('assets/admin/pages/scripts/custom-price-table-ajax.js') }}"></script>
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
	url =  $('#controller_url_path').val()+'/bulkinvoice?';
	order_id = $('#order_id').val();
	order_total = $('#order_total').val();
	customer_id = $('#customer_id').val();
	created_from = $('#created_from').val();
	created_to = $('#created_to').val();
	//data = {order_id:order_id,order_total:order_total,customer_id:customer_id, created_from: created_from,created_to:created_to,};

	var redirectStatus = true ; 

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
	}else{
		alert('Please choose  Date');
		redirectStatus = false ; 
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
	if(redirectStatus){
		window.location.href = url;
	}

}

</script>
@endpush