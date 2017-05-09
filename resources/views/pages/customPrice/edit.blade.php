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
						{!! Form::model($customPrice, ['method' => 'PATCH','route' => ['customPrice.update',$customPrice->id],'class' =>'form-horizontal']) !!}
							@include('pages.customPrice.formEdit')
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
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers-customprice.js') }}"></script


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
function init_product_dropdown(productRowId)
{

function movieFormatResult(record) {
            var markup = "<table class='movie-result'><tr>";
            if (record.posters !== undefined && record.posters.thumbnail !== undefined) {
                markup += "<td valign='top'><img src='" + record.posters.thumbnail + "'/></td>";
            }
            markup += "<td valign='top'><h5>" + record.product_name + "</h5>";
            if (record.critics_consensus !== undefined) {
                markup += "<div class='movie-synopsis'>" + record.critics_consensus + "</div>";
            } else if (record.synopsis !== undefined) {
                markup += "<div class='movie-synopsis'>" + record.synopsis + "</div>";
            }
            markup += "</td></tr></table>"
            return markup;
        }

		
        function movieFormatSelection(record) {
			//console.log(record);
			//console.log(record);
			
            return record.product_name;
			//alert('selection');
			
        }
		
		function changeAttribute(elem,record){
			
			//console.log(record);
			$(elem).parent('td').find('.product_name').val(record.product_name);
			getAttribute(elem, record.id);
			
		}

		function getAttribute(elem,product_id){
			//alert('this is data');
			//$('#product_id').val(product_id);
			var selected_attribute_id = $('#selected_attribute_id').val();
			
			var token,url,customer_id;
			token = $('input[name=_token]').val();
            url = $('#controller_url_path').val();
			url += '/attribute/'+product_id;
			customer_id = $('#customer_select').val();
			address_id = $('#address_id').val();
			if(selected_attribute_id > 0){
				url += '/'+selected_attribute_id;
			}else{
				url += '/0';
			}
			
			if(customer_id > 0){
				url += '/'+customer_id;
			}else{
				url += '/0';
			}
			
			if(address_id > 0){
				url += '/'+address_id;
			}else{
				url += '/0';
			}
			
			data = {product_id: product_id};

			$.ajax({

				headers: {'X-CSRF-TOKEN': token},
				url:url,
				type:'POST',
				data:data,
				beforeSend:function(){
					$('#attribute_loader').html('Loading....');
				},
				success:function(data){
					var response = $.parseJSON(data);
					if(response.error_code == 0){
						var responseView = response.view;
						var prices = response.price;
						var default_attr_name = response.default_attr_name;
						viewData = responseView.replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, '"');
									
						//$('#searched_attribute_id').html(data);
						var idd = $(elem).parent('td').parent('tr').attr('id');
								//console.log(idd);
						$(elem).parent('td').parent('tr').find('.attribute_id').html(viewData);
						$(elem).parent('td').parent('tr').find('.attribute_name').val(default_attr_name);
						
						//setting price default attribute price for default attribute start
						$(elem).parent('td').parent('tr').find('.base_price input').val(prices.price);
						$(elem).parent('td').parent('tr').find('.base_price input.base_price').html(prices.price);
						
						if(prices.specific_price > 0  ){
							if(prices.default_customer_specific_price == 'CUSTOM_PRICE'){
								$(elem).parent('td').parent('tr').find('.merchant_price input').attr('checked',true);
								$(elem).parent('td').parent('tr').find('.merchant_price input').val(prices.specific_price);
					
								$(elem).parent('td').parent('tr').find('.custom_merchant_price').val(prices.specific_price);

							}else{
								$(elem).parent('td').parent('tr').find('.specific_price input').attr('checked',true);
								$(elem).parent('td').parent('tr').find('.specific_price input').val(prices.specific_price);
								$(elem).parent('td').parent('tr').find('.specific_price input.specific_price').val(prices.specific_price);
							}
						}
					
					}else if(response.error_code ==1){
						
						alert('Unable to find Attribtues');
					}else{
						alert('Error in finding atributes contact to your adminsitrator ');
					}
				},
				complete:function(){
					$('#attribute_loader').html('');
					
				},
				failure:function(){
					alert('Unable to find Attributes');
				}
			});
		}

$("#product_id_"+productRowId).select2({
    placeholder: "Search Products",
    minimumInputLength: 1,
    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
        url:  $('#controller_url_path').val()+'/search',
        dataType: 'json',
        data: function (term, page) {
            return {
                q: term, // search term
                //page_limit: 10,
               // apikey: "ju6z9mjyajq2djue3gbvv26t" // please do not use so this example keeps working
            };
        },
        results: function (data, page) { // parse the results into the format expected by Select2.
            // since we are using custom formatting functions we do not need to alter remote JSON data
            return {
                results: data
            };
        }
    },
    initSelection: function (element, callback) {
        // the input tag has a value attribute preloaded that points to a preselected movie's id
        // this function resolves that id attribute to an object that select2 can render
        // using its formatResult renderer - that way the movie name is shown preselected
       /* var id = $(element).val();
        if (id !== "") {
            $.ajax($('#controller_url_path').val()+'/search', {
                data: {
					initial_selected_id: id
                    //apikey: "ju6z9mjyajq2djue3gbvv26t"
                },
                dataType: "json"
            }).done(function (data) {
                callback(data);
            });
        }
        */
    },
    formatResult: movieFormatResult, // omitted for brevity, see the source of this page
    formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
    dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
    escapeMarkup: function (m) {
        return m;
    } // we do not want to escape markup since we are displaying html in results
}).on('change', function(){
	
	 changeAttribute(this,$(this).select2('data'));
	//var idd = $(this).parent('td').parent('tr').attr('id');
	//console.log(idd);
			//console.log($(this).select2('data'));
});

}
</script>


<script>

var fileId = 0;
function add_customer(){

	fileId++;
	var data = $('#customer_div').html();
	var remove_button = '<div class="row"> <div class="col-md-6"> <div class="form-group"> <label class="control-label col-md-3">&nbsp;</label> <div class="col-md-9 action"> <a href="javascript:remove_customer(\''+fileId+'\');" class="btn btn-default btn-sm">Remove</a> </div> </div> </div> </div>';

	$('#customer_div_append').append('<div id="remove_cust_'+fileId+'"> <hr/>'+data+remove_button+'</div>');

	 ComponentsPickers.init();
}

function remove_customer(rowid){
	$('#remove_cust_'+rowid).remove();

}


var productRowId = 0;
function  add_row(){
 	productRowId++;
//console.log(productRowId);
/*
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

			ComponentsDropdowns.init();
   ComponentsDropdowns.init();
*/

	var row='<tr id="'+productRowId+'"> '+
				'<td>'+
					'<input id="product_id_'+productRowId+'" class="product_id" name="product_id" type="hidden" class="form-control">'+
					'<input class="product_name" name="product_name" type="hidden" class="form-control" value="">'+
					
				'</td>'+
				'<td class="attribute_td">'+

					'<select onchange="getAttributePrice(this)" class="select2 form-control attribute_id" id="attribute_id" name="attribute_id" tabindex="1" >'+

					'<option>Choose Attribute</option>'+

					'</select>'+	

					'<input class="attribute_name" name="attribute_name" type="hidden" class="form-control" value="">'+

				'</td>'+

				'<td class="base_price">'+
					'<input name=base_price type="text" class="form-control base_price" value ="" disabled/>'+
				'</td>'+
				'<td>'+
					'<input name=price type="text" class="form-control" value ="" required/>'+
				'</td>'+

				'<td >'+

					'<select class="select2 form-control" id="default_selected_price" name="default_selected_price" tabindex="1" required="true">'+

					'<option value="">Choose Default</option>'+
					'<option value="FIXED_PRICE">Fixed Price</option>'+
					'<option value="CUSTOM_PRICE">Custom Price</option>'+

					'</select>'+	

					'<input class="attribute_name" name="attribute_name" type="hidden" class="form-control" value="">'+

				'</td>'+			

				'<td>'+
					'<a href="javascript:add_price_list(\''+productRowId+'\');" class="btn btn-info btn-sm">'+
					'<i class="fa fa-plus"></i>Add</a>'+

					'<a href="javascript:remove_row(\''+productRowId+'\');" class="btn btn-warning btn-sm">'+
					'<i class="fa fa-times"></i>Remove</a>'+

					'<a id="data_loading"> </a>'+

				'</td>'+
			'</tr>';


		$('#add_product_row').append(row);

	   //require 2 times to initialze beacuse product dropdown was not taking 100% width
	   init_product_dropdown(productRowId);
	   init_product_dropdown(productRowId);
		//calculate_total_summary();
}

/*
function delete_row(rowid){
	//console.log('remove got clicked');
	
	$('#'+rowid).find('#delete_customer_price_detail').val('True');

	$('#'+rowid).hide();

}*/


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



function select_address(elem){
	//console.log('selection has changes'+$('#customer_select').val());
	var rowElem = $(elem).parent('div').parent('div').parent('div').parent('.row');
	
	var customer_id,token,url;
	customer_id = $(elem).val();
	token = $('input[name=_token]').val();
	url = '../../customer/general/address/'+customer_id;
	data = {customer_id: customer_id};

	$.ajax({

		headers: {'X-CSRF-TOKEN': token},
		url:url,
		type:'POST',
		data:data,
		beforeSend:function(){
			rowElem.find('#address_id').html('Loading....');
		},
		success:function(data){
			rowElem.find('#address_id').html(data);
		}
	});
}

function save_price_list(price_list_id){

	var rowElem = $('#row_'+price_list_id);
	var product_id  = rowElem.find("input[name='edit_product_id']").val();
	var attribute_id  = rowElem.find("#edit_attribute_id option:selected").val();
	var price  = rowElem.find("input[name='edit_price']").val();
	var default_selected_price  = rowElem.find("#edit_default_selected_price option:selected").val();
	token = $('input[name=_token]').val();
	//console.log(product_id+' '+attribute_id+' '+price+' '+default_selected_price);
	var url = '../../customPrice/general/updatelist/'+price_list_id;

	var data = {  product_id: product_id,attribute_id :attribute_id, price :price, default_selected_price:default_selected_price };

	$.ajax({

		headers: {'X-CSRF-TOKEN': token},
		url:url,
		type:'POST',
		data:data,
		beforeSend:function(){
			rowElem.find('#data_loding').html('Loading....');
		},
		success:function(data){
			rowElem.find('#data_loding').html('');

			if(data == 'SUCCESS'){
				alert('Data has been save successfully');
			}else{

				alert('There is error in adding data');
			}
			
		}
	});


}


function delete_price_list(price_list_id){

	var rowElem = $('#row_'+price_list_id);

	token = $('input[name=_token]').val();
	//console.log(product_id+' '+attribute_id+' '+price+' '+default_selected_price);
	var url = '../../customPrice/general/deletelist/'+price_list_id;

	var data = {   };

	$.ajax({

		headers: {'X-CSRF-TOKEN': token},
		url:url,
		type:'POST',
		data:data,
		beforeSend:function(){
			rowElem.find('#data_loding').html('Loading....');
		},
		success:function(data){
			rowElem.find('#data_loding').html('');

			if(data == 'SUCCESS'){
				rowElem.remove();
			}else{

				alert('There is error in deleting data');
			}
			
		}
	});


}

function add_price_list(row_id){

	var rowElem = $('#'+row_id);
	var product_id  = rowElem.find("input[name='product_id']").val();
	var attribute_id  = rowElem.find("#attribute_id option:selected").val();
	var price  = rowElem.find("input[name='price']").val();
	var default_selected_price  = rowElem.find("#default_selected_price option:selected").val();
	var custom_price_id  = $("input[name='custom_price_id']").val();

	token = $('input[name=_token]').val();
	//console.log(product_id+' '+attribute_id+' '+price+' '+default_selected_price);
	var url = '../../customPrice/general/addlist';

	var data = { product_id: product_id,attribute_id :attribute_id, price :price, default_selected_price:default_selected_price , custom_price_id:custom_price_id };

	$.ajax({

		headers: {'X-CSRF-TOKEN': token},
		url:url,
		type:'POST',
		data:data,
		beforeSend:function(){
			rowElem.find('#data_loding').html('Loading....');
		},
		success:function(data){
			rowElem.find('#data_loding').html('');

			if(data == 'SUCCESS'){
				alert('Data has been save successfully');
			}else{

				alert('There is error in Adding data');
			}
			
		}
	});


}



</script>


@endpush