	<div class="form-body">
		<h3 class="form-section">Receipt Info</h3>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Customer </label>
					<div class="col-md-9">
   						
   						<select id="customer_select" name="customer_id" class="select2_category form-control" tabindex="1">
   							<opton>Choose Customer</opton>
   							@foreach($customers as $customer)
   							<option value="{{ $customer->id }}" {{($customer->id == $paymentReceipt->customer_id)?'selected':''}}> 
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
   							<option value="{{ $addres->id }}" {{($addres->id == $paymentReceipt->address_id)?'selected':''}}> 
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
					<label class="control-label col-md-3">Payment Date </label>
					<div class="col-md-9">
						<!--<div class="input-group date form_meridian_datetime input-large" data-date=""> -->
						<div class="input-group input-medium date date-picker input-large" data-date-format="yyyy-mm-dd" >
						
							<input type="text" name="paid_at"  class="form-control" value="{{ $paymentReceipt->paid_at }}" required>
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
					<label class="control-label col-md-3">Payment</label>
					<div class="col-md-9" id="amount">
   						
   						<input type="text" placeholder="Enter Amount" name="amount" id="amount" class="form-control" value="{{ $paymentReceipt->amount }}" />	
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Mode of Payment</label>
					<div class="col-md-9" id="amount">
   						
   						<select class="form-control" name="payment_mode" id="payment_mode">
   							<option value="CASH" {{ ($paymentReceipt->payment_mode == 'CASH')?'selected':''}} >Cash</option>
   							<option value="CHEQUE" {{ ($paymentReceipt->payment_mode == 'CHEQUE')?'selected':''}} >Cheque</option>
   							<option value="NEFT" {{ ($paymentReceipt->payment_mode == 'NEFT')?'selected':''}}>NEFT</option>
   							
   						</select>
						<span class="help-block">
						 </span>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-3">Enter Cheque/NEFT No.</label>
					<div class="col-md-9" id="amount">
   						
   						<input type="text" placeholder="Enter Number" name="payment_mode_no" id="payment_mode_no" class="form-control" value="{{ $paymentReceipt->payment_mode_no }} " />	

						<span class="help-block">
						 </span>
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