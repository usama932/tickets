@include('header')

<br>
<br>
<br>
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
        <div class="row text-center">									
            <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInUp;">
                <div class="pricing_design">
                    <div class="single-pricing">
                        <div class="price-head">		
                            <h2>Starter</h2>
                            <h1>RS: 800 </h1>
                           

                        </div>
                        <ul>
                            <li>Get HandSome Profit</li>
                         <li> Can Refer Other Leaders </li>
                         <li>Each Joing Earns A Token </li>
                         <li>Direct And Indirect Earning </li>
                         
                        </ul>
                        <div class="pricing-price">
                          
                           @auth
                           @if(auth()->user()->subscription_status==1)
                           <button class="price_btn btn btn-primary"> Already Purchased</button>
                           @else
                            <form method="POST" action="{{ route('activateSubscription') }}">
                                @csrf
                              
                                <input type="hidden" name="price" value="800">
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="price_btn btn btn-primary">Purchase</button>
                            </form>
                            @endauth
                            @endif
                           
                        </div>
                    </div>
                </div>
            </div><!--- END COL -->	
            <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="pricing_design">
                    <div class="single-pricing">
                        <div class="price-head">		
                            <h2>Silver</h2>
                            <h1 class="price">Rs:1200/OneTime</h1>
                            {{-- <span>/Monthly</span> --}}
                        </div>
                        <ul>
                            <li> Higher Profit Than Rank 1 </li>
                            <li> Get HandSome Profit</li>
                            <li> Can Refer Other Leaders  </li>
                            <li> Direct And Indirect Earning</li>
                           
                        </ul>
                        <div class="pricing-price">
                           
                            @auth
                            @if(auth()->user()->subscription_status==2)
                            <button class="price_btn btn btn-primary"> Already Purchased</button>
                            @else
                           
                            <form method="POST" action="{{ route('activateSubscription') }}">
                                @csrf
                                <input type="hidden" name="price" value="1200">
                                 <input type="hidden" name="status" value="2">
                                <button type="submit" class="price_btn btn btn-primary">Purchase</button>
                            </form>
                           @endif
                           @endauth
                        </div>
                    </div>
                </div>  
            </div><!--- END COL -->	
            <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0" style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: fadeInUp;">
                <div class="pricing_design">
                    <div class="single-pricing">
                        <div class="price-head">		
                            <h2>Gold</h2>
                            <h1 class="price">Rs:2000/OneTime</h1>
                            {{-- <span>/Monthly</span> --}}
                        </div>
                        <ul>
                           <li> A Leader Can Request A Loan </li>
                           <li> Get HandSome Profit </li>
                           <li>Leader Can Earn Profit</li>
                           <li>By Just Promoting This Leader Up</li>
                           <li>Become A Online Vendor With Markor</li>
                           
                        </ul>
                        <div class="pricing-price">
                            @auth
                            @if(auth()->user()->subscription_status==3)
                            <button class="price_btn btn btn-primary"> Already Purchased</button>
                            @else
                           
                            <form method="POST" action="{{ route('activateSubscription') }}">
                                @csrf
                                <input type="hidden" name="price" value="2000">
                                <input type="hidden" name="status" value="3">
                                <button type="submit" class="price_btn btn btn-primary">Purchase</button>
                            </form>
@endauth
@endif
                            
                        </div>
                    </div>
                </div>
            </div><!--- END COL -->
            <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0" style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: fadeInUp;">
              <div class="pricing_design">
                  <div class="single-pricing">
                      <div class="price-head">		
                          <h2>Diamond</h2>
                          <h1 class="price">Rs:3000/OneTime</h1>
                          {{-- <span>/Monthly</span> --}}
                      </div>
                      <ul>
                         <li> A Leader Can Request A Loan </li>
                         <li> Get HandSome Profit </li>
                         <li>Leader Can Earn Profit</li>
                         <li>By Just Promoting This Leader Up</li>
                         <li>Become A Online Vendor With Markor</li>
                         
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
                              <button type="submit" class="price_btn btn btn-primary">Purchase</button>
                          </form>
                          @endif
                        @endauth
                        
                      </div>
                  </div>
              </div>
          </div><!--- END COL -->
          <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0" style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: fadeInUp;">
            <div class="pricing_design">
                <div class="single-pricing">
                    <div class="price-head">		
                        <h2>Millionaire</h2>
                        <h1 class="price">Rs:5000/OneTime</h1>
                        {{-- <span>/Monthly</span> --}}
                    </div>
                    <ul>
                       <li> A Leader Can Request A Loan </li>
                       <li>Become A Online Vendor With Markor</li>
                       <li>Leader Can Earn Profit</li>
                       <li>Will be Eligible For Non-Working Monthly Profit Requlaarly</li>
                       
                    </ul>
                    <div class="pricing-price">
                        @auth
                        @if(auth()->user()->subscription_status==5)
                        <button class="price_btn btn btn-primary"> Already Purchased</button>
                        @else
                        <form method="POST" action="{{ route('activateSubscription') }}">
                            @csrf
                            <input type="hidden" name="price" value="5000">
                            <input type="hidden" name="status" value="5">
                            <button type="submit" class="price_btn btn btn-primary">Purchase</button>
                        </form>
                        @endif
                        @endauth
                        
                    </div>
                </div>
            </div>
        </div><!--- END COL -->

        </div><!--- END ROW -->
    </div><!--- END CONTAINER -->
</section>

<style>
    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 60px; /* Adjust this value to set the height of the footer */
    }

    .pricing-content{position:relative;}
.pricing_design{
    position: relative;
    margin: 0px 15px;
}
.pricing_design .single-pricing{
    background:#554c86;
    padding: 60px 40px;
    border-radius:30px;
    box-shadow: 0 10px 40px -10px rgba(0,64,128,.2);
    position: relative;
    z-index: 1;
}
.pricing_design .single-pricing:before{
    content: "";
    background-color: #fff;
    width: 100%;
    height: 100%;
    border-radius: 18px 18px 190px 18px;
    border: 1px solid #eee;
    position: absolute;
    bottom: 0;
    right: 0;
    z-index: -1;
}
.price-head{}
.price-head h2 {
	margin-bottom: 20px;
	font-size: 26px;
	font-weight: 600;
}
.price-head h1 {
	font-weight: 600;
	margin-top: 30px;
	margin-bottom: 5px;
}
.price-head span{}

.single-pricing ul{list-style:none;margin-top: 30px;}
.single-pricing ul li {
	line-height: 36px;
}
.single-pricing ul li i {
	background: #554c86;
	color: #fff;
	width: 20px;
	height: 20px;
	border-radius: 30px;
	font-size: 11px;
	text-align: center;
	line-height: 20px;
	margin-right: 6px;
}
.pricing-price{}

.price_btn {
	background: #554c86;
	padding: 10px 30px;
	color: #fff;
	display: inline-block;
	margin-top: 20px;
	border-radius: 2px;
	-webkit-transition: 0.3s;
	transition: 0.3s;
}
.price_btn:hover{background:#0aa1d6;}
a{
text-decoration:none;    
}

.section-title {
    margin-bottom: 60px;
}
.text-center {
    text-align: center!important;
}

.section-title h2 {
    font-size: 45px;
    font-weight: 600;
    margin-top: 0;
    position: relative;
    text-transform: capitalize;
}
</style>
