	<input type="hidden" name="updated_by" id="updated_by"  class="form-control" value="{{ Auth::id()}}" />
	<input type="hidden" name="status" id="status"  class="form-control" value="1" />

	<div class="form-body">
		<h3 class="form-section">Locality Info</h3>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Locality Name</label>
					<div class="col-md-9">
						
						<select name="state_id" id="state_id" class="select2_category form-control">
							@if($states !== null)
							@foreach($states as $state)
							<option value="{{ $state->id }}" {{ ($locality->city->state_id == $state->id  )?'selected':'' }}>
							{{ $state->state_name }}

							</option>
							@endforeach
							@endif
						</select>

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			<!--/span-->
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">City Name</label>
					<div class="col-md-9">
						
						<select name="city_id" id="city_id" class="select2_category form-control">
							@if($cities !== null)
							@foreach($cities as $city)
							<option value="{{ $city->id }}" {{ ($locality->city_id == $city->id  )?'selected':'' }} >{{ $city->city_name }}</option>
							@endforeach
							@endif
						</select>

						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>
			<!--/span-->
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Locality Name</label>
					<div class="col-md-9">

						<input type="text" name="locality_name" id="locality_name" placeholder="Locality Name" class="form-control" required="true" value="{{ $locality->locality_name}}"/>
						
						<span class="help-block">
						
						 </span>
					</div>
				</div>
			</div>
			<!--/span-->

		</div>


	
	</div>
	<div class="form-actions">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						{!! Form::submit('Update', ['class' => 'btn green']) !!}
						
					</div>
				</div>
			</div>
			<div class="col-md-6">
			</div>
		</div>
	</div>