	<div class="form-body">
		<h3 class="form-section">Stock Info</h3>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Add Quantity</label>
					<div class="col-md-9">

						<input type="text" id="delivery_charge" name="total_qty_in_hand" value="{{ $stock->total_qty_in_hand }}" Placeholder="Add Qty" class="form-control"  />

						<input type="hidden" id="delivery_charge" name="actual_qty_hand" value="{{ $stock->total_qty_in_hand }}" Placeholder="Add Qty" class="form-control"  />

					</div>
				</div>
			</div>
			<!--/span-->
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Search Product</label>
					<div class="col-md-9">
						<div class="input-group  input-medium">
							
							<input id="searched_product_name" name="product_name" type="hidden" class="form-control" value="{{$stock->product_id}}">

							<input id="searched_product_id" name="product_id" type="hidden" value="{{$stock->product_id}}" >
							
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

						<input id="selected_attribute_id" name="selected_attribute_id" type="hidden" value="{{$stock->attribute_id}}" >

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
			<?php $totalWasteQty =0; ?>
			@foreach($wastages as $wastage)
			<tr id="edit_row_{{ $wastage->id }}"> 

				
				<input id="delete_stock_wastage" name="delete_stock_wastage[]"" type="hidden" class="form-control" value ="False" readonly="true" />

				<input name="edit_stock_wastage_id[]" type="hidden" class="form-control" value ="{{ $wastage->id }}" readonly="true" />

				<td>
					<input onkeyup="change_qty_in_hand()" name="edit_basic_qty[]" type="text" class="form-control" value ="{{ $wastage->basic_qty }}"  />
				</td>
				<td>
					<input name="edit_reason[]" type="textarea" class="form-control" value ="{{ $wastage->reason }}"  />
				</td>
				<td>
					
					<a href="javascript:delete_row('edit_row_{{ $wastage->id }}');" class="btn default btn-sm remove">
					<i class="fa fa-times"></i> Remove 
					</a>

				</td>
			</tr>
			<?php $totalWasteQty += $wastage->basic_qty; ?>
			@endforeach
			<input type="hidden" name="totalWasteQty" value="{{ $totalWasteQty }}" />

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