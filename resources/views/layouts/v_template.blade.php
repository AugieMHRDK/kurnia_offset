<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic - Bootstrap 5 HTML, VueJS, React, Angular & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>Kurnia Offset</title>
		<meta charset="utf-8" />
		<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="{{asset('assets')}}/media/logos/k.png" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		@stack('custom-styles')
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('assets')}}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets')}}/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">

				@if(auth()->user()->level == 1)
					@include('menu.v_menu_admin')
				@else
					@include('menu.v_menu_user')
				@endif

				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					
					<!--begin::Header-->
					@if($content != 'content.view_whatsappWeb')
						@include('layouts.v_header')
					@endif
					<!--end::Header-->

					<!--begin::Content-->
                    @include($content)
					<!--end::Content-->
					
					<!--begin::Header-->
					@if($content != 'content.view_whatsappWeb')
						@include('layouts.v_footer')
					@endif
					<!--end::Header-->
					
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		
		<!--begin::Javascript-->
		<script>var hostUrl = "{{asset('assets')}}/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{asset('assets')}}/plugins/global/plugins.bundle.js"></script>
		<script src="{{asset('assets')}}/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="{{asset('assets')}}/plugins/custom/datatables/datatables.bundle.js"></script>
		<script src="{{asset('assets')}}/js/custom.js"></script>
		<script src="https://jasonday.github.io/printThis/printThis.js"></script>
		<!--end::Page Vendors Javascript-->
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script> -->
		<script>
			function convertTZ(date, tzString) {
				return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {timeZone: tzString}));   
			}
	    	// var socket = io("{{ config('app.url_ws', 'localhost:8000') }}", { transports : ['websocket'] });
			
			function swag_logout() {
				Swal.fire({
					title: 'Ingin keluar ?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes !'
				}).then((result) => {
					if (result.isConfirmed) {
						document.getElementById('logout-form').submit();
					}
				});
			}
			
		</script>
		
		<script>
			$(".date").flatpickr({
				dateFormat: "d-m-Y",
			});
			$(".timepicker").flatpickr({
				enableTime: true,
				noCalendar: true,
				dateFormat: "H:i",
			});
		</script>
		<!--end::Global Javascript Bundle-->
        @stack('custom-scripts')
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>