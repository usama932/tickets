<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Markhor Millionaire</title>
	<!-- Css link -->
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">-->
	 <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
	 
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
      <img src="assets/media/logo_f.png" alt="Bootstrap" width="70px" height="">
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
          <a class="nav-link" href="{{ route('homesubscription') }}">Subscriptions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/signin">Login</a>
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
  </div>
</nav>
		</div>
		<!-- end:nav menu -->
		<br>
		<!-- being::slider -->
		<div class="row align-items-center new-slide">
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
					<img src="assets/media/about_01.png">
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
           <h2 class="upcase">About US</h2>
           <div class="title-bar-light"></div>
           <div class="title-bar-dark"></div>
           
       </div>
       <!-- end::title -->
  </div>
</div>
<!-- about content -->
<div class="about">
  <div class="row">
    <div class="col-12 about-content text-center">
      <img src="assets/media/about_02.png">
      <p class="about-text">Markhore Millionaire (smc) Pvt Ltd is a registered company with FBR (federal board of Revenue) and SECP (security exchange commission of pakistan ) located at I-8 Islamabad . We are a firm provides opportunities to youngster leaders sons and daughters of nation to earn by online workings .. through various processes , marketing, skills , self buisness activities and online shopping as well .. If you are an enthusiastic leader and want to build your future with earning and own Business So come and join us , the only brand of Pakistan where you can become as brand of yourself . Good luck We are watching out for you</p>
    </div>
    <div class="col-6">
      <!-- begin::title -->
       <div class="title">
           <h2 class="upcase">CERTIFICATE OF INCORPORATION</h2>
           <div class="title-bar-light"></div>
           <div class="title-bar-dark"></div>
           
       </div>
       <!-- end::title -->
        <img class="CERTIFICATE" src="assets/media/c_01.png">
    </div>
    <div class="col-6">
      <!-- begin::title -->
       <div class="title">
           <h2 class="upcase">REGISTRATION CERTIFICATE </h2>
           <div class="title-bar-light"></div>
           <div class="title-bar-dark"></div>
           
       </div>
       <!-- end::title -->

       <img class="CERTIFICATE" src="assets/media/c_02.png">
    </div>
  </div>
</div>

<!-- begin::footer -->
 <footer class=" text-center text-lg-start text-white" style="background-color: #100851">
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row my-4">
        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

          <div class=" d-flex align-items-center justify-content-center mb-4 mx-auto" style="width: 150px; height: 150px;">
            <img src="assets/media/logo_f.png" height="70" alt=""
                 loading="lazy" />
          </div>

          <p class="text-center"></p>

          <ul class="list-unstyled d-flex flex-row justify-content-center">
            <li>
              <a class="text-white px-2" href="https://www.facebook.com/cataclymisation">
                <i class="fab fa-facebook-square"></i>
              </a>
            </li>
            <li>
              <a class="text-white px-2" href="https://instagram.com/markhormillionaire">
                <i class="fab fa-instagram"></i>
              </a>
            </li>
            <li>
              <a class="text-white ps-2" href="https://twitter.com/Markhormillion">
                <i class="fa fa-twitter"></i>
              </a>
            </li>
          </ul>

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">About us</h5>
<br>
          <ul class="list-unstyled">
            <li class="mb-2">
              <a href="#!" class="text-white"></i>Contact Us</a>
            </li>
            <br>
            <li class="mb-2">
              <a href="/about" class="text-white"><i class=""></i>About</a>
            </li>
            <br>
            <li class="mb-2">
              <a href="#!" class="text-white"><i class=""></i>FAQ</a>
            </li>
            
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">Help</h5>

          <ul class="list-unstyled">
            <li class="mb-2">
              <a href="#!" class="text-white"><i class=""></i></a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white"><i class=""></i></a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white"><i class=""></i></a>
            </li>
            <br>
            <li class="mb-2">
              <a href="#!" class="text-white"><i class=""></i>Privacy Policy</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white"><i class=""></i></a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white"><i class=""></i></a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">Contact</h5>

          <ul class="list-unstyled">
            <li>
              <p><i class="fas fa-map-marker-alt pe-2"></i>Office 184 i8/2 Islamabad</p>
            </li>
            <li>
              <p><i class="fas fa-phone pe-2"></i>051-5163092</p>
            </li>
            <li>
              <p><i class="fas fa-envelope pe-2 mb-0"></i>Info@markhormillionaire.com</p>
            </li>
          </ul>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
      © 2023 Copyright:
      <a class="text-white" href="">MarkhorMillionaire.com</a>
    </div>
    <!-- Copyright -->
  </footer>
<!-- end::footer -->
	
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/28beddf917.js" crossorigin="anonymous"></script>
</body>
</html>