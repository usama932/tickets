<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Markhor Millionaire</title>
	<!-- Css link -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	 <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
</head>
<body>
<div class="container-fluid content">
	<!-- begin::header -->
	<div class="header text-center">
		<!-- being::nav menu -->
		<br><br>
		<div class="nav_menu">
			<nav class="navbar rounded-4 navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
   <a class="navbar-brand" href="#">
      <img src="assets/media/logo_f.png" alt="Bootstrap" width="30" height="24">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/about">About us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/sub">Subscriptions</a>
        </li>
        
       
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control nav-search-put" type="search" placeholder="Search" aria-label="Search">
        <button class="btn nav-search-btn" type="submit">&nbsp&nbsp<i class="fa-solid fa-magnifying-glass"></i>&nbsp&nbsp</button>
      </form>
      <div class="left-side"> <i class="fa-solid fa-cart-shopping"><span class="fs-10">01</span> </i>
      	<a href="/dashboard">  <img class="user-account" src="assets/media/user.png"></a>
    </div>
  </div>
</nav>
		</div>
		<!-- end:nav menu -->
		<br>
		<!-- being::slider -->
		<div class="row align-items-center">
			<div class="col-6">
				<div class="slider-content">
           <h1><span class="cyen normal">Come Earn</span><br>
    <span class="mewron"> Get financial freedom </span><br>
 <span class="orange">&</span> rule the world <span class="orange">!</span></h1>
 <p class="slider-content-des"> Becoming a leader with Markhor will give you , Online earning, profits, Monthly non working, and can make you a brand in itself! </p>
 <a class="primary-btn" href="/signup">Register Now</a>
       </div>
			</div>
			<div class="col-6 ">
				<div class="slider-thumail">
					<img src="assets/media/earn.png">
				</div>
			</div>
		</div>
		<!-- end::slider -->
	</div>
	<!-- end::header -->
</div>

<br>
<div class="row">
  <div class="col-12">
    <!-- begin::title -->
       <div class="title">
           <h2 class="upcase"></h2>
           <div class="title-bar-light"></div>
           <div class="title-bar-dark"></div>
           
       </div>
       <!-- end::title -->
       @if(session('success'))
                          <div class="alert alert-success">{{ session('success') }}</div>
                @endif
  </div>
</div>
<!-- about content -->
<div class="packges">
  <div class="row">
  @foreach($all_packages as $all_package)
    <div class="col-6">
      <div class="packge">
       
      <a href="activate/{{$all_package->id}}"><img src="assets/media/{{$all_package->description}}"></a> 
    </div>
  </div>
      @endforeach
    


    </div>
  </div>
</div>

<!-- begin::footer -->
<div class="footer">
  <div class="row align-items-center footer-row">
    <div class="col-3">
      <img class="footer-logo" src="assets/media/logo_f.png">
    </div>
    <div class="col-3">
      <h4> About us</h4>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
    </div>
    <div class="col-3">
      <h4> HELP</h4>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
    </div>
    <div class="col-3">
     <h4> Social</h4>
            <ul>
                <li><a href="https://www.facebook.com/cataclymisation">Facebook</a></li>
                <li><a href="https://twitter.com/Markhormillion">Twitter</a></li>
                <li><a href="https://instagram.com/markhormillionaire">Instagram</a></li>
                 <li><a href="https://t.me/markhormillionaire">Telegram</a></li>
            </ul>
    </div>

  </div>
</div>
<!-- end::footer -->
	
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/28beddf917.js" crossorigin="anonymous"></script>
</body>
</html>