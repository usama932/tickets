<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Markhor Millionaire</title>
    <!-- Css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" 
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
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
                <h2 class="upcase">Investment Option</h2>
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
    <section id="pricing" class="pricing-content section-padding">
        <div class="container">
            <div class="section-title text-center">
                {{-- <h2>Subscriptions Plans</h2> --}}
            </div>
            <div class="row text-center mb-5">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="card">
                        <h5 class="card-header">Starter</h5>
                        <div class="card-body">
                            <h5 class="card-title">Invest Rs:25000</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <form method="POST" action="{{ route('activateSubscription') }}">
                                @csrf
                                <input type="hidden" name="price" value="25000">
                                <input type="hidden" name="status" value="5">
                                <button type="submit" class="price_btn btn btn-primary">Activate</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="card">
                        <h5 class="card-header">Silver</h5>
                        <div class="card-body">
                            <h5 class="card-title">Invest Rs:50000</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <form method="POST" action="{{ route('activateSubscription') }}">
                                @csrf
                                <input type="hidden" name="price" value="50000">
                                <input type="hidden" name="status" value="5">
                                <button type="submit" class="price_btn btn btn-primary">Activate</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="card">
                        <h5 class="card-header">Gold</h5>
                        <div class="card-body">
                            <h5 class="card-title">Invest Rs:75000</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <form method="POST" action="{{ route('activateSubscription') }}">
                                @csrf
                                <input type="hidden" name="price" value="75000">
                                <input type="hidden" name="status" value="5">
                                <button type="submit" class="price_btn btn btn-primary">Activate</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="card">
                        <h5 class="card-header">Premium</h5>
                        <div class="card-body">
                            <h5 class="card-title">Invest Rs:100000</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <form method="POST" action="{{ route('activateSubscription') }}">
                                @csrf
                                <input type="hidden" name="price" value="100000">
                                <input type="hidden" name="status" value="5">
                                <button type="submit" class="price_btn btn btn-primary">Activate</button>
                            </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
            crossorigin="anonymous"></script>
</body>
</html>
