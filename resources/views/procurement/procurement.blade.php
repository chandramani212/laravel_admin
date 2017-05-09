@extends('layouts.main')

@section('title', 'Add Product')
@section('subTitle', 'create new product and it\'s attributes')

@push('headCss')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/css/jquery-customselect.css')}} "/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/clockface/css/clockface.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}"/>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
                <form  class="form-horizontal form-row-sepe" method="POST" action="{{ route('procurement.store') }}">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="control-label col-md-3">Agent Name</label>
                            <div class="col-md-4">
                                <select id="demo" name="agent_id" class="custom-select demo" >
                                    <option value="">Please Select</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-md-3" for="inputWarning">Agent budget</label>
                            <div class="col-md-3">
                                <input type="text" name="total_budget" class="form-control" id="inputWarning"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-bell-o"></i>Product Details

                                    </div>
                                    <div></div>
                                    <div>
                                        <input class="form-control form-control-inline input-medium date-picker" placeholder="Select Date" size="16" type="text" value="" name="orderdate" id="orderdate"  />
                                        <a href="javascript:;"  id="get_procurement" class="btn default btn-xs purple ">
                                            <i class="fa fa-edit"></i> get Procurement </a>
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
                                                        <i class="fa fa-user"></i> Uom
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-shopping-cart"></i> Purchase Qty
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-shopping-cart"></i> Budget Price
                                                    </th>
                                                    <th>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="procurmentDetails" >
                                                <tr id="firstrow">
                                                    <td style="width: 275px; height: 50px;">

                                                        <div class="col-md-4" style="position:absolute;">
                                                            <select style="width: 228px !important"  name="product[product_name][]" class="custom-select demo" data-placeholder="Select...">
                                                                <option value="">Please Select</option>
                                                                @foreach($products as $product)
                                                                <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td style="width: 275px; height: 50px;">

                                                        <div class="col-md-4" style="position:absolute;">
                                                            <select style="width: 228px !important"  name="attribute[uom][]" class="custom-select demo" data-placeholder="Select...">
                                                                <option value="">Please Select</option>
                                                                @foreach($uoms as $key=>$value  )
                                                                <option value="{{ $value}}">{{$value}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control input-circle"  name="attribute[purchase_qty][]" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control input-circle" placeholder="price">   
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" class="btn default btn-xs purple remove">
                                                            <i class="fa fa-edit"></i> Re-move </a>
                                                    </td>
                                                </tr>

                                                <tr class="before"><td colspan="4" align="center"><a href="javascript:;" class="btn default btn-xs purple addmore">
                                                            <i class="fa fa-edit"></i> Add more </a></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
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

<script type="text/javascript" src="{{ URL::asset('assets/admin/pages/scripts/jquery-customselect.js')}}"></script>
<script>
$(function () {
    $(".demo").customselect();
});

$('.addmore').click(function () {
    $('.before').before('<tr><td style="width: 275px; height: 50px;"><div class="col-md-4" style="position:absolute;"><select style="width: 228px !important"  name="product[product_name][]"class="custom-select demo" data-placeholder="Select..."><option value="">Please Select</option></option>@foreach($products as $product)<option value="{{$product->id}}">{{$product->product_name}}</option>@endforeach</select></div></td><td style="width: 275px; height: 50px;"><div class="col-md-4" style="position:absolute;"><select style="width: 228px !important"  name="attribute[uom][]" class="custom-select demo" data-placeholder="Select..."><option value="">Please Select</option>@foreach($uoms as $key=>$value  )<option value="{{ $value}}">{{$value}}</option>@endforeach</select></div></td><td><input type="text"  name="attribute[purchase_qty][]" class="form-control input-circle" placeholder="Qty"></td><td><input type="text" class="form-control input-circle" placeholder="price"></td><td><a href="javascript:;" class="btn default btn-xs purple remove "><i class="fa fa-edit"></i> Re-move </a></td></tr>');
    $(".demo").customselect();
})




$('#procurement').on('click', '.remove', function () {
    alert('hello');
    $(this).closest('tr').remove();
})
</script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/clockface/js/clockface.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js')}}"></script>
<script>
jQuery(document).ready(function () {
    // initiate layout and plugins
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features
    ComponentsPickers.init();
});
$("#get_procurement").click(function () {
    var orderdate = $("#orderdate").val();
    if (orderdate == '') {
        alert("Please select date");
    } else
    {
        $.ajax({
            url: '../procurementgeneral/procurement',
            type: 'GET',
            data: {'orderdate': orderdate,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                $("table").find("tr:not(:last)").remove();
                $('.before').before(data);
              
            },
            error: function ()
            {
                alert('error');
            }
        });
    }
});
</script>
@endpush
