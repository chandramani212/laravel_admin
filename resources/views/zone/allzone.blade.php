
@extends('layouts.main')

@section('title', 'All Zone')
@section('subTitle', 'All Zone')


@push('headCss')
<meta name="_token" content="{!! csrf_token() !!}" />
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css')}} "/>
<!-- END PAGE LEVEL PLUGIN STYLES -->


<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-nestable/jquery.nestable.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="{{ URL::asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
<link id="style_color" href="{{ URL::asset('assets/admin/layout/css/themes/darkblue.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endpush

@section('content')


<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

<!-- /.modal -->
<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<!-- BEGIN STYLE CUSTOMIZER -->

<!-- END STYLE CUSTOMIZER -->
<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
    Nestable List <small>Drag & drop hierarchical list with mouse and touch compatibility</small>
</h3>

<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<form >
    <div class="row">

        <div class="col-md-12">
            <div class="margin-bottom-10" id="nestable_list_menu">
                <button type="button" class="btn" data-action="expand-all">Expand All</button>
                <button type="button" class="btn" data-action="collapse-all">Collapse All</button>
                <button type="button" class="btn" data-action="Submit" id="submit">Submit</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Serialised Output (per list)</h3>
            {{$j=0}}
            @foreach($zone_list as $zone)
            <textarea id="nestable_list_{{$zone->id}}_output" class="form-control col-md-12 margin-bottom-10" name="nestable_list_output[{{$zone->id}}]" style="display:none" ></textarea>

            @endforeach
        </div>
    </div>
</form>
<div class="row">
    {{$i=0}}
    @foreach($zone_list as $zone)

    <div class="col-md-6">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-comments"></i>{{$zone->zone}}
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
            <div class="portlet-body ">
                <div class="dd" id="nestable_list_{{$zone->id}}" name="{{++$i}}">
                    <ol class="dd-list">
                        @foreach($merchant_list->where('zone_id', $zone->id) as $merchant)
                        <li class="dd-item" data-id="{{$merchant->id}}">
                            <div class="dd-handle">
                                {{ $merchant->first_name }}
                            </div>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>



@endsection
@push('footerJs')

<script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ URL::asset('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/global/plugins/jquery-nestable/jquery.nestable.js') }}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/admin/pages/scripts/ui-nestable.js') }}"></script>
<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script>
jQuery(document).ready(function () {
    // initiate layout and plugins
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features
    var count =<?php echo $i; ?>;
    UINestable.init(count);
});
$("#submit").click(function () {
    alert('test');
    $.ajax({
        url: 'zoneupdate',
        type: 'POST',
        data: {
             'formdata' : $('form').serializeArray(),
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function () {
            alert("success")
        },
        error: function ()
        {
            alert('error');
        }
    });
});
</script>
<!-- END JAVASCRIPTS -->

@endpush