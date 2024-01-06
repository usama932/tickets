<html lang="en">

<head>
    <title>Hail A Taxi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <style>
        body {
            background: #288dfa;
            position: relative;
            height: 100vh;
        }

        .form--user__icon span{
            font-size: 32px;
            position: absolute !important;
            top: 50% !important;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .container {
                width: 40%;
    margin: 0 auto;
    background: green;
    border-radius: 4px;
    position: absolute;
    top: 50%;
    z-index: 2;
    color: #fff;
    content: '';
    padding: 20px;
    left: 50%;
    transform: translate(-50%, -50%);
        }


        .form--user__icon {
                  border-radius: 50%;
    height: 100px;
    z-index: 9;
    top: -50px;
    text-align: center;
    left: 50%;
    transform: translate(-50%, 0);
    position: absolute;
    background: #ea7a1a;
    width: 100px;
    color: #fff;
        }

        button {

     width: 100%;
     color:#fff !important;
    border-radius: 50px !important;
    border: 0 !important;
    background: #003296 !important;
        }

        .container h3 {
            margin-top: 60px;
        }
        form a{
        color:#fff !important;
        text-decoration:underline !important;
        }
    </style>

    <div class="container">
        <div class="form--user__icon mb-5">

            <span>  <img src="{{ asset('images/hail.png') }}" style="height:150px !important;"> </span>

        </div>
        <h3 class="text-center">Welcome To Hail A Taxi </h3>
        <h4 class="text-center  ">Login Form</h4>
        <form  method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email"> <span class="glyphicon glyphicon-user"></span> Email:</label>
                <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" placeholder="Enter email" name="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="pwd"> <span class="glyphicon glyphicon-lock"></span> Password:</label>
                <input type="password"  class="form-control  @error('password') is-invalid @enderror" id="password" placeholder="Enter password" name="password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>

</body>

</html>
