<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Markhor Millionaire</title>
	<!-- Css link -->

	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
	<!--  bootstrap link -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<!--end::Global Stylesheets Bundle-->
</head>
<body>
	@include('navbar')

	<br>
	<div class="row">
		<div class="col-12">
			<!-- begin::title -->
			<div class="title">
				<h2 class="upcase">Subscription Five</h2>
				<div class="title-bar-light"></div>
				<div class="title-bar-dark"></div>
			</div>
			<!-- end::title -->
		</div>
	</div>
	@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
	@endif

	@if(Session::has('error'))
		<div class="alert alert-danger" role="alert">
			{{ Session::get('error') }}
		</div>
	@endif
	<!-- about content -->
	<section id="pricing" class="pricing-content section-padding">
		<div class="container">
			<div class="section-title text-center">
				{{-- <h2>Subscriptions Plans</h2> --}}
			</div>
			<div class="row text-center">
				<div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0">
					<div class="pricing_design">
						<div class="single-pricing">
							<div class="price-head">
								<h2>Fixed Salary</h2>
								<h1>Require 100/Token</h1>
							</div>
							<ul>
								<li>Direct profit Rs 200/-</li>
								<li>InDirect profit Rs 100/-</li>
								<li>Free token on Referral.</li>
								<li>Unlimited slots.</li>
							</ul>
							<div class="pricing-price">
								@auth
									@if(auth()->user()->subscription_status==4)
									<button class="price_btn btn btn-primary"> Already Purchased</button>
									@else
										<form method="POST" action="{{ route('activateSubscription') }}">
											@csrf
											<input type="hidden" name="price" value="3000">
											<input type="hidden" name="status" value="4">
											<button type="submit" class="price_btn btn btn-primary">Activate</button>
										</form>
									@endif
								@endauth
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
					<div class="pricing_design">
						<div class="single-pricing">
							<div class="price-head">
								<h2>Investment Option</h2>
							</div>
							<ul>
								<li>Direct profit 10 %/-</li>
								<li>InDirect profit Rs 375/-</li>
								<li>Loans</li>
								<li>Become vendor (Access to sale goods).</li>
								<li>Unlimited slots.</li>
							</ul>
							<div class="pricing-price">
								@auth
									@if(auth()->user()->subscription_status==5 )
									<button class="price_btn btn btn-primary"> Already Purchased</button>
									@else
										<a href="{{ route('investment_option') }}" class="price_btn btn btn-primary">
										Check Option</a>
									@endif
								@endauth
							
								
							</div>
						</div>
					</div>
				</div>
			
			</div>
			<!-- END ROW -->
		</div>
		<!-- END CONTAINER -->
	</section>

	<style>
		.footer {
			position: absolute;
			bottom: 0;
			width: 100%;
			height: 60px; /* Adjust this value to set the height of the footer */
		}
	</style>

@include('footer')
</body>
</html>
