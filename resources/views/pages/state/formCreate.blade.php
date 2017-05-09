					
	<input type="hidden" name="created_by" id="created_by"  class="form-control" value="{{ Auth::id()}}" />
	<input type="hidden" name="status" id="status"  class="form-control" value="1" />

	<div class="form-body">
		<h3 class="form-section">State Info</h3>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">State Name</label>
					<div class="col-md-9">

						<input type="text" name="state_name" id="state_name" placeholder="State Name" class="form-control" required="true" />
						<span class="help-block">
						
						 </span>

					</div>
				</div>
			</div>
			<!--/span-->

		</div>
		<!--/row-->



	</div>
	<div class="form-actions">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						
						<input type="submit" value="Submit" class="btn green" />
					</div>
				</div>
			</div>
			<div class="col-md-6">
			</div>
		</div>
	</div>