	<div class="form-body">
		<h3 class="form-section">Price List Details</h3>
		<input type="hidden" id="" name="custom_price_id" value="{{$customPrice->id}}">

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Description </label>
					<div class="col-md-9">
   							
   						<textarea class="form-control" id="description" name="description" placeholder="Add Description here">{{ $customPrice->description }}</textarea>	

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
		</div>

		<h3 class="form-section">Customer List</h3>

		@foreach($customerLists as $customerList)
			@php 
				$address = $customerList->customer->address;
			@endphp
		
		<input type="hidden" name="edit_custom_price_list_id[]" value="{{$customerList->id}}" class="form-control" >

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Customer </label>
					<div class="col-md-9">
   						
   						<select onclick="select_address(this)" id="customer_select" name="edit_customer_id[{{$customerList->id}}]" class="form-control" tabindex="1" required>
   							<option>Choose Customer</option>
   							@foreach($customers as $customer)
   								
   							<option value="{{ $customer->id }}" {{($customer->id == $customerList->customer_id)?'selected':''}}> 
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
   						
   						<select id="address_id" name="edit_address_id[{{$customerList->id}}]" class="form-control" tabindex="1">
   							<option>Choose Addresss</option>
   							@foreach( $address as $addres)
   							<option value="{{ $addres->id }}" {{($addres->id == $customerList->address_id)?'selected':''}}> 
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
						<div class="input-group defaultrange" id="defaultrange" >
							<input name="edit_date_range[{{$customerList->id}}]" type="text" class="form-control" value="{{ $customerList->start_date.' / '. $customerList->end_date }}" required>
							<span class="input-group-btn">
							<button class="btn default date-range-toggle" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
					</div>
				</div>

			</div>

		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">&nbsp;</label>
					<div class="col-md-3">
						{!! Form::checkbox("delete_customer_custom_id[]", null,false ,array('data-label' => 'Delete','data-checkbox' => 'icheckbox_line-red' ,'class' => 'icheck')) !!}
					</div>
				</div>
			</div>
		</div>

		<hr/>
		@endforeach

		<div id="customer_div"> 
		<div class="row">
			
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Customer </label>
					<div class="col-md-9">

   						<select onclick="select_address(this)"  id="customer_select" name="customer_id[]" class="form-control customer_select" tabindex="1" >
   							<option>Choose Customer</option>
   							@foreach($customers as $customer)
   								
   							<option value="{{ $customer->id }}"> 
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
   						<select name="address_id[]" id="address_id" class="form-control">		
   							
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

				<th width="15%">
				</th>
			</tr>
			</thead>
			<tbody id="add_product_row">
			@php  
				$i=0; 
			@endphp
			@foreach($customPriceLists as $customPriceList )

				@php
					$attributes = App\product_attribute::where('product_id','=',$customPriceList->product_id)->get();
				
				@endphp
			
			<tr id="row_{{ $customPriceList->id }}" >
			<input name="edit_customer_price_detail_id" type="hidden" class="form-control" value ="{{ $customPriceList->id }}" readonly="true" />
				<td>
					
					<input class="product_id" name="edit_product_id" type="hidden" class="form-control" value="{{ $customPriceList->product_id }}">
					
					<input class="product_name" name="edit_product_name[]" type="hidden" class="form-control" value="{{ $customPriceList->product->product_name or ''}}">
				
				</td>
				<td>
					
					<select onchange="getAttributePrice(this)" class="select2 form-control attribute_id" name="edit_attribute_id" id="edit_attribute_id"  >

						<option>Choose Attribute</option>
					@foreach($attributes as $attribute)
						@if($customPriceList->attribute_id == $attribute->id)
							{{ $attribute_val = $attribute->attribute_name.' '.$attribute->uom }}
						@endif
						<option value="{{ $attribute->id}}" {{ ($customPriceList->attribute_id== $attribute->id)?'selected="true"':''}}">{{ $attribute->attribute_name.' '.$attribute->uom }}</option>
					@endforeach
					</select>	
					
					<input class="attribute_name" name="edit_attribute_name[{{ $customPriceList->id }}]" type="hidden" class="form-control" value="{{ $attribute_val }}">

				</td>

				

				<td class="base_price">
					<input name="edit_base_price" type="text" class="form-control base_price" value ="{{ $customPriceList->attribute->price->price or '' }}"   disabled />
				</td>
				<td>
					<input name="edit_price" type="text" class="form-control" value ="{{ $customPriceList->price }}"   />
				</td>
				<td >

					<select class="select2 form-control" id="edit_default_selected_price" name="edit_default_selected_price" tabindex="1" required="true">

					<option value="">Choose Default</option>
					<option value="FIXED_PRICE" {{($customPriceList->default_selected_price =='FIXED_PRICE')?'selected':''}} >Fixed Price</option>
					<option value="CUSTOM_PRICE" {{($customPriceList->default_selected_price =='CUSTOM_PRICE')?'selected':''}} >Custom Price</option>

					</select>

					<input class="attribute_name" name="attribute_name" type="hidden" class="form-control" value="">

				</td>
			

				<td>
					<a href="javascript:save_price_list('{{$customPriceList->id}}')" class="btn btn-success btn-sm" > Save </a>

					<a href="javascript:delete_price_list('{{$customPriceList->id}}');" class="btn btn-danger btn-sm">Delete</a>

					<a id="data_loding"> </a>
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