
@extends('layouts.main')

@section('title', 'Add Product')
@section('subTitle', 'create new product and it\'s attributes')

@push('headCss')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>
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

<div class="row">
                <div class="col-md-12">
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bell-o"></i>{{ $products[0]->product_name }}
                                <input type="hidden" name="" id="product_id" value="{{ $products[0]->product_id}}">
                                 <select class="form-control input-small select2me" data-placeholder="Select..." name="category" id="category" required>
                                <option value=""></option>
                                @foreach($categories as $category)
                                @if($products[0]->category_id == $category->id)
                                <option value="{{$category->id}}" selected="">{{$category->category_name}}</option>
                                @else
                                <option value="{{$category->id}}" >{{$category->category_name}}</option>
                                @endif
                                @endforeach
                                </select>
                                <a href="javascript:;" class="btn default btn-xs purple " id="assign_category">
                                <i class="fa fa-edit edit"></i> Assign Category </a>
                               @if(session('message'))
                                {{session('message')}}
                                @endif
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
                        <div class="portlet-body flip-scroll">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-advance table-hover" id="attributesTable">
                                <thead>
                                <tr>
                                    <th>
                                        <i class="fa fa-briefcase"></i> Attribute &nbsp;Value
                                    </th>
                                    <th class="hidden-xs">
                                        <i class="fa fa-user"></i> Uom
                                    </th>
                                    <th>
                                        <i class="fa fa-shopping-cart"></i>product Price
                                    </th>
                                    <th>
                                        <i class="fa fa-shopping-cart"></i>Sale Price
                                    </th>
                                    <th>
                                        <i class="fa fa-shopping-cart"></i> Status
                                    </th>
                                    <th></th>
                                    <th>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
    @foreach($products as $product)                     
     <form class="forget-form" role="form" method="POST" action="{{ url('/product') }}{{ '/'.$product->product_id}}">
                         {{ csrf_field() }}
                         <input type="hidden" name="_method" value="PATCH"/>
                                <tr>
                                    <td class="">
                                        <div class="success">
                                        </div>
                                        <input type="text" name="attribute_name" value="{{$product->attribute_name }}" disabled >
                                        <input type="hidden" name="attribute_id" value="{{$product->id }}">
                                    </td>
                                    <td class="hidden-xs">
                                         
                                 <select class="form-control input-small select2me" data-placeholder="Select..." name="uom" disabled>
                                <option value=""></option>
                                @foreach($uom as $k=>$v )
                                @if($v == $product->uom)
                                <option value="{{$v}}" selected="">{{$v}}</option>
                                @else
                                <option value="{{$v}}" >{{$v}}</option>
                                @endif
                                @endforeach
                            </select>

                                    </td>
                                    <td>
                                         <input type="text" name="price" value="{{ $product->price }}" disabled >
                                    </td>

                                     <td>
                                         <input type="text" name="sale_price" value="{{ $product->sale_price }}" disabled >
                                    </td>
                                    <td><input type="text" name="status" value="{{$product->status }}" disabled ></td>
                                    <td>
                                        <a href="javascript:;" class="btn default btn-xs purple edit">
                                        <i class="fa fa-edit edit"></i> Edit </a>
                                        <a  class="btn default btn-xs purple delete" href="javascript:deleteUser('{{ $product->id }}');">Delete</a>
                                        <a href="javascript:;" class="btn default btn-xs purple cancel" style="display: none;">
                                        <i class="fa fa-edit"></i> cancel </a>

                                        <a href="{{ route('ProductAttributePriceHistory',$product->id) }}" class="btn default btn-xs purple cancel" >
                                        <i class="fa fa-edit"></i> History </a>
                                    

                                        <input style="display: none;" type="submit" name="submit" value="Save" class="btn default btn-xs purple" />

                                         
                                    </td>
                                </tr>
                                </form>
                                @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                </div>
                
            </div>

@endsection
@push('footerJs')

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>

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
          // TableAjax.init();
        });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        
         $('.edit').click(function() {
            $(this).parent('td').find('input[name=submit]').show();
            $(this).parent('td').find('.cancel').show();
            $(this).parent('td').find('.delete').hide();
            $(this).hide();
            $(this).parent('td').parent('tr').find("input,select").each(function(){
                    //alert($(this).val());
                    $(this).attr('disabled',false);
            });
         });

        $('.cancel').click(function() {
            $(this).parent('td').find('input[name=submit]').hide();
            $(this).parent('td').find('.edit').show();
             $(this).hide();
              $(this).parent('td').find('.delete').show();
            $(this).parent('td').parent('tr').find("input,select").each(function(){
                    //alert($(this).val());
                    $(this).attr('disabled',true);
            });

         });
         
    });
    function deleteUser(id) {
    if (confirm('Delete this atrribute?')) {
        $.ajax({
            type: "POST",
           data:{
                '_method':'DELETE',
                'id':id
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //url: "{{ route('product.destroy', 1) }}" , //resource
            url:'../../product/'+id,
            success: function(data) {
               window.location.reload();
               
            }
        });
    }
}
$("#assign_category").click(function(e){
    //alert($("#category").val() +" " + $("#product_id").val() + $('meta[name="csrf-token"]').attr('content'));
   /* $.ajax({
        type:"POST",
        data:{
            'product_id':$("#product_id").val(),
            'category_id':$("#category").val()
        }
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        url: 'route('updateProductCategory')',
        success: function(response){ // What to do if we succeed
        console.log(response); 
    }
    });*/
	
	var category_id  = $("#category").val();
	if(category_id=='' || category_id==null){
		alert("please select category id");
		e.preventDefault();
		
	}else{
	
    $.ajax({
    url: '../general/updateproductcategory',
    type: 'POST',
    data: {'product_id':$("#product_id").val(),
            'category_id':category_id,
            '_token':$('meta[name="csrf-token"]').attr('content')
         },
     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
   
    success: function () {
        alert("success")
    },
    error:function()
    {
        alert('error');
    }
});

	}

})
</script>
@endpush