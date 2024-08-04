<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../">
		<title>Create an Account | Markhormillionaire</title>
		
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		 <meta name="viewport" content="width=device-width, initial-scale=1">
		<!--end::Global Stylesheets Bundle-->
		<style>
		    .h-100px{
		        margin: 0px 100px;
		    }
		    
		    
		    @media only screen 
  and (min-device-width: 320px) 
  and (max-device-width: 568px)
  and (-webkit-min-device-pixel-ratio: 2) {
      .h-100px{
		        margin: 0 39px !important;
		    }
      
  }
  </style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-body">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-up -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/development-hd.png)">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					
					<!--begin::Wrapper-->
					<div style=" background: #100851 !important;" class="w-lg-600px bg-body  rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Logo-->
					<a href="/" class="mb-12">
						<img alt="Logo" style=" margin: 0px 170px;" src="assets/media/logo_f.png" class="h-100px" />
					</a>
					<!--end::Logo-->
								
								<div class="card-body">
						<!--begin::Form-->
						<form class="form w-100" method="post" action="{{ url('/signup') }}" >
							@csrf
							<!--begin::Heading-->
							<div class="mb-10 text-center">
								<!--begin::Title-->
								<h1 class="text-light mb-3">Create an Account</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Already have an account?
								<a href="/signin" class="link-primary fw-bolder">Sign in here</a></div>
								<!--end::Link-->
							</div>
							<!--end::Heading-->
							
							<!--begin::Separator-->
							<div class="d-flex align-items-center mb-10">
								<div class="border-bottom border-gray-300 mw-50 w-100"></div>
								<span class="fw-bold text-gray-400 fs-7 mx-2">OR</span>
								<div class="border-bottom border-gray-300 mw-50 w-100"></div>
							</div>
							<!--end::Separator-->
							<!--begin::Input group-->
							<div class="row fv-row mb-7">
								
									<label class="form-label fw-bolder text-light fs-6">Full Name</label>
									<input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="name" autocomplete="off" />
								
								<
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-7">
								<label class="form-label fw-bolder text-light fs-6">Email</label>
								<input class="form-control form-control-lg form-control-solid" type="email" placeholder="" name="email" autocomplete="off" />
								@if ($errors->has('email'))
								<div class="fv-plugins-message-container invalid-feedback"><div data-field="select2_input" data-validator="notEmpty">{{ $errors->first('email') }}</div></div>
        						
    					@endif
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-7">
								<label class="form-label fw-bolder text-light fs-6">Phone</label>
								<input class="form-control form-control-lg form-control-solid" type="phone" placeholder="" name="phone" autocomplete="off" />
								@if ($errors->has('phone'))
								<div class="fv-plugins-message-container invalid-feedback"><div data-field="select2_input" data-validator="notEmpty">{{ $errors->first('phone') }}</div></div>
        						
    					@endif
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="mb-10 fv-row" data-kt-password-meter="true">
								<!--begin::Wrapper-->
								<div class="mb-1">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-light fs-6">Password</label>
									<!--end::Label-->
									<!--begin::Input wrapper-->
									<div class="position-relative mb-3">
										<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
											<i class="bi bi-eye-slash fs-2"></i>
											<i class="bi bi-eye fs-2 d-none"></i>
										</span>
									</div>
									<!--end::Input wrapper-->
									<!--begin::Meter-->
									<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
									</div>
									<!--end::Meter-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Hint-->
								@if ($errors->has('password'))
    <div class="fv-plugins-message-container invalid-feedback">
        <div data-field="select2_input" data-validator="notEmpty">
            {{ $errors->first('password') }}
        </div>
    </div>
@else
    <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
    <!--end::Hint-->
</div>
<!--end::Input group=-->
@endif
<!--begin::Input group-->
							<div class="row fv-row mb-7">
								
									<label class="form-label fw-bolder text-light fs-6">Referral Code</label>
									<input type="text" autocomplete="off" class="form-control" name="referrer_id" placeholder="Referral Code (Optional)">
								
								<
							</div>
							<!--end::Input group-->


							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label  class="form-check form-check-custom form-check-solid form-check-inline">
									<input required class="form-check-input" type="checkbox" name="toc" value="1" />
									<span class="form-check-label fw-bold text-gray-700 fs-6">I Agree
									<a href="#" class="ms-1 link-primary">Terms and conditions</a>.</span>
								</label>
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<input type="submit" class="btn btn-lg btn-primary">
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-column-auto p-10">
					<!--begin::Links-->
					<div class="d-flex align-items-center fw-bold fs-6">
						<a href="/about" class="text-muted text-hover-primary px-2">About</a>
						<a href="/contact" class="text-muted text-hover-primary px-2">Contact</a>
						<a href="#" class="text-muted text-hover-primary px-2">Get Stard Earn</a>
					</div>
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Sign-up-->
		</div>
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{asset('assets/js/custom/authentication/sign-up/general.js')}}"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>