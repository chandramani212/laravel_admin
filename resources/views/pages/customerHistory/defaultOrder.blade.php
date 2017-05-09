<?php $i=0; ?>
@foreach($orderDetails as $orderDetail)	
			<?php 
				$attributes = App\product_attribute::where('product_id','=',$orderDetail->product_id)->get();

				$priceControllers = new App\Http\Controllers\AttributeGeneralController;
				$allPrice = json_decode( $priceControllers->postAllprice($orderDetail->attribute_id,$customerId) );

				$attribute_val='';
				
				
			?>		
			<tr id="details_{{ $orderDetail->id }}">
				<td>
					
					<input class="product_id" name="product_id[]" type="hidden" class="form-control" value="{{ $orderDetail->product_id }}">
					
					<input class="product_name" name="product_name[]" type="hidden" class="form-control" value="{{ $orderDetail->product_name }}">
				
				</td>
				<td>
					
					<select onchange="getAttributePrice(this)" class="select2 form-control attribute_id" name="attribute_id[]"  >

						<option>Choose Attribute</option>
					@foreach($attributes as $attribute)
						@if($orderDetail->attribute_id == $attribute->id)
							{{ $attribute_val = $attribute->attribute_name.' '.$attribute->uom }}
						@endif
						<option value="{{ $attribute->id}}" {{ ($orderDetail->attribute_id== $attribute->id)?'selected="true"':''}}">{{ $attribute->attribute_name.' '.$attribute->uom }}</option>
					@endforeach
					</select>	
					
					<input class="attribute_name" name="attribute_name[]" type="hidden" class="form-control" value="{{ $attribute_val }}">

				</td>

				<td>
					<input onkeyup="qty_change(this)" name=qty[] type="text" class="form-control" value ="0" tabindex="{{ ++$i }}"  />
				</td>
				<td >

					
					
					<label style="display: none;position:relative;" onclick="qty_change(this)" class="base_price col-md-14"  >
					<input  id="PRICE" type="radio" name="price[111{{$orderDetail->id}}]" class="icheck" value="{{ $allPrice->price }}"> <span> {{ $allPrice->price }} Base price </span>
					</label>

					<label style="display: none; position:relative;"  onclick="qty_change(this)" class="sell_price col-md-14" >
					<input id="SELL_PRICE"  type="radio" name="price[111{{$orderDetail->id}}]" class="icheck" value="{{ $allPrice->sell_price }}"> <span>{{ $allPrice->sell_price }} Sell Price </span>
					</label>

					<label style="position:relative;width: 90%" onclick="qty_change(this)" class="merchant_price" >

					<input style="float:left" id="CUSTOM_PRICE" type="radio" name="price[111{{$orderDetail->id}}]" checked class="icheck" value="{{ $allPrice->merchant_price or 0.00 }}" > 
					<span style="margin-left : 5px;float:left;"> CP</span>
					<input style="margin-left : 5px;float:left; width: 40%;" class="custom_merchant_price" onkeyup="custom_merchant_action(this)" type="text" value="{{ $allPrice->merchant_price or 0.00 }}"  />

					</label>

					<a style="position: absolute;" onclick="price_toggle(this)" class=" ">
							<i class="fa fa-pencil"></i> <span style="display:none">Show</span> 
					</a>

					<input type="hidden" name=price_type[] value="" />

				</td>
				<td>
					<input name=product_total[] type="text" class="form-control" value ="0.00" readonly="true" />
				</td>
				<td>
					<input  name=order_detail_comment[] type="text" class="form-control" value ="" />
				</td>

				<td>
					<a href="javascript:remove_row('details_{{ $orderDetail->id }}');" class="btn default btn-sm">
					<i class="fa fa-times"></i> Remove </a>
				</td>

			</tr>
@endforeach