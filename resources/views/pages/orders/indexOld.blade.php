@extends('layouts.main')
@section('title', 'Orders')
@section('subTitle', '')

@push('headCss')
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12">
		    @if ($message = Session::get('success'))
		        <div class="alert alert-success">
		            <p>{{ $message }}</p>
		        </div>
		        {{ Session::forget('success') }}
		    @endif
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>Order
					</div>
					<div class="actions">
						<a href="{{ route('order.create') }}" class="btn btn-default btn-sm">
						<i class="fa fa-plus"></i> Create Order </a>
					
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover" id="sample_3">
					<thead>
					<tr>
					<!--
						<th class="table-checkbox">
							<input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>
						</th>
					-->
						<th>
							Sr.No
						</th>

						<th>
							Order Id
						</th>
						<th>
							Order Total
						</th>
						<th>
							Customer Name
						</th>
						<th>
							 Action
						</th>
					</tr>
					</thead>
					<tbody>
					{{ $i = 0 }}
					@foreach ($orders as $order)
					<tr class="odd gradeX">
						<!--<td>
							<input type="checkbox" class="checkboxes" value="1"/>
						</td>
						-->
						<td>
							{{ ++$i }}
						</td>
						<td>
							{{ $order->id }}
						</td>
						<td>
							 {{ $order->order_total }}
						</td>
						<td>
							{{ $order->customer->first_name or ''}} {{ $order->customer->last_name or '' }}
						</td>
						<td>
						<a class="btn default btn-xs green-stripe" href="{{ route('order.show',$order->id) }}"> View </a>

						<a class="btn default btn-xs green" href="{{ route('order.edit',$order->id) }}">
						Edit
						</a>
						{!! Form::open(['method' => 'DELETE','route' => ['order.destroy', $order->id],'style'=>'display:inline']) !!}
			            {!! Form::submit('Delete', ['class' => 'btn default btn-xs red ']) !!}
			            {!! Form::close() !!}

						</td>
					</tr>
					@endforeach
					
					</tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>			
@endsection
@push('footerJs')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/table-managed.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   TableManaged.init();
});
</script>

@endpush