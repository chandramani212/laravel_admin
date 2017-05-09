
@extends('layouts.main')

@section('title', 'Add Product')
@section('subTitle', 'create new product and it\'s attributes')

@push('headCss')
<meta name="_token" content="{!! csrf_token() !!}" />

@endpush
@section('content')

<div class="row">
                <div class="col-md-12">
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bell-o"></i>{{ $user->name}} has Asign Amount {{$procurements->total_budget}}
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
                                        <i class="fa fa-briefcase"></i> Product Name
                                    </th>
                                    <th class="hidden-xs">
                                        <i class="fa fa-user"></i> Uom
                                    </th>
                                    <th>
                                        <i class="fa fa-shopping-cart"></i>Qty
                                    </th>
                                    
                                    
                                    <th></th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                
            <form class="forget-form" role="form" method="POST" action="{{ url('/product') }}">
                         {{ csrf_field() }}
                         <input type="hidden" name="_method" value="PATCH"/>
                         @foreach($procurement_detail as $product_list)
                                <tr>
                                    <td class="">
                                        <input type="text" name="attribute_name" value="{{$product_list->product->product_name}}" disabled >
                                    </td>
                                    <td>
                                         <input type="text" name="price" value="{{$product_list->purchase_qty}}" disabled >
                                    </td>

                                    <td class="hidden-xs">
                                         <input type="text" name="attribute_name" value="{{$product_list->uom}}" disabled >
                                    </td>
                                    
                                     
                                   
                                </tr>
                        @endforeach
                            <tr>
                            <td colspan="3" align="center">
                                <a href="javascript:;" class="btn default btn-xs purple edit">
                                        <i class="fa fa-edit edit"></i> print </a>
                            </td></tr>
                                </form>
                                
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

@endpush