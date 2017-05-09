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



var productRowId = 0;
function  add_row(){

 	productRowId++;
//console.log(productRowId);
	var row='<tr id="'+productRowId+'"> '+
				'<td>'+
					'<input  id="product_id_'+productRowId+'" class="product_id" name="product_id[]" type="hidden" class="form-control" required="true">'+
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
					

					'<label  style="position:relative;width: 90%" onclick="qty_change(this)" class="base_price col-md-14" >'+
					'<input  style="float:left;" id="PRICE" type="radio" name="price['+productRowId+']" checked class="icheck" value=""> <span style="margin-left : 5px;float:left;" >  VP </span>'+
					'<input style="margin-left : 5px;float:left;width: 40%;" class="base_price" type="text" value="0.00"  disabled/>'+
					'</label>'+

					'<label style="position:relative;width: 90%" onclick="qty_change(this)" class="specific_price col-md-14">'+
					'<input style="float:left;" id="SPECIFIC_PRICE" type="radio" name="price['+productRowId+']" class="icheck" value=""> <span style="margin-left : 5px;float:left;" > FP</span>'+
					'<input style="margin-left : 5px;float:left;width: 40%;" class="specific_price" type="text" value="0.00"  disabled/>'+
					'</label>'+

/*
					'<label style="position:relative;" onclick="qty_change(this)" class="sell_price col-md-14">'+
					'<input id="SELL_PRICE" type="radio" name="price['+productRowId+']" class="icheck" value=""> <span class="sell_price"> Sell Price</span>'+
					'</label>'+
*/
					'<label style="position:relative;width: 90%" onclick="qty_change(this)" class="merchant_price">'+
					'<input  style="float:left;" id="CUSTOM_PRICE" type="radio" name="price['+productRowId+']"  class="icheck" value="" >'+ 
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
/*

				'<td>'+
					'<input  name=order_detail_comment[] type="text" class="form-control" value ="" />'+
				'</td>'+
*/
				'<td>'+
					'<a href="javascript:remove_row(\''+productRowId+'\');" class="btn default btn-sm">'+
					'<i class="fa fa-times"></i> Remove </a>'+
				'</td>'+
			'</tr>';



		$('#add_product_row').append(row);

		init_product_dropdown(productRowId);
	   init_product_dropdown(productRowId);
		//ComponentsDropdowns.init();
		//ComponentsDropdowns.init();
		
}

function get_default_order(){

	var customer_id,token,url;
	customer_id = parseInt($('#customer_select').val());
	address_id = parseInt($('#address_id').val());
	token = $('input[name=_token]').val();
	url = '../customer/general/defaultorder/'+customer_id+'/'+address_id;
	data = {customer_id: customer_id};
	if(customer_id > 0 )
	{
		$.ajax({

			headers: {'X-CSRF-TOKEN': token},
			url:url,
			type:'POST',
			data:data,
			beforeSend:function(){
					$("#loader").html(' Wait Getting Default order.....');
			},
			success:function(data){
				//$("#loader").html('');
				if(data == 'NO_DEFAULT_ORDER'){

					alert('There is no default order');

				}else{

					$('#add_product_row').html(data);
					ComponentsDropdowns.init();
				}
				
			},
			complete: function(){

				$("#loader").html('');
			},
			failure: function(){
				$("#loader").html('Error in fetching Default order');
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

	console.log('inside this');
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
		$(elem).parent('td').find('.specific_price').show();	
		//$(elem).parent('td').find('.sell_price').show();	
		$(elem).find('span').html('Hide');
	}else{

		$(elem).parent('td').find('.base_price').hide();	
		//$(elem).parent('td').find('.sell_price').hide();
		$(elem).parent('td').find('.specific_price').hide();
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

$("input[type^=submit]").click(function(e){
	console.log('This is clicked');
	e.preventDefault();

	$('input[name^=qty]').each(function() {
		qty_change(this);
	  // product_total =parseFloat( product_total) + parseFloat($(this).val());
	});


	$('form').submit()


});




function getAttributePrice(elem){
	//console.log('selection has changes'+$(elem).val());
	var attribute_name = $(elem).find('option:selected').text();
	//console.log('attribute:'+attribute_name);
	$(elem).parent('td').find('input[name^=attribute_name]').val(attribute_name);
	var attribute_id,token,url;
	attribute_id = $(elem).val();
	customer_id = $('#customer_select').val();
	address_id = $('#address_id').val();
	token = $('input[name=_token]').val();

	url = '../attribute/general/allprice/'+attribute_id

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

			//console.log(prices.price+' '+prices.sell_price+' '+prices.merchant_price);	
			$(elem).parent('td').parent('tr').find('.base_price input').val(prices.price);
			$(elem).parent('td').parent('tr').find('.base_price input.base_price').val(prices.price);

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

			
/*
			$(elem).parent('td').parent('tr').find('.sell_price input').val(prices.sell_price);
			$(elem).parent('td').parent('tr').find('.sell_price span.sell_price').html(prices.sell_price+' Sell Price');
*/
		

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
			$('#address_id').html('Loading....');
		},
		success:function(data){
			$('#address_id').html(data);
		}
	});
});




</script>


@endpush