@extends('layouts.main')
@section('title', 'Orders')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/icheck/skins/all.css') }}" />
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')
<input type='hidden' name="controller_url_path" id="controller_url_path" value="{{ url('product/general') }}" />

<div class="row">
	<div class="col-md-12 ">
		<div class="tabbable-line boxless tabbable-reversed">
			<div class="tab-content">
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gift"></i>Create Order
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
							<a href="#portlet-config" data-toggle="modal" class="config">
							</a>
							<a href="javascript:;" class="reload">
							</a>
							<a href="javascript:;" class="remove">
							</a>
						</div>
					</div>
					<div class="portlet-body form">
					    @if (count($errors) > 0)
					       
					      	<div class="alert alert-danger">
					            <strong>Whoops!</strong> There were some problems with your input.<br><br>
					            <ul>
					                @foreach ($errors->all() as $error)
					                    <li>{{ $error }}</li>
					                @endforeach
					            </ul>
					        </div>
					        
					    @endif
						<!-- BEGIN FORM-->
						{!! Form::model($order, ['method' => 'PATCH','route' => ['order.update', $order->id],'class' =>'form-horizontal']) !!}
							@include('pages.orders.formEdit')
						{!! Form::close() !!}
						<!-- END FORM-->
					</div>
				</div>
		</div>
		</div>	
	</div>
</div>	
@endsection
@push('footerJs')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>

<script src="{{ URL::asset('assets/global/plugins/icheck/icheck.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/form-samples.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/form-icheck.js') }}"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns-product.js') }}"></script>


<!-- END PAGE LEVEL SCRIPTS -->
<script>
var dynamic_row ;
jQuery(document).ready(function() {    
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   FormSamples.init();
   ComponentsDropdowns.init();
   dynamic_row = $('#add_product_row').html();
});
</script>

<script>

function custom_merchant_action(){

	var custom_merchant_price = $('#custom_merchant_price').val();
	console.log('Key pressed'+custom_merchant_price);
	$('#merchant_price').val(custom_merchant_price);

}


var productRowId = 0;
function  add_product_to_cart(){
 	productRowId++;
	searched_product_name

	var searched_product_id = $('#searched_product_name').val();
	var searched_product_name = $('#s2id_searched_product_name').find('.select2-chosen').text();

	var searched_attribute_id = $('#searched_attribute_id').val();
	var searched_attribute_name = $('#searched_attribute_id').find('option:selected').text();

	var price = $('input[name=price]').val();
	var qty =$('#add_qty').val();
	var total = parseFloat(price) * parseFloat(qty);

	var row='<tr id="'+productRowId+'"> '+
				'<td>'+
					'<input name=product_name[] type="text" class="form-control" value ="'+searched_product_name+'" readonly="true" />'+
					'<input name=product_id[] type="hidden" class="form-control" value ="'+searched_product_id+'" readonly="true" />'+
				'</td>'+
				'<td>'+

					'<input name=attribute_name[] type="text" class="form-control" value ="'+searched_attribute_name+'" readonly="true" />'+
					'<input name=attribute_id[] type="hidden" class="form-control" value ="'+searched_attribute_id+'" readonly="true" />'+
				'</td>'+
				'<td>'+
					'<input name=qty[] type="text" class="form-control" value ="'+qty+'" readonly="true" />'+
				'</td>'+
				'<td>'+
					'<input name=actual_mrp[] type="text" class="form-control" value ="'+price+'" readonly="true" />'+
				'</td>'+
				'<td>'+
					'<input name=product_total[] type="text" class="form-control" value ="'+(total).toFixed(2)+'" readonly="true" />'+
				'</td>'+

				'<td>'+
					'<a href="javascript:remove_row(\''+productRowId+'\');" class="btn default btn-sm">'+
					'<i class="fa fa-times"></i> Remove </a>'+
				'</td>'+
			'</tr>';

		$('#add_product_row').append(row);

		calculate_total_summary();
}


function remove_row(rowid){
	//console.log('remove got clicked');
	$('#'+rowid).remove();

	calculate_total_summary();
}

function delete_row(rowid){
	//console.log('remove got clicked');
	
	$('#'+rowid).find('#delete_order_detail').val('True');
	//$('#'+rowid).find('input[name^=edit_product_total]').attr('name','edit_product_total_hide[]');
	$('#'+rowid).find('input[name^=edit_product_total]').attr('value','0.00');
	$('#'+rowid).hide();

	calculate_total_summary();
}

function handleClick(elem){

	console.log('Handle click');
}



function calculate_total_summary(){
	console.log('calculate_total_summary is get calledd');

	var product_total = 0.00;
	$('input[name^=product_total]').each(function() {
	   product_total =parseFloat( product_total) + parseFloat($(this).val());
	});

	var edit_product_total = 0.00;
	$('input[name^=edit_product_total]').each(function() {
	  edit_product_total =parseFloat( edit_product_total) + parseFloat($(this).val());
	});

	var sub_total =product_total + edit_product_total  ;
	var delivery_charge = 0.00;

	var grand_total = sub_total + delivery_charge ;
	$('#sub_total').val((sub_total).toFixed(2));
	$('#delivery_charge').val((delivery_charge).toFixed(2));
	$('#grand_total').val((grand_total).toFixed(2));
	
}

function change_qty_in_hand(){
	var add_qty = parseInt($('#add_qty').val());
	var qty_in_hand = parseInt($('#qty_in_hand').val());

	if(qty_in_hand >= 0){
		if(add_qty <= qty_in_hand ){

			//$('#qty_in_hand').val(qty_in_hand - add_qty );
		}else{

			$('#add_qty').val('');
			$('#add_qty').attr('placeholder','Max Qty Available :'+qty_in_hand);

		}
	}

}

$('#customer_select').change(function(){
	//console.log('selection has changes'+$('#customer_select').val());
	var customer_id,token,url;
	customer_id = $('#customer_select').val();
	token = $('input[name=_token]').val();
	url = '../../customer/general/address/'+customer_id;
	data = {customer_id: customer_id};

	$.ajax({

		headers: {'X-CSRF-TOKEN': token},
		url:url,
		type:'POST',
		data:data,
		beforeSend:function(){
			$('#customer_address').html('Loading....');
		},
		success:function(data){
			$('#customer_address').html(data);
		}
	});
});



$('#searched_attribute_id').change(function(){
	console.log('selection has changes'+$('#searched_attribute_id').val());
	var attribute_id,token,url;
	attribute_id = $('#searched_attribute_id').val();
	customer_id = $('#customer_select').val();
	token = $('input[name=_token]').val();

	url = '../../attribute/general/allprice/'+attribute_id

	if(customer_id > 0){
		url += '/'+customer_id;
	}
	
	data = {attribute_id: attribute_id};

	$.ajax({

		headers: {'X-CSRF-TOKEN': token},
		url:url,
		type:'POST',
		data:data,
		beforeSend:function(){
			$('#searched_attribute_price_val').val('Loading....');
		},
		success:function(data){
			var prices = $.parseJSON(data);

			//console.log(prices.price+' '+prices.sell_price+' '+prices.merchant_price);
			$('#base_price').val(prices.price);
			$('#base_price').parent('div').parent('label').find('span').html(prices.price+' Base Price');
			$('#sell_price').val(prices.sell_price);
			$('#sell_price').parent('div').parent('label').find('span').html(prices.sell_price+' Sell Price');
			$('#merchant_price').val(prices.merchant_price);
			$('#merchant_price').parent('div').parent('label').find('span').html(prices.merchant_price+' Cust Price');
			$('#custom_merchant_price').val(prices.merchant_price);

			if(prices.qty_in_hand > 0 ){
				$('#qty_in_hand').val(prices.qty_in_hand);
			}else{
				$('#add_qty').val('0');
				$('#add_qty').attr('placeholder','This is out of Stock');
				$('#add_qty').attr('disabled',true);
			}
		}
	});
});



</script>


@endpush