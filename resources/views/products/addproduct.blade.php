
@extends('layouts.main')

@section('title', 'Add Product')
@section('subTitle', 'create new product and it\'s attributes')

@push('headCss')
 <meta name="_token" content="{!! csrf_token() !!}" />
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css')}} "/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_0" data-toggle="tab">
                        Form Actions </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_0">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Form Actions On Bottom
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

                            <form class="form-horizontal" role="form" method="POST" action="{{ route('product.store') }}"> 

                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Product Name</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-circle" placeholder="Enter text" name='product_name'>

                                        </div>
                                    </div>
									
									
									<div class="form-group">
                                        <label class="col-md-3 control-label">Category Name</label>
                                        <div class="col-md-4">
                                            
											<select class="form-control" data-placeholder="Select..." name="category_id" required>
                                                        <option value=""></option>
                                                        @foreach($categories as $category  )
                                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                        @endforeach
                                             </select>

                                        </div>
                                    </div>
									
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">attribute value</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-circle" placeholder="attribute" name="attribute[attribute_name][]">
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control input-small select2me" data-placeholder="Select..." name="attribute[uom][]">
                                                        <option value=""></option>
                                                        @foreach($uom as $key=>$value  )
                                                        <option value="{{$value}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                              
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Price</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Price" name="attribute[price][]">
                                                    <input type="text" class="form-control" placeholder="Sale price" name="attribute[sale_price][]">
                                                </div>
                                            </div>
                                        </div>

                                         
                                    </div>
                                    <div class="form-group last">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-4">
                                            <span class="form-control-static">
                                                <a href="#" class="addAttribute">Add more attributs </a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-circle blue">Submit</button>
                                            <button type="button" class="btn btn-circle default">Cancel</button>
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
</div>
@endsection
@push('footerJs')

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/form-samples.js')}}"></script>

<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function () {
// initiate layout and plugins
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features
    FormSamples.init();
});

$(".addAttribute").click(function () {
    
    $(".last").before('<div class="row"><div class="col-md-6"><div class="form-group"><label class="col-md-3 control-label">attribute value</label><div class="col-md-4"><input type="text" class="form-control input-circle" placeholder="attribute" name="attribute[attribute_name][]"></div> <div class="col-md-4"><select class="form-control input-small select2me" data-placeholder="Select..." name="attribute[uom][]"><option value=""></option>@foreach($uom as $key=>$value)<option value="{{$value}}">{{$value}}</option>@endforeach</select></div></div></div><div class="col-md-6"><div class="form-group"><label class="control-label col-md-3">Price</label> <div class="col-md-9"><input type="text" class="form-control" placeholder="Price" name="attribute[price][]"> <input type="text" class="form-control" placeholder="Sale price" name="attribute[sale_price][]">  </div> </div>  </div>  </div>');
})
</script>
<!-- END JAVASCRIPTS -->

@endpush