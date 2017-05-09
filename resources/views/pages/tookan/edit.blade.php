@extends('layouts.main')
@section('title', 'Tookan Settings')
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
							<i class="fa fa-gift"></i>Edit Tookan Settings
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
						<form class="form-horizontal" method="post" action="{{ route('tookan.update',1)}}">
							<input name="_method" type="hidden" value="PATCH">
							{{ csrf_field() }}

	<div class="form-body">
		<h3 class="form-section">Settings</h3>

		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<label class="control-label col-md-3">Api key </label>
					<div class="col-md-9">

   						<input type="text" id="api_key" name="api_key" class="form-control" value="{{ $tookan['api_key'] }}" required />

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>


			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3"> Api Base Url</label>
					<div class="col-md-9" id="customer_address">
   						
   						<input type="text" id="api_base_url" name="api_base_url" class="form-control" value="{{ $tookan['api_base_url']}}" required />

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>


			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3"> Version</label>
					<div class="col-md-9" id="customer_address">
   						
   						<input type="text" id="api_version" name="api_version" class="form-control" value="{{ $tookan['api_version']}}">

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3"> User Id</label>
					<div class="col-md-9" id="customer_address">
   						
   						<input type="text" id="user_id" name="user_id" class="form-control" value="{{ $tookan['user_id']}}">


						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3"> Status</label>
					<div class="col-md-9" id="customer_address">
   						
   						<select name="status" class="form-control">	
   							<option value="">Choose Status</option>		
							<option value="enable" {{ ($tookan['status'] == 'enable')?'selected':''}} >Enable</option>
							<option value="disable" {{ ($tookan['status'] == 'disable')?'selected':''}} >Disable</option>
						</select>


						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

		</div>

		<h3 class="form-section">Map zone to team</h3>
		<div class="tab-pane" id="tab_images">
			<div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
				<a id="loader"   >
											
					</a>
				
			</div>
			<div class="row">
				<div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12">
				</div>
			</div>
			<table class="table table-bordered table-hover">
			<thead>
			<tr role="row" class="heading">
				<th width="10%">
					 Team
				</th>
				<th width="30%">
					 Select Zone
				</th>

				<th width="10%">
				</th>
			</tr>
			</thead>
			<tbody id="add_row">
				@foreach($tookan['mapping'] as $key => $value )
					@php
						$active_zone = explode(',',$value); 
					@endphp
				<tr id="row_{{ $key }}" >
				<input name="edit_zone_team_id[]" type="hidden" class="form-control" value ="{{ $key }}" readonly="true" />
				<td>
					
					<input class="form-control" name="team_id[{{ $key }}]" type="text" class="form-control" value="{{ $key }}">
				
				</td>
				<td>

					<select name="zone_id[{{ $key }}][]" class="form-control select2 select2_sample_modal_2" multiple>
											
						<option value="" >Select Zone</option>
						@foreach($zones as $zone)
						<option value="{{ $zone->id }}" {{ (in_array($zone->id,$active_zone))?'selected':''}}>
						 {{ $zone->zone}} 
						 </option>
						 @endforeach

					</select>

				</td>
				<td>
					<a href="javascript:delete_row('row_{{$key}}');" class="btn default btn-sm">
					<i class="fa fa-times"></i> Delete 

					<input id="delete_zone_team_id" name="delete_zone_team_id[{{$key}}]" type="hidden" class="form-control" value ="False" readonly="true" />
				</a>
				</td>
				</tr>
				@endforeach

			</tbody>
			</table>

			<a class="btn yellow"  onclick="add_row()" data-toggle="modal">
											Add More<i class="fa fa-share"></i>
						</a>
				<a id="attribute_loader"   >
											
				</a>
		</div>
	

	</div>

	<div class="form-actions">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						{!! Form::submit('Submit', ['class' => 'btn green']) !!}
					</div>
				</div>
			</div>
			<div class="col-md-6">
			</div>
		</div>
	</div>


		

						</form> 
						
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
					
					'<input class="form-control" name="team_id[]" type="text" class="form-control" value="">'+
				
				'</td>'+
				'<td>'+

					'<select name="zone_id[]"  class="form-control select2 select2_sample_modal_2" multiple>'+					
						'<option value="" >Select Zone</option>'+
						@foreach($zones as $zone)
						'<option value="{{ $zone->id }}">{{ $zone->zone}}</option>'+
						 @endforeach
					'</select>'+

				'</td>'+

				'<td>'+
					'<a href="javascript:remove_row(\''+productRowId+'\');" class="btn default btn-sm">'+
					'<i class="fa fa-times"></i> Remove </a>'+
				'</td>'+
			'</tr>';



		$('#add_row').append(row);

	   //require 2 times to initialze beacuse product dropdown was not taking 100% width
	   ComponentsDropdowns.init();
		ComponentsDropdowns.init();
		//calculate_total_summary();
}

function delete_row(rowid){
	//console.log('remove got clicked');
	
	$('#'+rowid).find('#delete_zone_team_id').val('True');

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