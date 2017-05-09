@extends('layouts.main')

@section('title', 'Add Product')
@section('subTitle', 'create new product and it\'s attributes')

@push('headCss')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>

<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN THEME STYLES -->
<link href="{{ URL::asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
<link id="style_color" href="{{ URL::asset('assets/admin/layout/css/themes/darkblue.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/css/jquery-customselect.css')}} "/>
<style>
.custom-select{width: 200px; }
.custom-select input{width: 185px; }
</style>

@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
				<i class="fa fa-gift"></i>Procurement Details
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse">
					</a>
					<a href="javascript:;" class="reload">
					</a>
				</div>
			</div>
			<div class="portlet-body form">
				<form  class="form-horizontal form-row-sepe" method="POST" action="{{ url('/procurement') }}{{ 
				'/'.$procurements->id}}">
				<input type="hidden" name="_method" value="PATCH"/>
					{{ csrf_field() }}
					<div class="form-body">
						
						<div class="form-group">
							<label class="control-label col-md-3">Agent Name</label>
							<div class="col-md-4">
								{{ $user->name }}
							<input type="hidden" name="agent_id" value="{{ $procurements->agent_id }}">	  
							</div>
						</div>
						<div class="form-group ">
							<label class="control-label col-md-3" for="inputWarning">Agent budget</label>
							<div class="col-md-3">
								{{$procurements->total_budget}}
								<input type="hidden" name="total_budget" value="{{$procurements->total_budget}}">
							</div>
						</div>
						<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bell-o"></i>Product Details
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
						<div class="portlet-body">
							<div class="table-scrollable">
								<table id="procurement" class="table table-striped table-bordered table-advance table-hover">
								<thead>
								<tr>
									<th>
										<i class="fa fa-briefcase"></i> Product Name
									</th>
									<th class="hidden-xs">
										<i class="fa fa-user"></i> Purchase Qty
									</th>
									<th>
										<i class="fa fa-shopping-cart"></i> Uom
									</th>
									<th>
										<i class="fa fa-shopping-cart"></i> Purchase Price
									</th>
									<th>
										<i class="fa fa-shopping-cart"></i> Expenses 				</th>
									
								</tr>
								</thead>
								<tbody>
								@foreach($procurement_detail as $product_list)	

							<tr>
							<input type="hidden" name="attribute[id][]"
							value="{{$product_list->id}}">
							   <td style="width: 275px; height: 50px;">
								 	
								<div class="col-md-4" style="position:absolute;">
									{{$product_list->product->product_name}}
									
									<input type="hidden" name="product[product_name][]" value="{{$product_list->product->product_name}}">
								</div>
							 </td>
							<td style="width: 275px; height: 50px;">
										
								<div class="col-md-4" style="position:absolute;">
									{{$product_list->purchase_qty}}
									
									<input type="hidden" name="attribute[purchase_qty][]" value="{{$product_list->purchase_qty}}">
								</div>
							</td>
							<td>
                               {{$product_list->uom}}
                               <input type="hidden" name="attribute[uom][]" value=" {{$product_list->uom}}">
							</td>
							<td>
                                <input type="text" class="form-control input-circle" name="attribute[purchase_price][]" placeholder="price" value="{{$product_list->purchase_price}}">   
							</td>
							<td>
                               <textarea name="attribute[expences][]">
                               	{{$product_list->expenses}}
                               </textarea>
							</td>
							
							</tr>
							@endforeach
							
								
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->

					<div class="form-group">
										<label class="col-md-3 control-label">Expense Amount</label>
										<div class="col-md-9">
											<input type="text" name="total_expenses" class="form-control input-inline input-medium" placeholder="Enter text">
											
										</div>
									</div>
					<div class="form-group form-md-line-input">
										<textarea class="form-control" rows="3" placeholder="" name="expnses"></textarea>

										<label for="form_control_1">Other Expences(click to type)</label>
					</div>

				</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn purple"><i class="fa fa-check"></i> Submit</button>
									<button type="button" class="btn default">Cancel</button>
								</div>
							</div>
					</div>

					</div>
				</form>
				
				<!-- END FORM-->
			</div>
		</div>
	</div>

</div>
@endsection

@push('footerJs')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
        jQuery(document).ready(function() {    
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            QuickSidebar.init(); // init quick sidebar
            Demo.init(); // init demo features
        });
    </script>


@endpush
