<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Checkout</title>
    <style>
        .main {
            height: 100px;
            background-color: #100851;
            margin-top: -25px !important;
            padding-top: 30px !important;
        }

        .navbar {
            position: relative;
            z-index: 2;
            background: #6e61e7 !important;
            border-radius: 18px !important;
        }

        .nav-link {
            color: white;
        }
        body {
            background-color: #eee;
        }
        .checkout-section {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 50px;
        }
        .checkout-heading {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .card {
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 20px;
        }
        .product-img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        .total-charges {
            font-size: 18px;
        }
        .checkout-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    @include('navbar')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="checkout-section">
                    <h3 class="checkout-heading">Shopping Cart</h3>
                    @foreach ($cartItems as $item)
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <img src="{{ asset($item->product->product_image) }}" alt="{{ $item->product->product_name }}" class="product-img">
                                    </div>
                                    <div class="col-md-6">
                                        <p class="fw-bold">{{ $item->product->product_name }}</p>
                                        <p class="text-muted">Price: RS {{ $item->product->product_price }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <h5>RS {{ $item->product->product_price }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p class="lead fw-normal mb-0">Delivery Charges</p>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-0">RS {{ $deliveryCharges/277 }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="mb-0">Total Charges</h4>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="total-charges">RS {{ $totalCharges/277 }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('storeOrder') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="total_charges" value="{{ $totalCharges/277 }}">
                        <label for="shipping_address">Shipping Address</label>
                        <textarea name="shipping_address" id="shipping_address" rows="4" class="form-control" required></textarea>
                        <input type="text" name="promocode" class="form-control my-3" placeholder="Promo Code">
                        <label for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control" required>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                            <option value="from_balance">From Balance</option>
                        </select>
                        <button type="submit" class="btn btn-primary checkout-btn">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" >
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" >
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
