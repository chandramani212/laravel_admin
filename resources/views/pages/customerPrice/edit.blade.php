@extends('layouts.main')
@section('title', 'Customer Price')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/icheck/skins/all.css') }}" />


<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>

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
							<i class="fa fa-gift"></i>Edit Customer Specific Price
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
						{!! Form::model($customerPrice, ['method' => 'PATCH','route' => ['customerPrice.update',$customerPrice->id],'class' =>'form-horizontal']) !!}
							@include('pages.customerPrice.formEdit')
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

<script src="{{ URL::asset('assets/admin/pages/scripts/form-icheck.js') }}"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns-product.js') }}"></script>
</script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers-order.js') }}"></script


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
   
	//require 2 times to initialze beacuse product dropdown was not taking 100% width
   ComponentsDropdowns.init();
   ComponentsDropdowns.init();
   //dynamic_row = $('#add_product_row').html();
});
</script>

<script>


var productRowId = 0;
function  add_row(){
 	productRowId++;
//console.log(productRowId);
	var row='<tr id="'+productRowId+'"> '+
				'<td>'+
					'<input class="product_id" name="product_id[]" type="hidden" class="form-control">'+
					'<input class="product_name" name="product_name[]" type="hidden" class="form-control" value="">'+
					
				'</td>'+
				'<td class="attribute_td">'+

					'<select onchange="getAttributePrice(this)" class="select2 form-control attribute_id" name="attribute_id[]" tabindex="1" >'+

					'<option>Choose Attribute</option>'+

					'</select>'+	

					'<input class="attribute_name" name="attribute_name[]" type="hidden" class="form-control" value="">'+

				'</td>'+

				'<td class="base_price">'+
					'<input name=base_price[] type="text" class="form-control base_price" value ="" disabled/>'+
				'</td>'+
				'<td>'+
					'<input name=price[] type="text" class="form-control" value ="" required/>'+
				'</td>'+

				'<td >'+

					'<select class="select2 form-control" name="default_selected_price[]" tabindex="1" required="true">'+

					'<option value="">Choose Default</option>'+
					'<option value="FIXED_PRICE">Fixed Price</option>'+
					'<option value="CUSTOM_PRICE">Custom Price</option>'+

					'</select>'+	

					'<input class="attribute_name" name="attribute_name[]" type="hidden" class="form-control" value="">'+

				'</td>'+			

				'<td>'+
					'<a href="javascript:remove_row(\''+productRowId+'\');" class="btn default btn-sm">'+
					'<i class="fa fa-times"></i> Remove </a>'+
				'</td>'+
			'</tr>';



		$('#add_product_row').append(row);

	   //require 2 times to initialze beacuse product dropdown was not taking 100% width
	   ComponentsDropdowns.init();
		ComponentsDropdowns.init();
		//calculate_total_summary();
}

function delete_row(rowid){
	//console.log('remove got clicked');
	
	$('#'+rowid).find('#delete_customer_price_detail').val('True');

	$('#'+rowid).hide();

}


function remove_row(rowid){
	//console.log('remove got clicked');
	$('#'+rowid).remove();

	calculate_total_summary();
}




function getAttributePrice(elem){
	//console.log('selection has changes'+$(elem).val());
	var attribute_name = $(elem).find('option:selected').text();
	console.log('attribute:'+attribute_name);
	$(elem).parent('td').find('.attribute_name').val(attribute_name);
	var attribute_id,token,url;
	attribute_id = $(elem).val();
	customer_id = $('#customer_select').val();
	address_id = $('#address_id').val();
	token = $('input[name=_token]').val();

	url = '../../attribute/general/allprice/'+attribute_id;

	if(customer_id > 0){
		url += '/'+customer_id;
	}

	if(address_id > 0){
		url += '/'+address_id;
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
			$(elem).parent('td').parent('tr').find('.base_price').find('#PRICE').val(prices.price);
			$(elem).parent('td').parent('tr').find('.base_price span.base_price').html(prices.price+' Base Price');
			$(elem).parent('td').parent('tr').find('.sell_price').find('#SELL_PRICE').val(prices.sell_price);
			$(elem).parent('td').parent('tr').find('.sell_price span.sell_price').html(prices.sell_price+' Sell Price');
			$(elem).parent('td').parent('tr').find('.merchant_price').find('#CUSTOM_PRICE').val(prices.merchant_price);
			//$(elem).parent('td').parent('tr').find('.merchant_price span').html(prices.merchant_price+' Cust Price');
			$(elem).parent('td').parent('tr').find('.custom_merchant_price').val(prices.merchant_price);

		}
	});
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



</script>


@endpush