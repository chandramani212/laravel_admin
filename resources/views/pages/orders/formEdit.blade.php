	<div class="form-body">
		<h3 class="form-section">Customer Info</h3>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Customer </label>
					<div class="col-md-9">
   						{!! Form::select('customer_id', $customerOption, $order->customer_id, array('Placeholder' => 'choose User' ,'id' => 'customer_select' ,'class' => 'select2_category form-control', 'tabindex'=> '1', 'required'=> 'true')) !!}					
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Address</label>
					<div class="col-md-9" id="customer_address">
   						
   						<select name="address_id" id="address_id" class="form-control" required>		@foreach($addressOption as $key => $address)
   								<option value="{{$key}}" {{ ($order->address_id ==$key)?'selected':'' }} >{{ $address }}</option>

   							@endforeach
   							
   						</select>
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Created Date </label>
					<div class="col-md-9">
						<!--<div class="input-group date form_meridian_datetime input-large" data-date=""> -->
						<div class="input-group input-medium date date-picker input-large" data-date-format="yyyy-mm-dd" >
						@php
						$date  = explode(" ",$order->created_at);
						@endphp
							<input type="text" name="created_at"  class="form-control" value="{{ $date[0] }}">
							<span class="input-group-btn">
							<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
							<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">PI NO</label>
					<div class="col-md-9" id="customer_address">
   						<input type="number" class="form-control" name="pi_no" id="pi_no" value="{{ $order->pi_no }}" />
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>


		</div>


		<h3 class="form-section">Product Info</h3>
		<div class="tab-pane" id="tab_images">
			<div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
				<a id="loader"   >
											
					</a>
				<a class="btn yellow"  onclick="set_default_order()" data-toggle="modal">
											Set Default Order<i class="fa fa-share"></i>
											</a>
			</div>
			<div class="row">
				<div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12">
				</div>
			</div>
			<table class="table table-bordered table-hover">
			<thead>
			<tr role="row" class="heading">
				<th width="15%">
					 Product
				</th>
				<th width="10%">
					 Product Attribute
				</th>

				<th width="5%">
					 Quantity
				</th>
				<th width="15%">
					 Price
				</th>
				<th width="10%">
					 Total Price
				</th>
<!--
				<th width="10%">
					 Comment
				</th>
-->
				<th width="10%">
					 Qc Comment
				</th>

				<th width="10%">
				</th>
			</tr>
			</thead>
			<tbody id="add_product_row">
			<?php $i=0; ?>
			@foreach($orderDetails as $orderDetail )
			@php
				
				$attributes = App\product_attribute::where('product_id','=',$orderDetail->product_id)->get();
				
				
				if(!$attributes->isEmpty())
				{
				$priceControllers = new App\Http\Controllers\AttributeGeneralController;
				$allPrice = json_decode( $priceControllers->postAllprice($orderDetail->attribute_id,$order->customer_id,$order->address_id) );

				$attribute_val='';
		
				
				}else{
					
					$allPrice->price = 0;
					$allPrice->sell_price = 0;
					$allPrice->merchant_price = 0;
				
					
				}
				
				
				$orderDetailComments = App\OrderDetailComment::where('order_detail_id','=',$orderDetail->id)
						->orderBy('id','DESC')
						//->first()
						->get()
						;

					//$orderDetailComment = $orderDetail->orderDetailComments->last();
					
					if($orderDetailComments == null){

						$orderDetailComments['qc_comment'] = '';
						$orderDetailComments['comment_status'] = '';

						$orderDetailComments = (Object) $orderDetailComments;
					}

				$issue_request_count = App\OrderDetailComment::where('order_detail_id','=',$orderDetail->id)
					->whereIn('comment_status',array('ISSUE','REQUEST'))	
                    ->groupBy('comment_status')
                    ->count()
                    ;
				
				
				
			@endphp
			<tr id="row_{{ $orderDetail->id }}" >
			<input name="edit_order_detail_id[]" type="hidden" class="form-control" value ="{{ $orderDetail->id }}" readonly="true" />
				<td>
					
					<input class="product_id" name="edit_product_id[]" type="hidden" class="form-control" value="{{ $orderDetail->product_id }}">
					
					<input class="product_name" name="edit_product_name[]" type="hidden" class="form-control" value="{{ $orderDetail->product_name }}">
				
				</td>
				<td>
					
					<select onchange="getAttributePrice(this)" class="select2 form-control attribute_id" name="edit_attribute_id[]"  >

						<option>Choose Attribute</option>
					@foreach($attributes as $attribute)
						@if($orderDetail->attribute_id == $attribute->id)
							{{ $attribute_val = $attribute->attribute_name.' '.$attribute->uom }}
						@endif
						<option value="{{ $attribute->id}}" {{ ($orderDetail->attribute_id== $attribute->id)?'selected="true"':''}}">{{ $attribute->attribute_name.' '.$attribute->uom }}</option>
					@endforeach
					</select>	
					
					<input class="attribute_name" name="edit_attribute_name[]" type="hidden" class="form-control" value="{{ $attribute_val }}">

				</td>

				<td>
					<input onkeyup="edit_qty_change(this)" name=edit_qty[] type="text" class="form-control" value ="{{$orderDetail->qty}}" tabindex="{{ ++$i }}" />
				</td>
				<td >
										

					<label style="display:none;position:relative;width: 90%" onclick="edit_qty_change(this)" class="base_price col-md-14" >
					<input style="float:left;" {{ ($orderDetail->price_type=='PRICE')?'checked':''}} id="PRICE" type="radio" name="edit_price[111{{$orderDetail->id}}]"  value="{{ $allPrice->price }}" > 
					<span >VP </span>

					<input style="width: 40%;" class="base_price" type="text" value=" {{ $allPrice->price }} "  disabled/>
					</label>

<!--					
					<label style="display: none; position:relative;" onclick="edit_qty_change(this)" class="sell_price col-md-14" >
					<input {{ ($orderDetail->price_type=='SELL_PRICE')?'checked':''}} id="SELL_PRICE"  type="radio" name="edit_price[111{{$orderDetail->id}}]" value="{{ $allPrice->sell_price }}"> <span class="sell_price">{{ $allPrice->sell_price }} Sell </span>
					</label>
-->

					<label style="display:none;position:relative;width: 90%" onclick="edit_qty_change(this)" class="specific_price col-md-14" >
					<input  {{ ($orderDetail->price_type=='SPECIFIC_PRICE')?'checked':''}} id="SPECIFIC_PRICE"  type="radio" name="edit_price[111{{$orderDetail->id}}]" value="{{ $allPrice->specific_price }}"> 
					<span > FP </span>
					<input style="width: 40%;" class="specific_price" type="text" value="{{ $allPrice->specific_price }}"  disabled/>
					</label>

					

					<label style="position:relative;width: 90%" onclick="edit_qty_change(this)" class="merchant_price" >

					<input  {{ ($orderDetail->price_type=='CUSTOM_PRICE')?'checked':''}} id="CUSTOM_PRICE" type="radio" name="edit_price[111{{$orderDetail->id}}]" value="{{  $orderDetail->actual_mrp or 0.00 }} " />

					<span   class="merchant_price"> CP </span>

					<input style="width: 40%;"  class="custom_merchant_price " onkeyup="edit_custom_merchant_action(this)"  type="text" value="{{  $orderDetail->actual_mrp or 0.00 }}"  />

					</label>

					<a style="position: absolute;" onclick="price_toggle(this)" class=" ">
							<i class="fa fa-pencil"></i> <span style="display:none">Show</span> 
					</a>

					<input type="hidden" name=edit_price_type[] value="{{ $orderDetail->price_type }}" />

				</td>

				<td>
					<input name=edit_product_total[] type="text" class="form-control" value ="{{ $orderDetail->product_total }}"  readonly="true" />
				</td>
<!--
				<td>
					<input  name=order_detail_comment[] type="text" class="form-control" value ="{{ $orderDetail->comment or '' }}" />
				</td>
-->				
				<td>
					<a class="btn" href="#form_modal_{{$orderDetail->id}}" data-toggle="modal">
						
						@if($issue_request_count > 0)
						<span class="badge badge-danger pull-left"> {{ $issue_request_count }}</span> &nbsp;&nbsp;
						@endif
						&nbsp;View 
					</a>
				</td>

				<td>
					<a href="javascript:delete_row('row_{{$orderDetail->id}}');" class="btn default btn-sm">
					<i class="fa fa-times"></i> Delete 

					<input id="delete_order_detail" name="delete_order_detail[]"" type="hidden" class="form-control" value ="False" readonly="true" />
				</a>
				</td>
				
				<div id="form_modal_{{$orderDetail->id}}" class="modal fade" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Qc Comments</h4>
							</div>
							<div class="modal-body">
								@foreach($orderDetailComments as $orderDetailComment)
								<div id="edit_row_{{ $orderDetailComment->id }}">
									<input type="hidden" name="edit_order_detail_comment_id[{{$orderDetail->id}}][]" value="{{ $orderDetailComment->id }}" /> 
									<div class="form-group">
										<label class="control-label col-md-3">Qc Comment</label>
										<div class="col-md-5">
											<input  name="edit_order_detail_qc_comment[{{$orderDetail->id}}][]" type="textarea" col="2" class="form-control" value ="{{ $orderDetailComment->qc_comment or '' }}" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">Comment Status</label>
										<div class="col-md-5">
											<select name="edit_order_detail_qc_comment_status[{{$orderDetail->id}}][]" class="form-control">
												<option value="ISSUE" >Choose Status </option>
												<option value="ISSUE" {{ ($orderDetailComment->comment_status == 'ISSUE')?'selected':'' }}> Issue </option>
												<option value="ISSUE_SOLVED" {{ ($orderDetailComment->comment_status == 'ISSUE_SOLVED')?'selected':'' }}> Issue Solved</option>
												<option value="REQUEST" {{ ($orderDetailComment->comment_status == 'REQUEST')?'selected':'' }}> Request </option>
												<option value="REQUEST_COMPLETED" {{ ($orderDetailComment->comment_status == 'REQUEST_COMPLETED')?'selected':'' }}> Request Done </option>
											</select>
										</div>
									</div>

									<input id="delete_order_detail_comment" name="delete_order_detail_comment[{{ $orderDetail->id }}][]" type="hidden" class="form-control" value ="False" readonly="true" />

									<hr/>
								</div>
								@endforeach	
							
								
							</div>
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
								<button class="btn green btn-primary" data-dismiss="modal">Save changes</button>

							</div>
						</div>
					</div>
				</div>


			</tr>
			@php
			 
				
			
			@endphp
			@endforeach
			</tbody>
			</table>

			<a class="btn yellow"  onclick="add_row()" data-toggle="modal">
											Add More<i class="fa fa-share"></i>
											</a>
				<a id="attribute_loader"   >
											
					</a>
		</div>

		<div class="row">
			<div class="col-md-6">

				<div class="form-group">
					<label class="control-label col-md-3">Remark </label>
					<div class="col-md-9">
   						<textarea id="remark" name="remark" class="form-control" rows="2" >{{ $order->remark or '' }} </textarea>			
						<span class="help-block">
						 </span>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Comment </label>
					<div class="col-md-9">
   						<textarea id="order_comment" name="order_comment" class="form-control" rows="2" >{{ $order->comment or '' }} </textarea>			
						<span class="help-block">
						 </span>
					</div>
				</div>

			</div>

			<div class="col-md-6">
				<div class="well">
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							 Sub Total:
						</div>
						<div class="col-md-3 value">
							 
							 <input class="form-control" type="text" id="sub_total" name="sub_total" value="{{ $order->sub_total }}" readonly="true" />
							 
						</div>


					</div>
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							 Delivery Charge:
						</div>
						<div class="col-md-3 value">
							<input class="form-control" type="text" id="delivery_charge" name="delivery_charge" value="{{ $order->delivery_charge }}" readonly="true" />
						</div>
					</div>
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							 Grand Total:
						</div>
						<div class="col-md-3 value">
							<input class="form-control" type="text" id="grand_total" name="grand_total" value="{{ $order->order_total }}" readonly="true" />
						</div>
					</div>
					
				</div>
			</div>
		</div>




	</div>
	<div class="form-actions">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						{!! Form::submit('Submit', ['class' => 'btn green']) !!}
					</div>
				</div>
			</div>
			<div class="col-md-6">
			</div>
		</div>
	</div>