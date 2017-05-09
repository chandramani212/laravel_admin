@extends('layouts.main')
@section('title', 'Stocks')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
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
							<i class="fa fa-gift"></i>Stock Edit
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
						{!! Form::model($stock, ['method' => 'PATCH','route' => ['stock.update', $stock->id],'class' =>'form-horizontal']) !!}
							@include('pages.stocks.formEdit')
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

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/form-samples.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns-product.js') }}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   FormSamples.init();
    ComponentsDropdowns.init();
});
</script>

<script>
var fileId = 0;
function add_more(){
	fileId++;
	var data = 

			'<tr id="'+fileId+'">'+ 

				'<td>'+
					'<input onkeyup="change_qty_in_hand()" name="basic_qty[]" type="text" class="form-control" value =""  />'+
				'</td>'+
				'<td>'+

					'<input name="reason[]" type="textarea" class="form-control" value =""  />'+

				'</td>'+

				'<td>'+
					
					'<a href="javascript:delete_row(\''+fileId+'\');" class="btn default btn-sm remove">'+
					'<i class="fa fa-times"></i> Remove '+
					'</a>'+

				'</td>'+
			'</tr>';


	$('#add_row').append('<tr id="remove_'+fileId+'">'+data+'</tr>');
}


function remove_row(rowid){
	//console.log('delete row is called');
	$('#'+rowid).remove();

}

function delete_row(rowid){
	//console.log('remove got clicked');
	
	$('#'+rowid).find('#delete_stock_wastage').val('True');
	$('#'+rowid).hide();

}

function change_qty_in_hand(){

	var total_qty_in_hand = parseInt( $('input[name=actual_qty_hand]').val() );
	var totalWasteQty =  parseInt( $('input[name=totalWasteQty]').val() ); 

	var edit_waste_qty = 0;
	$('input[name^=edit_basic_qty]').each(function() {
	   edit_waste_qty =parseInt( edit_waste_qty) + parseInt($(this).val());
	});

	if($.isNumeric(edit_waste_qty) ){

	}else{

		edit_waste_qty = 0;
	}

	var add_waste_qty = 0;
	$('input[name^=basic_qty]').each(function() {
	   add_waste_qty =parseInt( add_waste_qty) + parseInt($(this).val());
	});

	if($.isNumeric(add_waste_qty) ){

	}else{

		add_waste_qty = 0;
	}

	var final_qty = (total_qty_in_hand + totalWasteQty)- edit_waste_qty - add_waste_qty;
	if(final_qty <0 ){
		final_qty = 0;
	}

	 $('input[name=total_qty_in_hand]').val(final_qty);

	//console.log(total_waste_qty);
}



</script>


@endpush