<!--begin::Aside-->
<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
	<!--begin::Logo-->
	<div class="aside-logo flex-column-auto py-7" id="kt_aside_logo">
		<a href="{{url('/')}}">
			<img alt="Logo" src="{{asset('assets')}}/media/logos/k.png" class="h-50px" />
		</a>
	</div>
	<!--end::Logo-->
	<!--begin::Nav-->
	<div class="aside-menu flex-column-fluid pt-0 pb-7 py-lg-10" id="kt_aside_menu">
		<!--begin::Aside menu-->
		<div id="kt_aside_menu_wrapper" class="w-100 hover-scroll-overlay-y scroll-ps d-flex" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="0">
			<div id="kt_aside_menu" class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-icon-gray-400 menu-arrow-gray-400 fw-bold fs-6" data-kt-menu="true">
				<div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" class="menu-item py-3">
					<a href="{{url('home')}}">
					<span class="menu-link menu-center" title="Home" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-custom-class="tooltip-dark">
						<span class="menu-icon">
							<i class="fa fa-home" style="font-size:18pt"></i>
						</span>
					</span>
					</a>
				</div>
				<div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" class="menu-item py-3">
					<a href="{{url('tracking-status')}}">
					<span class="menu-link menu-center" title="Tracking Status" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-custom-class="tooltip-dark">
						<span class="menu-icon">
							<i class="fa fa-truck" style="font-size:18pt"></i>
						</span>
					</span>
					</a>
				</div>
			</div>
		</div>
		<!--end::Aside menu-->
	</div>
	<!--end::Nav-->
</div>
<!--end::Aside-->