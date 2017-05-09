@extends('layouts.main')
@section('title', 'Orders')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->


</style>
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
						{!! Form::open(array('route' => 'order.store','method'=>'POST','class' => 'form-horizontal'))!!}
							@include('pages.orders.formCreate')
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
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/clockface/js/clockface.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/form-samples.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns-product.js') }}"></script>

</script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers-order.js') }}"></script>


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
   ComponentsPickers.init();
   ComponentsDropdowns.init();
});
</script>

<script>



var productRowId = 0;
function  add_row(){
 	productRowId++;
//console.log(productRowId);
	var row='<tr id="'+productRowId+'"> '+
				'<td>'+
					'<input class="product_id" name="product_id[]" type="hidden" class="form-control" required="true">'+
					'<input class="product_name" name="product_name[]" type="hidden" class="form-control" value="">'+
					
				'</td>'+
				'<td class="attribute_td">'+

					'<select onchange="getAttributePrice(this)" class="select2 form-control attribute_id" name="attribute_id[]" tabindex="1" required="true">'+

					'<option>Choose Attribute</option>'+

					'</select>'+	

					'<input class="attribute_name" name="attribute_name[]" type="hidden" class="form-control" value="">'+

				'</td>'+
				'<td>'+
					'<input onkeyup="qty_change(this)" name=qty[] type="text" class="form-control" value ="0" tabindex="111'+productRowId+'" />'+
				'</td>'+
				'<td >'+
					

					'<label style="display: none; position:relative;" onclick="qty_change(this)" class="base_price col-md-14" >'+
					'<input  id="PRICE" type="radio" name="price['+productRowId+']" class="icheck" value=""> <span>  Base Price </span>'+
					'</label>'+

					'<label style="display: none; position:relative;" onclick="qty_change(this)" class="sell_price col-md-14">'+
					'<input id="SELL_PRICE" type="radio" name="price['+productRowId+']" class="icheck" value=""> <span> Sell Price</span>'+
					'</label>'+

					'<label style="position:relative;width: 90%" onclick="qty_change(this)" class="merchant_price">'+
					'<input  style="float:left;" id="CUSTOM_PRICE" type="radio" name="price['+productRowId+']" checked class="icheck" value="" >'+ 
					'<span  style="margin-left : 5px;float:left;"> CP</span>'+
					'<input style="margin-left : 5px;float:left;width: 40%;" class="custom_merchant_price" onkeyup="custom_merchant_action(this)" type="text" value="0.00"  />'+
					'</label>'+

					'<a style="position: absolute;" onclick="price_toggle(this)" class="">'+
							'<i class="fa fa-pencil"></i> <span style="display:none">Show</span>'+ 
					'</a>'+

					'<input type="hidden" name=price_type[] value="" />'+

				'</td>'+
				'<td>'+
					'<input name=product_total[] type="text" class="form-control" value ="0.00"  readonly="true" />'+
				'</td>'+

				'<td>'+
					'<a href="javascript:remove_row(\''+productRowId+'\');" class="btn default btn-sm">'+
					'<i class="fa fa-times"></i> Remove </a>'+
				'</td>'+
			'</tr>';



		$('#add_product_row').append(row);

		ComponentsDropdowns.init();
		//calculate_total_summary();
}

function get_default_order(){

	var customer_id,token,url;
	customer_id = parseInt($('#customer_select').val());
	token = $('input[name=_token]').val();
	url = '../customer/general/defaultorder/'+customer_id;
	data = {customer_id: customer_id};
	if(customer_id > 0 )
	{
		$.ajax({

			headers: {'X-CSRF-TOKEN': token},
			url:url,
			type:'POST',
			data:data,
			beforeSend:function(){
				//$('#').html('Loading....');
			},
			success:function(data){
				$('#add_product_row').html(data);
				ComponentsDropdowns.init();
			}
		});
	}else{

		alert('Please Choose Customer first');
	}

}


function remove_row(rowid){
	//console.log('remove got clicked');
	$('#'+rowid).remove();

	calculate_total_summary();
}

function qty_change(elem){

	var qty = parseFloat($(elem).parent('td').parent('tr').find('input[name^=qty]').val());
	if(isNaN(qty)){
		qty = 0.00;
	}
	var actual_mrp = parseFloat( $(elem).parent('td').parent('tr').find('input[name^=price]:checked').val());

	var price_type =  $(elem).parent('td').parent('tr').find('input[name^=price]:checked').attr('id');

	$(elem).parent('td').parent('tr').find('input[name^=price_type]').val(price_type);

	if(isNaN(actual_mrp)){
		actual_mrp = 0.00;
	}

	var total = $(elem).parent('td').parent('tr').find('input[name^=product_total]').val(qty*actual_mrp);
	//console.log(total);

	calculate_total_summary();
}

function custom_merchant_action(elem){

	var custom_merchant_price = $(elem).val();
	console.log('Key pressed'+custom_merchant_price);
	$(elem).parent('label').find('input[name^=price]').val(custom_merchant_price);
	
	qty_change($(elem).parent('label'));
}

function price_toggle(elem){
	
	var action = $(elem).find('span').html();

	//console.log('This is clicked '+action+' - '+action_data);

	if(action=='Show'){
		$(elem).parent('td').find('.base_price').show();	
		$(elem).parent('td').find('.sell_price').show();	
		$(elem).find('span').html('Hide');
	}else{

		$(elem).parent('td').find('.base_price').hide();	
		$(elem).parent('td').find('.sell_price').hide();
		$(elem).find('span').html('Show');	

	}
	

}

function calculate_total_summary(){
	console.log('calculate_total_summary is get calledd');

	var product_total = 0.00;
	$('input[name^=product_total]').each(function() {
	   product_total =parseFloat( product_total) + parseFloat($(this).val());
	});

	var sub_total =product_total ;
	var delivery_charge = 0.00;

	var grand_total = sub_total + delivery_charge ;
	$('#sub_total').val((sub_total).toFixed(2));
	$('#delivery_charge').val((delivery_charge).toFixed(2));
	$('#grand_total').val((grand_total).toFixed(2));
	
}


function getAttributePrice(elem){
	//console.log('selection has changes'+$(elem).val());
	var attribute_name = $(elem).find('option:selected').text();
	console.log('attribute:'+attribute_name);
	$(elem).parent('td').find('input[name^=attribute_name]').val(attribute_name);
	var attribute_id,token,url;
	attribute_id = $(elem).val();
	customer_id = $('#customer_select').val();
	token = $('input[name=_token]').val();

	url = '../attribute/general/allprice/'+attribute_id

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
			//$('#searched_attribute_price_val').val('Loading....');
		},
		success:function(data){
			var prices = $.parseJSON(data);

			console.log(prices.price+' '+prices.sell_price+' '+prices.merchant_price);
			$(elem).parent('td').parent('tr').find('.base_price input').val(prices.price);
			$(elem).parent('td').parent('tr').find('.base_price span').html(prices.price+' Base Price');
			$(elem).parent('td').parent('tr').find('.sell_price input').val(prices.sell_price);
			$(elem).parent('td').parent('tr').find('.sell_price span').html(prices.sell_price+' Sell Price');
			$(elem).parent('td').parent('tr').find('.merchant_price input').val(prices.merchant_price);
			//$(elem).parent('td').parent('tr').find('.merchant_price span').html(prices.merchant_price+' Cust Price');
			$(elem).parent('td').parent('tr').find('.custom_merchant_price').val(prices.merchant_price);

			/*if(prices.qty_in_hand > 0 ){
				$('#qty_in_hand').val(prices.qty_in_hand);
				$('#add_qty').val('1');
				$('#add_qty').attr('disabled',false);
				$('#add_product_cart').attr('disabled',false);
			}else{
				$('#add_qty').val('0');
				$('#add_qty').attr('placeholder','This is out of Stock');
				$('#add_qty').attr('disabled',true);
				$('#add_product_cart').attr('disabled',true);
			}*/
		}
	});
}

/*function change_qty_in_hand(){
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
*/
$('#customer_select').change(function(){
	//console.log('selection has changes'+$('#customer_select').val());
	var customer_id,token,url;
	customer_id = $('#customer_select').val();
	token = $('input[name=_token]').val();
	url = '../customer/general/address/'+customer_id;
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







</script>


@endpush