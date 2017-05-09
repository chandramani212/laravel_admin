	<div class="form-body">
		<h3 class="form-section">Customer Info</h3>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Customer </label>
					<div class="col-md-9">
   						{!! Form::select('customer_id', $customerOption, 'S', array('Placeholder' => 'choose User' ,'id' => 'customer_select' ,'class' => 'select2_category form-control', 'required'=> 'true')) !!}					
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Address</label>
					<div class="col-md-9" id="customer_address">
   						<select name="address_id" id="address_id" class="form-control" required>		
   							
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
						
							<input type="text" name="created_at"  class="form-control" value="{{ $order_date }}">
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
   						<input type="number" class="form-control" name="pi_no" id="pi_no" value="" />
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
				<a class="btn yellow"  onclick="get_default_order()" data-toggle="modal">
											Get Default orders<i class="fa fa-share"></i>
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
				<th width="5%">
					 Product Attribute
				</th>

				<th width="5%">
					 Quantity
				</th>
				<th width="10%">
					 Base Price
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
				</th>
			</tr>
			</thead>
			<tbody id="add_product_row">

			

			</tbody>
			</table>
			<a class="btn yellow"  onclick="add_row()" data-toggle="modal">
											Add More<i class="fa fa-share"></i>
											</a>
			<a id="attribute_loader"> </a>
		</div>

		<div class="row">
			<div class="col-md-6">

				<div class="form-group">
					<label class="control-label col-md-3">Remark </label>
					<div class="col-md-9">
   						<textarea id="remark" name="remark" class="form-control" rows="2"></textarea>				
						<span class="help-block">
						 </span>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Comment </label>
					<div class="col-md-9">
   						<textarea id="order_comment" name="order_comment" class="form-control" rows="2"></textarea>				
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
							 
							 <input class="form-control" type="text" id="sub_total" name="sub_total"  readonly="true" />
							 
						</div>


					</div>
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							 Delivery Charge:
						</div>
						<div class="col-md-3 value">
							<input class="form-control" type="text" id="delivery_charge" name="delivery_charge" value="0.00" readonly="true" />
						</div>
					</div>
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							 Grand Total:
						</div>
						<div class="col-md-3 value">
							<input class="form-control" type="text" id="grand_total" name="grand_total"  readonly="true" />
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