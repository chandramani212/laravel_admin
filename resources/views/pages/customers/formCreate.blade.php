	<div class="form-body">
		<h3 class="form-section">Customer Info</h3>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">First Name</label>
					<div class="col-md-9">
						
						{!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control','required' => 'true')) !!}
						<span class="help-block">
						
						 </span>

					</div>
				</div>
			</div>
			<!--/span-->
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Last Name</label>
					<div class="col-md-9">
						{!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control','required' => 'true')) !!}
						<span class="help-block">
						
						 </span>
					</div>
				</div>
			</div>
			<!--/span-->
		</div>
		<!--/row-->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Email</label>
					<div class="col-md-9">
						<div class="input-group">
							<span class="input-group-addon">
							<i class="fa fa-envelope"></i>
							</span>
							{!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
						</div>
						
					
					</div>
				</div>
			</div>
			<!--/span-->
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Delivery Prefer Time</label>
					<div class="col-md-9">
						
						<div class="input-group">
							<input type="text" name="delivery_prefer_time" class="form-control timepicker timepicker-24" placeholder="Delivery Prefer Time">
							<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
							</span>
						</div>

						<span class="help-block">
						</span>
					</div>
				</div>
			</div>
			<!--/span-->
		</div>
		<!--/row-->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Contact No</label>
					<div class="col-md-9">
						{!! Form::number('contact_no', null, array('placeholder' => 'Contact No','class' => 'form-control', 'pattern'=>'^[1-9][0-9]{0,9}$' ,'min' => '1111111111','max' => '9999999999')) !!}
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			<!--/span-->
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Alternate No</label>
					<div class="col-md-9">
						{!! Form::number('alternate_no', null, array('placeholder' => 'Alternate No','class' => 'form-control' ,'min' => '1111111111', 'max' => '9999999999')) !!}
						<span class="help-block">
						</span>
					</div>
				</div>
			</div>
			<!--/span-->
		</div>
		<!--/row-->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Join Date</label>
					<div class="col-md-9">
												
						<div class="input-group date form_meridian_datetime input-large" data-date="">
							<input type="text" name="join_date"  class="form-control" value="{{date('Y-m-d H:i')}}">
							<span class="input-group-btn">
							<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
							<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Introduce By</label>
					<div class="col-md-9">
   						{!! Form::select('introduce_by', $userOption, 'S', array('Placeholder' => 'choose User' ,'class' => 'select2_category form-control', 'tabindex'=> '1')) !!}					
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Manage By</label>
					<div class="col-md-9">
					
						{!! Form::select('manage_by', $userOption, 'S', array('data-placeholder' => 'choose User' ,'class' => 'select2_category form-control', 'tabindex'=> '1')) !!}
				
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Comment</label>
					<div class="col-md-9">
					
						
						<textarea class="form-control" name="comment" rows="2"> </textarea> 
				
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			
		</div>
		
		
		<!--/row-->
		<h3 class="form-section">Other Contact Detials</h3>
		<div id="other_contact_details">


		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Contact Person First Name</label>
					<div class="col-md-9">
					
						<input type="text" name="other_contact_first_name[]" class="form-control" placeholder="First Name">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Contact Person Last Name</label>
					<div class="col-md-9">
						<input type="text" name="other_contact_last_name[]" class="form-control" placeholder="Last Name">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Choose Default</label>
					<div class="col-md-9">
					
						<select name="default_contact[]" class="form-control">
						<option  > Choose Default </option>
						<option value="YES" > Yes </option>
						<option value="NO" > No </option>
						</select>

					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Contact Number</label>
					<div class="col-md-9">
						<input type="text" name="other_contact_no[]" class="form-control" placeholder="Contact Name">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Alternate Number</label>
					<div class="col-md-9">
					
						<input type="text" name="other_alternate_no[]" class="form-control" placeholder="Contact Name">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Email</label>
					<div class="col-md-9">
						<input type="text" name="other_email[]" class="form-control" placeholder="Contact Name">
					</div>
				</div>
			</div>
		</div>


		</div>

		<div id="dynamic_add_other_contact_details">
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">&nbsp;</label>
					<div class="col-md-9 action">
						<a href="javascript:add_other_contact_details();" class="btn btn-default btn-sm">Add More Contact Details</a>
					</div>
				</div>
			</div>
		</div>
		
		<h3 class="form-section">Address</h3>

		<div id="address_div">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Address 1</label>
					<div class="col-md-9">
						{!! Form::text('address_line1[]', null, array('placeholder' => 'Address Line 1 ','class' => 'form-control')) !!}
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Address 2</label>
					<div class="col-md-9">
						{!! Form::text('address_line2[]', null, array('placeholder' => 'Address Line 2 ','class' => 'form-control')) !!}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Street</label>
					<div class="col-md-9">
						{!! Form::text('street[]', null, array('placeholder' => 'Street','class' => 'form-control')) !!}
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">State</label>
					<div class="col-md-9">
					
						{!! Form::select('state_id[]', $stateOption, 'S', array('data-placeholder' => 'choose User' ,'class' => 'form-control', 'tabindex'=> '1')) !!}
				
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">City</label>
					<div class="col-md-9">

						{!! Form::select('city_id[]', $cityOption, 'S', array('data-placeholder' => 'choose City' ,'class' => 'form-control', 'tabindex'=> '1')) !!}

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Locality</label>
					<div class="col-md-9">
					
						{!! Form::select('locality_id[]', $localityOption, 'S', array('data-placeholder' => 'choose User' ,'class' => 'form-control', 'tabindex'=> '1')) !!}
				
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Post Code</label>
					<div class="col-md-9">
						{!! Form::text('pin_code[]', null, array('placeholder' => 'Post Code No','class' => 'form-control')) !!}
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Choose Zone</label>
					<div class="col-md-9">
					
						{!! Form::select('zone_id[]', $zoneOption, 'S', array('data-placeholder' => 'choose Zone' ,'class' => 'form-control', 'tabindex'=> '1')) !!}
				
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Latitude</label>
					<div class="col-md-9">
						<div class="input-group">
							<span class="input-group-addon">
							<i class="fa fa-map-marker"></i>
							</span>
							<input type="text" class="form-control" name="latitude[]" placeholder="Latitude" >
						</div>
						
					
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Longitude</label>
					<div class="col-md-9">
						<div class="input-group">
							<span class="input-group-addon">
							<i class="fa fa-map-marker"></i>
							</span>
							<input type="text" class="form-control" name="longitude[]" placeholder="Longitude" >
						</div>
					
						
				
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Choose Price Type</label>
					<div class="col-md-9">
					
			
						<select name="price_type[]" class="form-control" tabindex="1" required>
							<option value="">Choose type</option>
							<option value="GENERAL">Variable Price</option>
							<option value="SPECIFIC">Fixed Price</option>
						</select>
				
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
		</div>

		</div>
		<div id="dynamic_add_address_div">
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">&nbsp;</label>
					<div class="col-md-9 action">
						<a href="javascript:add_address();" class="btn btn-default btn-sm">Add More Addresss</a>
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