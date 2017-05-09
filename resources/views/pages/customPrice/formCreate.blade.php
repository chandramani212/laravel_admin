	<div class="form-body">
		<h3 class="form-section">Price List Details</h3>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Description </label>
					<div class="col-md-9">
   							
   						<textarea class="form-control" id="description" name="description" placeholder="Add Description here"></textarea>	

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			

		</div>

		<h3 class="form-section">Customer Info</h3>
		<div id="customer_div"> 
		<div class="row">
			
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Customer </label>
					<div class="col-md-9">
   
   						<select onclick="select_address(this)" name="customer_id[]" id="customer_select" class="form-control customer_select">		
   							@foreach($customerOption as $key => $value)
   								<option value="{{ $key }}"> {{ $value}} </option>
   							@endforeach
   						</select>		

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Address</label>
					<div class="col-md-9" id="customer_address">
   						<select name="address_id[]" id="address_id" class="form-control" required>		
   							
   						</select>	

						<span class="help-block">
						</span>

					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Date Range</label>
					<div class="col-md-9">
						<!--<div class="input-group date form_meridian_datetime input-large" data-date=""> -->
						<div class="input-group defaultrange" id="defaultrange" >
							<input name="date_range[]" type="text" class="form-control" value="{{ date('Y-m-d').' / '. date('Y-m-d', strtotime('29 days')) }}" required>
							<span class="input-group-btn">
							<button class="btn default date-range-toggle" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
					</div>
				</div>

			</div>

		</div>
		</div>

		<!-- Add More customer -->
		<div id="customer_div_append">

		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">&nbsp;</label>
					<div class="col-md-9 action">
						<a href="javascript:add_customer();" class="btn btn-default btn-sm">Add More Customer</a>
					</div>
				</div>
			</div>
		</div>




		<h3 class="form-section">Add Product and choose specific price</h3>
		<div class="tab-pane" id="tab_images">
			<div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
				<a id="loader"   >
											
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
				<th width="10%">
					 Product Attribute
				</th>

				<th width="10%">
					 Variable Price
				</th>
				<th width="10%">
					 Price
				</th>
				<th width="10%">
					 Default Price
				</th>

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