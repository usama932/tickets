<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Markhor Millionaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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

        .container-bottom {
            position: relative;
            border-bottom-right-radius: 100px;
            background-color: #100851;
            z-index: 1;
        }

        .donall-lu {
            padding: 5rem !important;
        }

        .rounded-button {
            position: absolute;
            bottom: 0;
            right: 0;
            border-bottom-right-radius: 50 !important;
            border-bottom-left-radius: 0 !important;
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            background-color: #100851;
        }

        .btn-new {
            background: #0FA0CD;
            color: #fff;
            padding: 7px 17px;
            border: none;
            margin: 10px 0px;
            border-radius: 3px;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 15px;
        }

        .rounded-button:hover {
            background-color: blue;
        }

        .card:hover {
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            transition: box-shadow 0.5s ease-in-out !important;
        }

        .card-body {
            line-height: 0.9;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none !important;
            /* Remove the default focus outline */
            border-color: white !important;
            /* Reset the border color */
            box-shadow: none !important;
            /* Remove any box shadow */
        }

        input {
            border: none !important;
            outline: none !important;
            /* Remove the focus outline */
        }

        .searchbutton {
            border: none !important;
            outline: none !important;
        }

        .product-container img {
            height: 150px;
            width: 100%;
            object-fit: cover;
        }

        .card-header {
            border-bottom-left-radius: 10px !important;
            border-bottom-right-radius: 10px !important;
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 568px) and (-webkit-min-device-pixel-ratio: 2) {
            .text-center {
                text-align: center !important;
                font-size: 10px !important;
            }

            .donall-lu {
                padding: 0.5rem !important;
            }

            .p-5 {
                padding: 1rem !important;
            }

            h4.new-txt {
                font-size: 16px;
            }

            h4.hed-1 {
                font-size: 18px;
            }

            h4.hed-2 {
                font-size: 16px;
            }

            .order-2 {
                order: 1 !important;
                float: left;
                width: 50%;
                font-size: 12px;
                margin-top: 15px;
            }

            img.new-one-img {
                width: 50%;
                float: right;
                margin-top: -254px;
            }
        }

        @media (min-width: 992px) {
            .image-desktop {
                max-width: 80%;
                /* Adjust the max-width value as needed */
                margin: 0 auto;
                /* Center the image horizontally */
            }
        }
    </style>
</head>

<body class="m-0 p-0">
    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (isset($success))
    <div class="alert alert-success">
        {{ $success }}
    </div>
    @elseif(isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
    @endif

    @include('navbar')

    <div class="container-fluid container-bottom">
        <div class="row p-5">
            <div class="col-12 col-md-6 col-lg-6 order-md-1 order-sm-2 order-2 p-sm-5 p-md-5 p-lg-5 pt-sm-2 donall-lu">
                <h4 class="hed-1" style="color:#0d8a94">COME EARN</h4>
                <h4 class="hed-2" style="color: #eacf6f">GET FINANCIAL FREEDOM</h4>
                <h4 class="text-white new-txt">& RULE THE WORLD !</h4>
                <p class="text-white">Becoming A Leader With Markhor Will Give You, Online Earning, Profits, Monthly Non
                    Working, And Can Make You A Brand In Itself!</p>
                @if (auth()->check())
                <a class="btn btn-primary btn-lg btn-new" href="/signout">Logout</a>
                @else
                <a class="btn btn-primary btn-lg btn-new" href="/signup">Register Now</a>
                @endif
            </div>
            <div class="col-12 col-md-6 col-lg-6 order-md-2 order-sm-1 order-1 pt-0 p-5">
                <img class="img img-fluid new-one-img" src="assets/media/header.png" alt="Hero Image">
            </div>
        </div>
    </div>

    <div class="container mt-4 product-container">
        <div class="row text-center">
            @foreach ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="card shadow bg-white rounded position-relative mb-1">
                    <a href="{{ route('single_product',$product->id) }}">
                        <div class="card-header bg-white p-0 m-0">
                            <img src="{{ asset($product->product_image) }}" class="img-fluid rounded image-desktop"
                                alt="...">
                        </div>
                    </a>
                    <div class="card-body bg-light">
                        <a href="{{ route('single_product',$product->id) }}">
                            <h6 class="text-center">{{ $product->product_name }}</h6>
                            <p class="test-center"><small class="text-muted">{{ $product->product_description }}</small>
                            </p>
                            <strong> $ {{ $product->product_price }}</strong>
                            <p class="">
                                <small><del class="text-muted"></del></small>
                            </p>
                        </a>
                        <a class="btn btn-sm position-absolute bottom-0 end-0 rounded-button" data-bs-toggle="modal"
                            data-bs-target="#productModal_{{ $product->id }}"
                            onclick="showProductModal('{{ $product->product_name }}', '{{ $product->product_description }}', {{ $product->product_price }})"><i
                                class="fa fa-shopping-cart text-white" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container" style="height: 100px"></div>
    @foreach ($products as $product)
    <div class="modal fade" id="productModal_{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Add to Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addToCartForm" action="{{ route('addtocart', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
                        </div>
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

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

    <script>
        function showProductModal(name, description, price) {
            $('#productModalLabel').text(name);
            $('#productModal .modal-body p').text(description);
            $('#productModal .modal-body strong').text(price);
        }
    </script>
</body>

</html>
