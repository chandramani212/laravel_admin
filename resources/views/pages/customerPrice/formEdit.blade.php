	<div class="form-body">
		<h3 class="form-section">Customer Info</h3>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Customer </label>
					<div class="col-md-9">
   						
   						<select id="customer_select" name="customer_id" class="select2_category form-control" tabindex="1">
   							<opton>Choose Customer</opton>
   							@foreach($customers as $customer)
   							<option value="{{ $customer->id }}" {{($customer->id == $customerPrice->customer_id)?'selected':''}}> 
   							{{ $customer->first_name .''.$customer->last_name}}
   							</option>
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
   						
   						<select id="address_id" name="address_id" class="select2_category form-control" tabindex="1">
   							<opton>Choose Addresss</opton>
   							@foreach($address as $addres)
   							<option value="{{ $addres->id }}" {{($addres->id == $customerPrice->address_id)?'selected':''}}> 
   							{{ $addres->address_line1 .''.$addres->address_line2}}
   							</option>
   							@endforeach
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
						<div class="input-group" id="defaultrange" >
							<input name="date_range" type="text" class="form-control" value="{{ $customerPrice->start_date.' / '. $customerPrice->end_date }}" required>
							<span class="input-group-btn">
							<button class="btn default date-range-toggle" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
					</div>
				</div>

			</div>

		</div>


		<h3 class="form-section">Edit Product and it's specific price</h3>
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
			@foreach($custPriceDetails as $custPriceDetail )

				@php
					$attributes = App\product_attribute::where('product_id','=',$custPriceDetail->product_id)->get();
				
				@endphp
			
			<tr id="row_{{ $custPriceDetail->id }}" >
			<input name="edit_customer_price_detail_id[]" type="hidden" class="form-control" value ="{{ $custPriceDetail->id }}" readonly="true" />
				<td>
					
					<input class="product_id" name="edit_product_id[{{ $custPriceDetail->id }}]" type="hidden" class="form-control" value="{{ $custPriceDetail->product_id }}">
					
					<input class="product_name" name="edit_product_name[]" type="hidden" class="form-control" value="{{ $custPriceDetail->product->product_name or ''}}">
				
				</td>
				<td>
					
					<select onchange="getAttributePrice(this)" class="select2 form-control attribute_id" name="edit_attribute_id[{{ $custPriceDetail->id }}]"  >

						<option>Choose Attribute</option>
					@foreach($attributes as $attribute)
						@if($custPriceDetail->attribute_id == $attribute->id)
							{{ $attribute_val = $attribute->attribute_name.' '.$attribute->uom }}
						@endif
						<option value="{{ $attribute->id}}" {{ ($custPriceDetail->attribute_id== $attribute->id)?'selected="true"':''}}">{{ $attribute->attribute_name.' '.$attribute->uom }}</option>
					@endforeach
					</select>	
					
					<input class="attribute_name" name="edit_attribute_name[{{ $custPriceDetail->id }}]" type="hidden" class="form-control" value="{{ $attribute_val }}">

				</td>

				

				<td class="base_price">
					<input name="edit_base_price[{{ $custPriceDetail->id }}]"" type="text" class="form-control base_price" value ="{{ $custPriceDetail->attribute->price->price or '' }}"   disabled />
				</td>
				<td>
					<input name="edit_price[{{ $custPriceDetail->id }}]" type="text" class="form-control" value ="{{ $custPriceDetail->price }}"   />
				</td>
				<td >

					<select class="select2 form-control" name="edit_default_selected_price[{{ $custPriceDetail->id }}]" tabindex="1" required="true">

					<option value="">Choose Default</option>
					<option value="FIXED_PRICE" {{($custPriceDetail->default_selected_price =='FIXED_PRICE')?'selected':''}} >Fixed Price</option>
					<option value="CUSTOM_PRICE" {{($custPriceDetail->default_selected_price =='CUSTOM_PRICE')?'selected':''}} >Custom Price</option>

					</select>

					<input class="attribute_name" name="attribute_name[{{ $custPriceDetail->id }}]" type="hidden" class="form-control" value="">

				</td>
			

				<td>
					<a href="javascript:delete_row('row_{{$custPriceDetail->id}}');" class="btn default btn-sm">
					<i class="fa fa-times"></i> Delete 

					<input id="delete_customer_price_detail" name="delete_customer_price_detail[]" type="hidden" class="form-control" value ="False" readonly="true" />
				</a>
				</td>
				


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