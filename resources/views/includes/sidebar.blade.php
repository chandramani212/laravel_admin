			<ul class="page-sidebar-menu page-sidebar-menu-light" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<form class="sidebar-search " action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li class="{{ (isset($menu) && $menu=='Dashboard' )?'start active open':'' }}">
					<a href="javascript:;">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					<span class="arrow open"></span>
					</a>
					<ul class="sub-menu">
						<li  class="active">
							<a href="index.html">
							<i class="icon-bar-chart"></i>
							Default Dashboard</a>
						</li>
						<li>
							<a href="index_2.html">
							<i class="icon-bulb"></i>
							New Dashboard #1</a>
						</li>
						<li>
							<a href="index_3.html">
							<i class="icon-graph"></i>
							New Dashboard #2</a>
						</li>
					</ul>
				</li>
				<li  class="{{ (isset($menu) && $menu=='Ecommerce' )?'start active open':'' }}"> 
					<a href="javascript:;">
					<i class="icon-basket-loaded "></i>
					<span class="title">eCommerce</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="{{route('customer.index')}}">
							<i class="icon-user"></i>
							Customer</a>
						</li>
						<li>
							<a href="{{route('order.index')}}">
							<i class="icon-basket-loaded "></i>
							Orders</a>
						</li>
						<li>
							<a href="{{route('stock.index')}}">
							<i class="icon-handbag"></i>
							Stock</a>
						</li>
						<li>
							<a href="{{route('invoice.index')}}">
							<i class="icon-notebook"></i>
							Invoice</a>
						</li>
						<li>
							<a href="{{route('customerPrice.index')}}">
							<i class="icon-user"></i>
							Customer Specific Price</a>
						</li>

						<li>
							<a href="{{route('customPrice.index')}}">
							<i class="icon-user"></i>
							Custom Price</a>
						</li>

						<li>
							<a href="{{route('paymentReceipt.index')}}">
							<i class="icon-cash"></i>
							Payment Receipt</a>
						</li>
						
					
						
					</ul>
				</li>
				
				<li  class="{{ (isset($menu) && $menu=='Product' )?'start active open':'' }}"> 
					<a href="javascript:;">
					<i class="icon-basket"></i>
					<span class="title">Products</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						
					<li>
						<a href="{{route('product.index')}}">
						<i class="icon-handbag"></i>
						Product</a>
					</li>
					
					<li>
						<a href="{{route('category.index')}}">
						<i class="icon-handbag"></i>
						category</a>
					</li>
					
					<li>
						<a href="{{ route('procurement.index') }}">
						<i class="icon-handbag"></i>
						Procurement</a>
					</li>

					<li>
						<a href="{{ route('exportprocurement') }}">
						<i class="icon-handbag"></i>
						Export Procurement</a>
					</li>
						
					</ul>
				</li>

				<li  class="{{ (isset($menu) && $menu=='Place' )?'start active open':'' }}"> 
					<a href="javascript:;">
					<i class="icon-map"></i>
					<span class="title">Place</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						
					<li>
						<a href="{{route('locality.index')}}">
						<i class="icon-map"></i>
						Locality</a>
					</li>
					
					<li>
						<a href="{{route('city.index')}}">
						<i class="icon-map"></i>
						City</a>
					</li>

					<li>
						<a href="{{route('state.index')}}">
						<i class="icon-map"></i>
						Sate</a>
					</li>
					
					<li>
						<a href="{{route('zone.create')}}">
						<i class="icon-map"></i>
						Zone</a>
					</li>

					</ul>
				</li>


				<li  class="{{ (isset($menu) && $menu=='History' )?'start active open':'' }}"> 
					<a href="javascript:;">
					<i class="icon-doc"></i>
					<span class="title">History</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						
					<li>
						<a href="{{route('orderHistory.index')}}">
						<i class="icon-notebook"></i>
						Order History</a>
					</li>
					
					<li>
						<a href="{{route('customerHistory.index')}}">
						<i class="icon-notebook"></i>
						Customer History</a>
					</li>

					</ul>
				</li>

				<li  class="{{ (isset($menu) && $menu=='ExportImport' )?'start active open':'' }}"> 
					<a href="javascript:;">
					<i class="icon-share"></i>
					<span class="title">Export / Import</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						
					<li  class="{{ (isset($subMenu) && $subMenu=='CustomExport' )?'start active open':'' }}">
						<a href="javascript:;">
						<i class="icon-arrow-down"></i>
						Custom Export</a>
						<ul class="sub-menu">
							<li>
								<a href="{{route('StockSummaryIndex')}}">
								<i class="icon-arrow-down"></i>
								Stock Summary</a>
							</li>
							<li>
								<a href="{{route('OrderCustomerIndex')}}">
								<i class="icon-arrow-down"></i>
								Orders Customer</a>
							</li>
							<li>
								<a href="{{route('getOrdercustomerlocality')}}">
								<i class="icon-arrow-down"></i>
								Orders Customer Locality</a>
							</li>
							<li>
								<a href="{{route('CustomerCommentIndex')}}">
								<i class="icon-arrow-down"></i>
								Customer Comment</a>
							</li>

							<li>
								<a href="{{route('OrderReceiptSummaryIndex')}}">
								<i class="icon-arrow-down"></i>
								Order Receipt Summary</a>
							</li>

						</ul>
					</li>
					
					<li>
						<a href="{{route('CommonExportIndex')}}">
						<i class="icon-arrow-down"></i>
						Common Export</a>
					</li>
					
					

					</ul>
				</li>


				@if(Auth::user()->hasRole('admin')|| Auth::user()->hasRole('owner') )
					<li  class="{{ (isset($menu) && $menu=='Role_Management' )?'start active open':'' }}"> 
					<a href="javascript:;">
					<i class="icon-basket"></i>
					<span class="title">Role Management</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						
					<li>
						<a href="{{route('createroles')}}">
						<i class="icon-handbag"></i>
						Create Role</a>
					</li>
					
					<li>
						<a href="{{ route('permission') }}">
						<i class="icon-handbag"></i>
						Create New permission</a>
					</li>
						
					<li>
						<a href="{{ route('setpermision') }}">
						<i class="icon-handbag"></i>
						Set Permission </a>
					</li>	
					</ul>
				</li>
			@endif

			@if(Auth::id() == 1 )
					<li  class="{{ (isset($menu) && $menu=='Settings' )?'start active open':'' }}"> 
					<a href="javascript:;">
					<i class="icon-settings"></i>
					<span class="title">Settings </span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						
					<li>
						<a href="{{route('tookan.index')}}">
						<i class="icon-settings"></i>
						Tookan</a>
					</li>
					
				
					</ul>
				</li>
			@endif

			</ul>