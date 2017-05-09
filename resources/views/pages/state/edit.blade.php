@extends('layouts.main')
@section('title', 'State')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>

<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')

<div class="row">
	<div class="col-md-12 ">
		<div class="tabbable-line boxless tabbable-reversed">
			<div class="tab-content">
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gift"></i>State Edit
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
						{!! Form::model($state, ['method' => 'PATCH','route' => ['state.update', $state->id],'class' =>'form-horizontal']) !!}
							@include('pages.state.formEdit')
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
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/global/plugins/icheck/icheck.min.js') }}"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/form-samples.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/form-icheck.js') }}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   FormSamples.init();
   // ComponentsPickers.init();
});
</script>


<script>
var fileId = 0;
function add_address(){
	fileId++;
	var data = $('#address_div').html();
	var remove_button = '<div class="row"> <div class="col-md-6"> <div class="form-group"> <label class="control-label col-md-3">&nbsp;</label> <div class="col-md-9 action"> <a href="javascript:remove_address(\''+fileId+'\');" class="btn btn-default btn-sm">Remove</a> </div> </div> </div> </div>';

	$('#dynamic_add_address_div').append('<div id="remove_'+fileId+'"> <hr/>'+data+remove_button+'</div>');
}

function remove_address(id){

	$('#remove_'+id).remove();
}
</script>

@endpush