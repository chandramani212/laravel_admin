@extends('layouts.main')

@section('title', 'Export your table')
@section('subTitle', '');

@push('headCss')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css')}} "/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css')}} "/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/clockface/css/clockface.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}"/>
@endpush

@section('content')
<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PORTLET-->
					<div class="portlet box blue-hoki">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Export Table {{ session('status') }}
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
							<!-- BEGIN FORM-->
							<form method="POST" action="{{ url('export/commonexportexcel') }}"" class="form-horizontal form-bordered">
							{{ csrf_field() }}
								<div class="form-body">

									<div class="form-group">
										<label class="control-label col-md-3">Select Table </label>
										<div class="col-md-3">

											<select name="table_name" id="table_name" class="form-control  select2me" required="true">
											
												<option value="" >select table</option>
												@foreach($tables as $table)
												<option value="{{ $table->$keyname }}" >
												 {{ $table->$keyname }} 
												 </option>
												 @endforeach

											</select>

											<a id="column_loader" ></a>

											<span class="help-block">
											 </span>
										</div>
									</div>

									<div id="column_div" style="display: none" class="form-group">
										<label class="control-label col-md-3">Select Columns</label>
										<div class="col-md-9">
											<select multiple="multiple" class="multi-select" id="table_columns" name="table_columns[]" required="true">
												
											</select>
										</div>
									</div>

									<div class="form-actions">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<button type="submit" class="btn purple"><i class="fa fa-check"></i> Export</button>
												<!--<button type="button" class="btn default">Cancel</button>
												-->
											</div>
										</div>
									</div>
								</div>
									
							</form>
							
							<!-- END FORM-->
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
			</div>
@endsection 


@push('footerJs')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/clockface/js/clockface.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js')}}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns.js')}}"></script>


<script>

        jQuery(document).ready(function() {       
           // initiate layout and plugins
           Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
           ComponentsPickers.init();
           //ComponentsDropdowns.init();
        });   

</script>


<script>
$("#table_name").change(function() {

	var table_name = $('#table_name').val();
	token = $('input[name=_token]').val();
	url = 'commonexportcolumn/'+table_name;
	data = {table_name: table_name};

 	$.ajax({
 		headers: {'X-CSRF-TOKEN': token},
 		url:url,
		type:'POST',
		data:data,
		beforeSend:function(){
				$("#column_loader").html(' Wait Getting Columns.....');
		},
		success:function(data){
			//$("#loader").html('');
			var htmlData = '';
			var response = $.parseJSON(data);
			response.forEach(function(getval){
				//console.log(getval);
				htmlData += '<option value="'+getval.Field+'" >'+getval.Field+' </option>';
			});

			$("#column_div").show();
			$("#table_columns").html(htmlData);

			//console.log(htmlData);
			
			
		},
		complete: function(){

			$("#column_loader").html('');
		},
		failure: function(){

			$("#column_loader").html('Error in fetching Columns');
		}


 	});
});
</script>

@endpush

