<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Order Checkout</title>
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #cd9cf2;
        
            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to top left, rgba(205, 156, 242, 1), rgba(246, 243, 255, 1));
        
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to top left, rgba(205, 156, 242, 1), rgba(246, 243, 255, 1))
        }
    </style>
</head>
<body>
  <section class="h-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-10 col-xl-8">
                <div class="card" style="border-radius: 10px;">
                    <div class="card-header px-4 py-5">
                        <h5 class="text-muted mb-0">Thanks for your Order, <span style="color: #a8729a;">{{ auth()->user()->name }}</span>!</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="lead fw-normal mb-0" style="color: #a8729a;">Receipt</p>
                        </div>
                        <div class="card shadow-0 border mb-4">
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach ($cart as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $item->product->product_name }}</span>
                                        <span class="small"> RS: {{ $item->product->product_price  }}</span>
                                      

                                      </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <h4>Total Charges:</h4>
                        <p>RS {{ $totalCharges + $deliveryCharges }}</p>

                        <h4>Shipping Address:</h4>
                        <form method="POST" action="{{ route('place-order') }}">
                            @csrf
                            <div class="mb-3">
                                
                                <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
                            </div>
                            @foreach ($cart as $item)
                            <input type="hidden" name="product_ids[]" value="{{ $item->product->id }}">
                        @endforeach

                            <h4>Payment Method:</h4>
                            <!-- Radio button for Cash on Delivery -->
<div class="mb-3">
  <input type="radio" id="cash_on_delivery" name="payment_method" value="cash_on_delivery" required>
  <label for="cash_on_delivery">Cash on Delivery</label>
</div>

<!-- Radio button for Buy from Current Balance -->
<div class="mb-3">
  <input type="radio" id="buy_from_balance" name="payment_method" value="current_balance" required>
  <label for="buy_from_balance">Buy from Current Balance (RS {{ $totalCharges + $deliveryCharges }})</label>
</div>


                            <button type="submit" class="btn btn-primary">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>