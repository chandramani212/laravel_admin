	<div class="form-body">
		<h3 class="form-section">Customer Info</h3>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Customer </label>
					<div class="col-md-9">
   						{!! Form::select('customer_id', $customerOption, $order->customer_id, array('Placeholder' => 'choose User' ,'id' => 'customer_select' ,'class' => 'select2_category form-control', 'tabindex'=> '1')) !!}					
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Address</label>
					<div class="col-md-9" id="customer_address">
   						{!! Form::select('address_id',$addressOption ,  $order->address_id, array('id'=>'address_id','Placeholder' => 'choose Address' ,'class' => 'select2_category form-control', 'tabindex'=> '1')) !!}		
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

		</div>


		<h3 class="form-section">Product Info</h3>
		<div class="tab-pane" id="tab_images">
			<div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
				
				<a class="btn yellow" href="#form_modal1" data-toggle="modal">
											Add Products<i class="fa fa-share"></i>
											</a>
			</div>
			<div class="row">
				<div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12">
				</div>
			</div>
			<table class="table table-bordered table-hover">
			<thead>
			<tr role="row" class="heading">
				<th width="8%">
					 Product
				</th>
				<th width="25%">
					 Product Attribute
				</th>
				<th width="8%">
					 Quantity
				</th>
				<th width="10%">
					 Base Price
				</th>
				<th width="10%">
					 Total Price
				</th>

				<th width="10%">
				</th>
			</tr>
			</thead>
			<tbody id="add_product_row">
			@foreach($orderDetails as $orderDetail )
			<tr id="{{ 'row_'.$orderDetail->id }}"> 

				
				<input id="delete_order_detail" name="delete_order_detail[]"" type="hidden" class="form-control" value ="False" readonly="true" />

				<input name="edit_order_detail_id[]" type="hidden" class="form-control" value ="{{ $orderDetail->id }}" readonly="true" />

				<td>
					<input name="edit_product_name[]" type="text" class="form-control" value ="{{ $orderDetail->product_name }}" readonly="true" />

					<input name="edit_product_id[]" type="hidden" class="form-control" value ="{{ $orderDetail->product_id }}" readonly="true" />

				</td>
				<td>

					<input name="edit_attribute_name[]" type="text" class="form-control" value ="{{ $orderDetail->actual_attribute_name.' '.$orderDetail->actual_uom }}" readonly="true" />

					<input name="edit_attribute_id[]" type="hidden" class="form-control" value ="{{ $orderDetail->attribute_id }}" readonly="true" />

				</td>
				<td>

					<input name="edit_qty[]" type="text" class="form-control" value ="{{ $orderDetail->qty }}" readonly="true" />

				</td>
				<td>

					<input name="edit_actual_mrp[]" type="text" class="form-control" value ="{{ $orderDetail->actual_mrp }}" readonly="true" />

				</td>
				<td>

					<input name="edit_product_total[]" type="text" class="form-control" value ="{{ $orderDetail->product_total }}" readonly="true" />

				</td>

				<td>
					
				<a href="javascript:delete_row('row_{{$orderDetail->id}}');" class="btn default btn-sm">
					<i class="fa fa-times"></i> Delete 
				</a>

				</td>
			</tr>
			@endforeach
			</tbody>
			</table>
		</div>

		<div class="row">
			<div class="col-md-6">
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


	<!-- Modal Box Start Here-->
	<div id="form_modal1" class="modal fade" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Add Products</h4>
				</div>
				<div class="modal-body">
					
						<div class="form-group">
							<label class="control-label col-md-4">Search Products</label>
							<div class="col-md-8">
								<div class="input-group  input-medium">

									<input id="searched_product_name" name="searched_product_name" type="hidden" class="form-control">

									<input id="searched_product_id" name="searched_product_id" type="hidden" >
									
								</div>
								<!-- /input-group -->
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">Select Attribute</label>
							<div class="col-md-8">
								<div class="input-group  input-medium" id="searched_attribute">

								{!! Form::select('searched_attribute_id', array(''=>'Choose Attribute'), 'S', array('id'=>'searched_attribute_id','Placeholder' => 'choose Attribute' ,'class' => 'select2 form-control', 'tabindex'=> '1')) !!}
									
								</div>
								<!-- /input-group -->
							</div>
						</div>


						<div class="form-group">
							<label class="control-label col-md-4">Product Price</label>
							<div class="col-md-8">
								<div class="input-group icheck-list input-medium" id="searched_attribute_price">

									<label>
									<input id="base_price" type="radio" name="price" class="icheck" value=""> <span>Base price </span>
									</label>

									<label>
									<input id="sell_price" type="radio" name="price" class="icheck" value=""> <span>Sell </span>
									</label>

									<label class="icheck-inline">
									<input id="merchant_price" type="radio" name="price" checked class="icheck" value="" > <span> Cust Price</span>
									<input id="custom_merchant_price" onkeyup="custom_merchant_action()" class="col-md-4" type="text" value="0.00" style="float:right" />
									</label>
								

								</div>
								<!-- /input-group -->
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Quantity</label>
							<div class="col-md-8">
								<div class="input-group  input-medium" id="searched_attribute">
								<input type="hidden" id="qty_in_hand" name="qty_in_hand" value="" />


								<input type="text" id="add_qty" name="add_qty" placeholder="Quantity" class="form-control" onkeyup="change_qty_in_hand()" value="1"/>


									
								</div>
								<!-- /input-group -->
							</div>
						</div>


				
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
					<button onclick="add_product_to_cart()" class="btn green btn-primary" data-dismiss="modal">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Box END Here-->