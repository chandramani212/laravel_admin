	<div class="form-body">
		<h3 class="form-section">Customer Info</h3>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Customer </label>
					<div class="col-md-9">
   						{!! Form::select('customer_id', $customerOption, 'S', array('Placeholder' => 'choose User' ,'id' => 'customer_select' ,'class' => 'select2_category form-control')) !!}					
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Address</label>
					<div class="col-md-9" id="customer_address">
   						{!! Form::select('address_id', array(''=>'Choose Address'), 'S', array('id'=>'address_id','Placeholder' => 'choose Address' ,'class' => 'select2_category form-control')) !!}		
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
						<div class="input-group" id="defaultrange" >
							<input name="date_range" type="text" class="form-control" value="{{ date('Y-m-d').' / '. date('Y-m-d', strtotime('29 days')) }}" required>
							<span class="input-group-btn">
							<button class="btn default date-range-toggle" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
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
			<?php $i=0; ?>
			@if(isset($custPriceDetails) && !empty($custPriceDetails))
			@foreach($custPriceDetails as $custPriceDetail )

				@php
					$attributes = App\product_attribute::where('product_id','=',$custPriceDetail->product_id)->get();
				
				@endphp
			
			<tr id="row_{{ $custPriceDetail->id }}" >
				<td>
					
					<input class="product_id" name="product_id[]" type="hidden" class="form-control" value="{{ $custPriceDetail->product_id }}">
					
					<input class="product_name" name="product_name[]" type="hidden" class="form-control" value="{{ $custPriceDetail->product->product_name or ''}}">
				
				</td>
				<td class="attribute_td">
					
					<select onchange="getAttributePrice(this)" class="select2 form-control attribute_id" name="attribute_id[]"  required="true">

						<option>Choose Attribute</option>
					@foreach($attributes as $attribute)
						@if($custPriceDetail->attribute_id == $attribute->id)
							{{ $attribute_val = $attribute->attribute_name.' '.$attribute->uom }}
						@endif
						<option value="{{ $attribute->id}}" {{ ($custPriceDetail->attribute_id== $attribute->id)?'selected="true"':''}}">{{ $attribute->attribute_name.' '.$attribute->uom }}</option>
					@endforeach
					</select>	
					
					<input class="attribute_name" name="attribute_name[{{ $custPriceDetail->id }}]" type="hidden" class="form-control" value="{{ $attribute_val }}">

				</td>

				

				<td class="base_price">
					<input name="base_price[]"" type="text" class="form-control base_price" value ="{{ $custPriceDetail->attribute->price->price or '' }}"   disabled />
				</td>
				<td>
					<input name="price[]" type="text" class="form-control" value ="{{ $custPriceDetail->price }}"   />
				</td>
				<td >

					<select class="select2 form-control" name="default_selected_price[]" tabindex="1" required="true">

					<option value="">Choose Default</option>
					<option value="FIXED_PRICE" {{($custPriceDetail->default_selected_price =='FIXED_PRICE')?'selected':''}} >Fixed Price</option>
					<option value="CUSTOM_PRICE" {{($custPriceDetail->default_selected_price =='CUSTOM_PRICE')?'selected':''}} >Custom Price</option>

					</select>

					<input class="attribute_name" name="attribute_name[]" type="hidden" class="form-control" value="">

				</td>
			

				<td>
					<a href="javascript:remove_row('row_{{$custPriceDetail->id}}');" class="btn default btn-sm">
					<i class="fa fa-times"></i> Remove 	
				</a>
				</td>
				
			</tr>
			@endforeach
			@endif

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