<div class="container-fluid main ">
    <div class="container mt-4 ">
        <nav class="navbar navbar-expand-lg bg-primary rounded nv-bar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img class="img img-fluid" src={{ asset("assets/media/logo_f.png") }}
                        height="25px" width="70px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="/about">About</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('homesubscription') }}">Subscriptions</a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboard">Dashboard</a>
                            </li>
                            <!-- Add other authenticated user links here -->
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/signin">Login</a>
                            </li>
                        @endauth
                    </ul>

                    <ul class="navbar-nav me-0 mb-2 mb-lg-0 ">
                        <li class="nav-item ml-2">
                            <div class="container bg-white position-relative d-flex mr-2"
                                style="border-radius: 100px;">
                                <form class="d-flex " role="search">
                                    <input class="form-control rounded-corcle" type="search" placeholder="Search"
                                        aria-label="Search">

                                </form>
                                <div
                                    class="container-fluid position-absolute bottom-0 end-0"style="border-radius: 100px;width:70px;background-color:indigo">
                                    <button class="btn  b-0 searchbutton"><i
                                            class="fa fa-search text-white pr-2"></i></button>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item ml-2">
                            <a class="nav-link" href="{{ route('showCart') }}"><i
                                    class="fa fa-shopping-cart text-white"></i> <span
                                    class="badge text-bg-secondary">4</span></a>
                        </li>
                        <li class="nav-item ml-2">
                            <a class="nav-link" href="/dashboard"><img
                                    class="img img-fluid ml-2 mr-2 rounded-circle" src="{{ asset('assets/media/user.png') }}"
                                    height="25px" width="25px"></a>
                        </li>
                    </ul>


                </div>
            </div>
        </nav>
    </div>

</div>