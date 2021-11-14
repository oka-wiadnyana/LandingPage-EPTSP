<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css"> -->
    <link rel="stylesheet" href="<?= base_url('/owlcarousel/dist/assets/owl.carousel.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('/owlcarousel/dist/assets/owl.theme.default.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">



    <title>Hello, world!</title>
</head>

<style>
    .color-bar {
        height: 0.5rem;
    }

    /* .navbar {
        height: 8rem;
    } */

    .header-border {
        height: 2rem;
        ;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;

    }

    .welcome {
        position: absolute;
        left: 5vh;
        top: 5vh;
        z-index: 3;

        /* animation-name: example;
        animation-duration: 8s;
        animation-delay: 2s; */
    }

    .welcome-2 {
        position: absolute;
        left: 5vh;
        top: 13vh;
        z-index: 3;

        /* animation-name: example;
        animation-duration: 8s;
        animation-delay: 2s; */
    }

    /* @keyframes example {
        0% {
            background-color: red;
            left: 5vh;
            top: 5vh;
        }

        25% {
            background-color: yellow;
            left: 5vh;
            top: 30vh;
        }

        50% {
            background-color: blue;
            left: 5vh;
            top: 20vh;
        }

        75% {
            background-color: green;
            left: 5vh;
            top: 30vh;
        }

        100% {
            background-color: red;
            left: 5vh;
            top: 30vh;
        }
    } */
    span {
        font-family: Roboto, sans-serif;
    }

    h1 {
        color: salmon;
    }

    .shape {
        display: inline-block;
        margin-left: 5rem;
        width: 3rem;
        height: 3rem;
        background-color: seagreen;
        border-radius: 50%;
        border: solid;
    }

    .shape::before {
        content: '';
        display: inline-block;
        /* margin-right: 1rem; */
        margin-right: 5rem;
        width: 4rem;
        height: 1rem;
        background-color: red;

        border: solid;
    }

    .shape::after {
        content: '';
        display: inline-block;
        width: 2rem;
        height: 1rem;
        background-color: yellow;

        border: solid;
    }
</style>





<body>
    <!-- Header  -->
    <div class="header">
        <div class="color-bars">
            <div class="container-fluid">
                <div class="row">
                    <div class="col color-bar bg-warning d-none d-md-block"></div>
                    <div class="col color-bar bg-success d-none d-md-block"></div>
                    <div class="col color-bar bg-danger d-none d-md-block"></div>
                    <div class="col color-bar bg-info d-none d-md-block"></div>
                    <div class="col color-bar bg-warning d-none d-md-block"></div>
                    <div class="col color-bar bg-success d-none d-md-block"></div>
                    <div class="col color-bar bg-danger d-none d-md-block"></div>
                    <div class="col color-bar bg-info d-none d-md-block"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-border bg-dark"></div>
    <div class="container-fluid mb-0">
        <div class="container-fluid">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class=" d-none d-md-block col-md-2 ">
                    <a class="navbar-brand" href="#"><img src="<?= base_url('img/logo-ma.png'); ?>" class='img-fluid' style="width:15vh" alt=""></a>
                </div>
                <div class="ml-auto">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>


                <div class="collapse ml-auto navbar-collapse col-md-8" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item dropdown mr-5 ">
                            <div class="d-flex d-md-block">
                                <div class="col-4 col-md-12" style="width :10vh">
                                    <a class=" nav-link rounded-circle bg-info text-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-home text-white " style="font-size: 1.5rem;"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>

                                <div class="my-auto d-md-flex justify-content-center">
                                    <span style="font-size: 1.5rem;">Home</span>
                                    <span class="border-right border-primary ml-2"></span>
                                </div>

                            </div>
                        </li>
                        <li class="nav-item dropdown mr-5">
                            <div class="d-flex d-md-block">
                                <div class="col-4 col-md-12" style="width :10vh">
                                    <a class=" nav-link rounded-circle bg-danger text-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-user text-white " style="font-size: 1.5rem;"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                                <div class="my-auto d-md-flex justify-content-center">
                                    <span style="font-size: 1.5rem;">Pidana</span>
                                    <span class="border-right border-danger ml-2"></span>
                                </div>
                            </div>




                        </li>
                        <li class="nav-item dropdown mr-5">
                            <div class="d-flex d-md-block">
                                <div class="col-4 col-md-12" style="width :10vh">
                                    <a class=" nav-link rounded-circle bg-success text-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-handshake text-white style=" font-size: 1.5rem;""></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                                <div class="my-auto d-md-flex justify-content-center">
                                    <span style="font-size: 1.5rem;">Perdata</span>
                                    <span class="border-right border-success ml-2"></span>
                                </div>
                            </div>
                        <li class="nav-item dropdown mr-5">
                            <div class="d-flex d-md-block">
                                <div class="col-4 col-md-12" style="width :10vh">
                                    <a class=" nav-link rounded-circle bg-warning text-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-balance-scale text-white " style="font-size: 1.5rem;"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                                <div class="my-auto d-md-flex justify-content-center">
                                    <span style="font-size: 1.5rem;">Hukum</span>
                                    <span class="border-right border-warning ml-2"></span>
                                </div>
                            </div>




                        </li>


                    </ul>

                </div>
            </nav>

        </div>
    </div>
    <!-- End Header/Section2 Start -->
    <div class="row mt-0">
        <div class="col">
            <div class="owl-carousel owl-theme">
                <div><img src="<?= base_url('img/blue.png'); ?>" class="img-fluid mx-auto " style="height:40vh" alt=""></div>

                <div><img src="<?= base_url('img/blue.png'); ?>" class="img-fluid mx-auto " style="height:40vh" alt=""></div>
                <div><img src="<?= base_url('img/blue.png'); ?>" class="img-fluid mx-auto " style="height:40vh" alt=""></div>
            </div>
            <div class="welcome animate__animated animate__backInLeft d-none d-md-block">
                <h1 class="" style="font-family: 'Fredoka One', cursive; font-size :4rem; color:coral ">Selamat datang di Pengadilan Negeri Bangli</h1>

            </div>
            <div class="welcome-2 animate__animated animate__backInLeft animate__delay-2s mt-3">

                <h2 class="text-dark" style="font-family: 'Roboto', sans-serif;">e-PTSP Pengadilan Negeri Bangli</h2>
            </div>
        </div>
    </div>


    <!-- End Section 2/Section 3 Start -->
    <div class="container">
        <div class="row">
            <div class="col" style="border:solid">
                <span class="shape shape-left"></span>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script type="text/javascript" src="<?= base_url('owlcarousel/dist/owl.carousel.js'); ?>"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 1,
                margin: 10,
                loop: true,
                nav: true,
                rewind: true,
                autoplay: true,

            });
        });
    </script>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="<?= base_url('owlcarousel/owl.carousel.min.js'); ?>"></script>


    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
</body>

</html>