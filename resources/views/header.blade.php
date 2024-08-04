<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>Markhormillionaire</title>
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--  bootstrap link -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!--end::Global Stylesheets Bundle-->
		<style>
		    @media only screen 
  and (min-device-width: 320px) 
  and (max-device-width: 568px)
  and (-webkit-min-device-pixel-ratio: 2) {
		    .dev-ops {
    margin-left: -18px;
}
.new-bttn{
    font-size: 8px;
}
}
		</style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid">
					<!--begin::Header-->
					<div id="kt_header" style="left: 0 !important; background: #100851;" class="header align-items-stretch">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Wrapper-->
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
								<!--begin::Navbar-->
								<div class="d-flex align-items-stretch" id="kt_header_nav">
									<!--begin::Menu wrapper-->
									<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
										<!--begin::Menu-->
								<!--begin::Logo-->
									<a href="/" class="mb-12">
										<img alt="Logo" src="assets/media/logo_f.png" class="h-50px" style="margin: 0px 100px;" />
									</a>
									<!--end::Logo-->

									
										<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">


											<div class="menu-item me-lg-1">
												<a class="menu-link active py-3" href="/dashboard">
													<span class="menu-title">Dashboard</span>
												</a>
											</div>
										
										</div>

@auth
										<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">


											<div class="menu-item me-lg-1">
												<a class="menu-link" href="/">
													<span class="menu-title">Home</span>
												</a>
											</div>
										
										</div>
										@endauth
										
										<!--end::Menu-->
									

										<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
											<div class="menu-item me-lg-1">
												@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('rank') }}">
														<span class="menu-title">Rank5</span>
													</a>
												@endif
											</div>

											<div class="menu-item me-lg-1">
												<a class="menu-link py-3" href="/product">
													<span class="menu-title">Products</span>
												</a>
											</div>
											<div class="menu-item me-lg-1">
												@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('allProduct') }}">
														<span class="menu-title">Product List</span>
													</a>
												@endif
											</div>
											<div class="menu-item me-lg-1">
												@if ($user->role === 'customer')
													<a class="menu-link py-3" href="{{ route('homesubscription') }}">
														<span class="menu-title">Subscriptions</span>
													</a>
												@endif
											</div>
											
											
											
												<div class="menu-item me-lg-1">
												@if ($user->role === 'customer')
													<a class="menu-link py-3" href="{{ route('myproducts') }}">
														<span class="menu-title">My Products</span>
													</a>
												@endif
											</div>
											
											
											<div class="menu-item me-lg-1">
												@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('accepttokenrequest') }}">
														<span class="menu-title">Token Request</span>
													</a>
												@endif
												
											</div>
											<div class="menu-item me-lg-1">
												@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('loanrequestview') }}">
														<span class="menu-title">Loan Request</span>
													</a>
												@endif
												
											</div>

											

											<div class="menu-item me-lg-1">
												@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('productrequest') }}">
														<span class="menu-title">Product Request</span>
													</a>
												@endif
												
											</div>
											<div class="menu-item me-lg-1">
												@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('alluser') }}">
														<span class="menu-title">Users</span>
													</a>
												@endif
												
											</div>
										</div>
										<!--end::Menu-->
										
									</div>
									<!--end::Menu wrapper-->
								</div>
								<!--end::Navbar-->
								<!--begin::Topbar-->
								<div class="d-flex align-items-stretch flex-shrink-0">
									<!--begin::Toolbar wrapper-->
									<div class="d-flex align-items-stretch flex-shrink-0">
										
										<!--begin::User-->
										<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
											<!--begin::Menu wrapper-->
											<div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
												<img src="assets/media/user.png" alt="metronic" />
											</div>
											<!--begin::Menu-->
											<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
												<!--begin::Menu item-->
												<div class="menu-item px-3">
													<div class="menu-content d-flex align-items-center px-3">
														<!--begin::Avatar-->
														<div class="symbol symbol-50px me-5">
															<img alt="Logo" src="assets/media/user.png" />
														</div>
														<!--end::Avatar-->
														<!--begin::Username-->
														<div class="d-flex flex-column">
															<div class="fw-bolder d-flex align-items-center fs-5">{{ $user->name }}
															<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span></div>
															
														</div>
														<!--end::Username-->
													</div>
												</div>
												<!--end::Menu item-->
												<!--begin::Menu separator-->
												<div class="separator my-2"></div>
												<!--end::Menu separator-->
												<!--begin::Menu item-->
												<div class="menu-item px-5">
													<a href="#" class="menu-link px-5">My Profile</a>
												</div>

												<div class="menu-item px-5">
													@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('allProduct') }}">
														<span class="menu-title">Product List</span>
													</a>
												@endif
												</div>
												<div class="menu-item px-5">
													@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('accepttokenrequest') }}">
														<span class="menu-title">Token Request</span>
													</a>
												
												@endif
												</div>
												<div class="menu-item px-5">
													@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('loanrequestview') }}">
														<span class="menu-title">Loan Request</span>
													</a>
												@endif
												</div>
												<div class="menu-item px-5">
													@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('productrequest') }}">
														<span class="menu-title">Product Request</span>
													</a>
												@endif
												</div>
												<div class="menu-item px-5">
													@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('alluser') }}">
														<span class="menu-title">Users</span>
													</a>
												@endif
												</div>
												<div class="menu-item px-5">
													@if ($user->role === '1')
													<a class="menu-link py-3" href="{{ route('rank') }}">
														<span class="menu-title">Rank5</span>
													</a>
												@endif
												</div>

												<div class="menu-item px-5">
												<a class="menu-link" href="/dashboard">
													<span class="menu-title">Dashboard</span>
												</a>
												</div>
												<!--end::Menu item-->
												<!--begin::Menu item-->
												<div class="menu-item px-5">
													<a class="menu-link py-3" href="/product">
														<span class="menu-title">Products</span>
													</a>
												</div>
												<!--end::Menu item-->
												<!--begin::Menu item-->
												<div class="menu-item px-5">
													<a class="menu-link py-3" href="/">
														<span class="menu-title">Home</span>
													</a>
												
													<!--begin::Menu sub-->
													<div class="menu-sub menu-sub-dropdown w-175px py-4">
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															
														</div>
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a href="" class="menu-link px-5"></a>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a href="" class="menu-link px-5"></a>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu item-->
														
														<!--end::Menu item-->
														<!--begin::Menu separator-->
													
														<!--end::Menu separator-->
														<!--begin::Menu item-->
														
														<!--end::Menu item-->
													</div>
													<!--end::Menu sub-->
												</div>
												<!--end::Menu item-->
												<!--begin::Menu item-->
												<div class="menu-item px-5">
													@if ($user->role === 'customer')
													<a class="menu-link py-3" href="{{ route('subscriptions') }}">
														<span class="menu-title">Subscriptions</span>
													</a>
												@endif
												</div>
												<!--end::Menu item-->
												<!--begin::Menu separator-->
								
												<!--end::Menu item-->
												<!--begin::Menu item-->
												<div class="menu-item px-5 my-1">
													<a href="../../demo1/dist/account/settings.html" class="menu-link px-5">Account Settings</a>
												</div>
												<!--end::Menu item-->
												<!--begin::Menu item-->
												<div class="menu-item px-5">
													<a href="/signout" class="menu-link px-5">Sign Out</a>
												</div>
												<!--end::Menu item-->
												<!--begin::Menu separator-->
												<div class="separator my-2"></div>
												<!--end::Menu separator-->
												<!--begin::Menu item-->
												<div class="menu-item px-5">
													<div class="menu-content px-5">
														<label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success" for="kt_user_menu_dark_mode_toggle">
															<input class="form-check-input w-30px h-20px" type="checkbox" value="1" name="mode" id="kt_user_menu_dark_mode_toggle" data-kt-url="../../demo1/dist/index.html" />
															<span class="pulse-ring ms-n1"></span>
															<span class="form-check-label text-gray-600 fs-7">Dark Mode</span>
														</label>
													</div>
												</div>
												<!--end::Menu item-->
											</div>
											<!--end::Menu-->
											<!--end::Menu wrapper-->
										</div>
										<!--end::User -->
										<!--begin::Heaeder menu toggle-->
										<div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
											<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
												<!--begin::Svg Icon | path: icons/duotone/Text/Toggle-Right.svg-->
												<span class="svg-icon svg-icon-1">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path fill-rule="evenodd" clip-rule="evenodd" d="M22 11.5C22 12.3284 21.3284 13 20.5 13H3.5C2.6716 13 2 12.3284 2 11.5C2 10.6716 2.6716 10 3.5 10H20.5C21.3284 10 22 10.6716 22 11.5Z" fill="black" />
															<path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M14.5 20C15.3284 20 16 19.3284 16 18.5C16 17.6716 15.3284 17 14.5 17H3.5C2.6716 17 2 17.6716 2 18.5C2 19.3284 2.6716 20 3.5 20H14.5ZM8.5 6C9.3284 6 10 5.32843 10 4.5C10 3.67157 9.3284 3 8.5 3H3.5C2.6716 3 2 3.67157 2 4.5C2 5.32843 2.6716 6 3.5 6H8.5Z" fill="black" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</div>
										</div>
										<!--end::Heaeder menu toggle-->
									</div>
									<!--end::Toolbar wrapper-->
								</div>
								<!--end::Topbar-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->