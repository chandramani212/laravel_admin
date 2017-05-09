	<div class="form-body">
		<h3 class="form-section">Stock Info</h3>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Add Quantity</label>
					<div class="col-md-9">

						<input type="text" id="delivery_charge" name="total_qty_in_hand" value="0" Placeholder="Add Qty" class="form-control"  />

					</div>
				</div>
			</div>
			<!--/span-->
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Search Product</label>
					<div class="col-md-9">
						<div class="input-group  input-medium">

							<input id="searched_product_name" name="product_name" type="hidden" class="form-control">

							<input id="searched_product_id" name="product_id" type="hidden" >
							
						</div>

					</div>
				</div>
			</div>
			<!--/span-->
		</div>
		<!--/row-->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Attribute</label>
					<div class="col-md-9">

						<select name="attribute_id" id="searched_attribute_id" class="select2 form-control" tabindex="1" placeholder="Choose Attribute">
							<option>Choose Attribute</option>

						</select>
						
					
					</div>
				</div>
			</div>
			<!--/span-->
			
		</div>
		<!--/row-->

		<h3 class="form-section">Stock Wastage</h3>
		<div class="tab-pane" id="tab_images">
			<div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
				
				<a class="btn yellow" onclick="add_more()" >
											Add More<i class="fa fa-share"></i>
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
					 Quantity Wastage
				</th>
				<th width="25%">
					 Reason
				</th>

				</th>

				<th width="10%">
				</th>
			</tr>
			</thead>
			<tbody id="add_row">
			<tr id="first_row"> 

				<td>
					<input name="basic_qty[]" type="text" class="form-control" value =""  />
				</td>
				<td>

					<input name="reason[]" type="textarea" class="form-control" value =""  />

				</td>

				<td>
					
					<a href="javascript:remove_row('first_row');" class="btn default btn-sm remove">
					<i class="fa fa-times"></i> Remove 
					</a>

				</td>
			</tr>

			
			</tbody>
			</table>
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