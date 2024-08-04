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


	<div class="row">
		<div class="col-12">
			<!-- begin::title -->
			<div class="title">
				<h2 class="upcase">Subscriptions</h2>
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
								<h2>Level 1</h2>
								<h1>Rs:800/lifeTime</h1>
							</div>
							<ul>
								<li>Direct profit Rs 200/-</li>
								<li>InDirect profit Rs 100/-</li>
								<li>Free token on Referral.</li>
								<li>Unlimited slots.</li>
							</ul>
							<div class="pricing-price">
								@auth
									@if(auth()->user()->subscription_status==1)
									<button class="price_btn btn btn-primary"> Already Purchased</button>
									@else
										<form method="POST" action="{{ route('activateSubscription') }}">
											@csrf
											<input type="hidden" name="price" value="3000">
											<input type="hidden" name="status" value="1">
											<button type="submit" class="price_btn btn btn-primary">Purchase</button>
										</form>
									@endif
								@endauth
							</div>
						</div>
					</div>
				</div>
				<!-- END COL -->
				{{-- <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0">
					<div class="pricing_design">
						<div class="single-pricing">
							<div class="price-head">
								<h2>Silver</h2>
								<h1 class="price">Rs:1200/lifeTime</h1>

							</div>
							<ul>
								<li>Direct profit Rs 300/-</li>
								<li>InDirect profit Rs 150/-</li>
								<li>Higher profit.</li>
								<li>Unlimited slots.</li>
							</ul>
							<div class="pricing-price">
								<form method="POST" action="{{ route('activateSubscription') }}">
									@csrf
									<input type="hidden" name="price" value="1200">
									<input type="hidden" name="status" value="2">
									<button type="submit" class="price_btn btn btn-primary">Activate</button>
								</form>
							</div>
						</div>
					</div>
				</div> --}}
				
				{{-- <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
					<div class="pricing_design">
						<div class="single-pricing">
							<div class="price-head">
								<h2>Gold</h2>
								<h1 class="price">Rs:2000/lifeTime</h1>
								
							</div>
							<ul>
								<li>Direct profit Rs 500/-</li>
								<li>InDirect profit Rs 250/-</li>
								<li>Free access to loans.</li>
								<li>Unlimited slots.</li>
							</ul>
							<div class="pricing-price">
								<form method="POST" action="{{ route('activateSubscription') }}">
									@csrf
									<input type="hidden" name="price" value="2000">
									<input type="hidden" name="status" value="3">
									<button type="submit" class="price_btn btn btn-primary">Activate</button>
								</form>
							</div>
						</div>
					</div>
				</div> --}}
				<!-- END COL -->
				<div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
					<div class="pricing_design">
						<div class="single-pricing">
							<div class="price-head">
								<h2>Level 2</h2>
								<h1 class="price">Rs:2000/lifeTime</h1>
								{{-- <span>/Monthly</span> --}}
							</div>
							<ul>
								<li>Direct profit Rs 750/-</li>
								<li>InDirect profit Rs 375/-</li>
								<li>Loans</li>
								<li>Become vendor (Access to sale goods).</li>
								<li>Unlimited slots.</li>
							</ul>
							<div class="pricing-price">
								@auth
								@if(auth()->user()->subscription_status==2)
								<button class="price_btn btn btn-primary"> Already Purchased</button>
								@else
							  <form method="POST" action="{{ route('activateSubscription') }}">
								  @csrf
								  <input type="hidden" name="price" value="2000">
								 <input type="hidden" name="status" value="2">
								  <button type="submit" class="price_btn btn btn-primary">Purchase</button>
							  </form>
							  @endif
							@endauth
							</div>
						</div>
					</div>
				</div>
				<!-- END COL -->
				<div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
					<div class="pricing_design">
						<div class="single-pricing">
							<div class="price-head">
								<h2>Millionaire</h2>
								<h1 class="price">Rs:3000/lifeTime</h1>
								{{-- <span>/Monthly</span> --}}
							</div>
							<ul>
								<li>Direct profit Rs 1250/-</li>
								<li>InDirect profit Rs 625/-</li>
								<li>Loans</li>
								<li>Vendor Account</li>
								<li>Non working monthly income</li>
							</ul>
							<div class="pricing-price">
								@auth
									@if(auth()->user()->subscription_status==4 || auth()->user()->subscription_status==5)
									<button class="price_btn btn btn-primary"> Already Purchased</button>
									@else
									<a href="{{ route('subscriptionsfiveparts') }}" class="price_btn btn btn-primary">
										Purchase
									</a>
									@endif
								@endauth
								
							</div>
						</div>
					</div>
				</div>
				<!-- END COL -->
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
