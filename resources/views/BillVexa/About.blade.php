<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BillVexa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="shortcut icon" href="{{ asset('asset/Image/icon.png') }}" type="image/x-icon">
</head>
<style>

    body{
        overflow-x: hidden;
        scroll-behavior: smooth;
        /* font-family: Arial, Helvetica, sans-serif; */
    }

    /* NAVBAR */
    #navbar{
        position: sticky;
        top: 10px;
        width: 100%;
        z-index: 1000;
        backdrop-filter: blur(10px);
        transition: 0.4s ease;
    }

    /* NAVBAR SCROLL */
    .nav-scroll{
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        transform: translateY(-3px);
    }

    /* HERO SECTION */
    .hero-section{
        background: linear-gradient(135deg, blueviolet, rgb(111, 0, 255));
        /* min-height: 80vh; */
        /* display: flex; */
        align-items: center;
    }

    /* HERO TEXT */
    .hero-content{
        animation: fadeUp 1.2s ease;
    }

    @keyframes fadeUp{
        from{
            opacity: 0;
            transform: translateY(50px);
        }

        to{
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* POPUP */
    #statusPopup{
        position: fixed;
        top: 15px;
        left: 50%;
        transform: translateX(-50%) translateY(-150%);
        transition: 0.5s ease;
        z-index: 9999;
        min-width: 320px;
    }

    #statusPopup.show-popup{
        transform: translateX(-50%) translateY(0);
    }

    /* SCROLL REVEAL */
    .reveal{
        opacity: 0;
        transform: translateY(80px);
        transition: 1s ease;
    }

    .reveal.active{
        opacity: 1;
        transform: translateY(0);
    }

    /* MAP EFFECT */
    .ratio iframe{
        border-radius: 20px;
        transition: 0.4s ease;
    }

    .ratio iframe:hover{
        transform: scale(1.02);
    }

    /* FOOTER LINKS */
    footer .nav-link{
        transition: 0.3s ease;
    }

    footer .nav-link:hover{
        color: blueviolet !important;
        padding-left: 10px;
    }

    /* NAV LINKS */
    .nav-link{
        position: relative;
    }

    .nav-link::after{
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0%;
        height: 2px;
        background: blueviolet;
        transition: 0.4s ease;
    }

    .nav-link:hover::after{
        width: 100%;
    }

    /* RESPONSIVE */
    @media(max-width:768px){

        .hero-section{
            min-height: auto;
            padding: 80px 0;
        }

        h1{
            font-size: 2.2rem !important;
        }
    }

</style>
<body>
    <section class="hero-section p-4">
        <div id="statusPopup"
            class="alert text-center shadow rounded-3 fw-bold border-0">
        </div>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg bg-white mx-auto mt-1" style="border-radius:25px; width:90vw; margin-bottom:90px;" data-bs-theme="white" id="navbar">
            <div class="container">

                <a href="" class="navbar-brand p-2 fw-bolder fst-italic" style="color: blueviolet; font-size: 1.5rem;">
                    {{ $setting->site_name ?? 'BillVexa' }}
                </a>

                <button class="navbar-toggler shadow-none border-0 me-2" data-bs-toggle="collapse" data-bs-target="#menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                

                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav pt-2 ps-2 ms-lg-auto justify-content-between">
                        <li class="nav-item"><a href={{ route('billvexa') }} class="nav-link">Home</a></li>
                        <li class="nav-item"><a href={{ route('billvexa.about') }}  class="nav-link">About</a></li>
                        <li class="nav-item"><a href={{ route('billvexa.faqs') }}  class="nav-link">FAQs</a></li>
                        <li class="nav-item"><a href={{ route('billvexa.contact') }} class="nav-link">Contact Us</a></li>  
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="container pt-2 pb-5">
            <div class="row align-items-center">

            <!-- Text -->
                <div class="text-white text-center hero-content">
                    <h1 class="display-4 fw-bolder"
                    style="font-family: 'Playfair Display', serif;">
                        About {{ $setting->site_name ?? 'BillVexa' }}
                    </h1>

                    <p class="lead">
                        {{ $setting->site_name ?? 'BillVexa' }} is a web application that allows users to manage their bills and payments in one place. It provides a simple and intuitive interface for users to track their expenses, set reminders for upcoming bills, and make payments securely.
                    </p>
                </div>
            </div>
        </div>
    </section>   

    <section class="py-5 reveal">
        <div class="container pt-2">
            <div class="row align-items-center">

              <!-- Text -->
                <div class="text-black text-center ">

                    <h1 class="display-4 fw-bolder" style="font-family: 'Playfair Display', serif;">
                      Our Mission
                    </h1>

                    <p class="lead">
                        Our mission is to simplify the bill management process for our users, helping them stay organized and on top of their finances. We aim to provide a reliable and user-friendly platform that empowers individuals to take control of their financial obligations and make informed decisions about their spending.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 reveal" style="background: paleturquoise;">
        <div class="container pt-2">
            <div class="row align-items-center">

              <!-- Text -->
                <div class="text-dark
                    text-center ">
    
                        <h1 class="display-4 fw-bolder" style="font-family: 'Playfair Display', serif;">
                            Our Vision
                        </h1>
    
                        <p class="lead">
                            Our vision is to become the go-to platform for bill management, providing a seamless and efficient experience for users worldwide. We strive to continuously innovate and enhance our services to meet the evolving needs of our users, ultimately helping them achieve financial stability and peace of mind.
                        </p>
                </div>
            </div>  
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            
            <div class="text-center mb-4">
                <h3 class="display-4 fw-bolder" style="font-family: 'Playfair Display', serif;">Our Location</h3>
            </div>

            <div class="d-flex justify-content-center">
                
                <div class="ratio ratio-16x9 w-100 shadow-lg" style="max-width:700px;">

                    <iframe 
                        src="https://maps.google.com/maps?width=600&height=400&hl=en&q=awka&t=k&z=14&ie=UTF8&iwloc=B&output=embed"
                        allowfullscreen
                        loading="lazy"
                        style="border:0;">
                    </iframe>

                </div>

            </div>

        </div>
    </section>
    <footer>
        <div class="container-fluid bg-dark text-light py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 pt-4">
                        <h4>{{ $setting->site_name ?? 'BillVexa' }} </h4>
                        <p class="lead" style="font-size: medium;">
                            {{ $setting->site_name ?? 'BillVexa' }} is a leading online platform that provides convenient and secure solutions for managing your bills and staying organized. With our user-friendly interface and powerful features, we help you track your expenses, set reminders for due dates, and make payments online with ease. Our mission is to simplify your billing experience and help you stay on top of your finances.
                            </p>
                        </div>

                        <div class="col-lg-3 pt-4" style="font-size: medium;">
                        <h4>Page</h4>
                            <ul class="navbar-nav lead">
                                <li class="nav-item"><a href="./home.php" class="nav-link p-1">Home</a>
                                </li>
                                <li class="nav-item"><a href="#" class="nav-link p-1">About</a>
                                </li>
                                <li class="nav-item"><a href="./FQAs.php" class="nav-link p-1">FAQs</a>
                                </li>
                                <li class="nav-item"><a href="./Contact-us.php" class="nav-link p-1">Contact Us</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-3 pt-4" style="font-size: medium;">
                            <h4>important links</h4>
                            <ul class="navbar-nav lead">
                                <li class="nav-item"><a href={{ route('policy') }} class="nav-link p-1">Privacy Policy</a>
                                </li>
                                <li class="nav-item"><a href={{ route('terms') }} class="nav-link p-1">Terms & Conditions</a>
                                </li>
                                <li class="nav-item"><a href={{ route('refund') }}   class="nav-link p-1">Refund Policy</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-2 pt-4">
                            <h5>Contact</h5>
                            <p class="lead fs-5">Email: nd09079927615@gmail.com</p>
                            <p class="lead fs-5">Phone: +234 901 197 3177</p>

                        </div>

                    </div>
                </div>    
            </div>

        </div>
        <hr class=" m-0">

        <div class="text-center bg-dark p-4 text-light">
            &copy;
            <span>
                <script>
                    document.write( new Date().getFullYear() )
                </script>
            </span> {{ $setting->site_name ?? 'BillVexa' }}.
            All rights reserved.
        </div>
    </footer>   

    <script>

        const popup = document.getElementById("statusPopup");
        const navbar = document.getElementById("navbar");

        let offlineShown = false;

        // OFFLINE
        function showOffline(){

            popup.innerHTML = "❌ No Internet Connection";

            popup.className =
            "alert alert-danger text-center fw-bold shadow border-0 rounded-3 show-popup";

            offlineShown = true;
        }

        // ONLINE
        function showOnline(){

            popup.innerHTML = "✅ Back Online";

            popup.className =
            "alert alert-success text-center fw-bold shadow border-0 rounded-3 show-popup";

            setTimeout(() => {

                popup.classList.remove("show-popup");

            }, 3000);

            offlineShown = false;
        }

        // CHECK INTERNET
        async function checkInternet(){

            try{

                await fetch("https://jsonplaceholder.typicode.com/posts/1",{
                    cache:"no-cache"
                });

                if(offlineShown){

                    showOnline();
                }

            }catch{

                if(!offlineShown){

                    showOffline();
                }
            }
        }

        // EVENTS
        window.addEventListener("offline", showOffline);

        window.addEventListener("online", checkInternet);

        setInterval(checkInternet, 5000);

        checkInternet();

        // NAVBAR EFFECT
        window.addEventListener("scroll", () => {

            if(window.scrollY > 50){

                navbar.classList.add("nav-scroll");

            }else{

                navbar.classList.remove("nav-scroll");
            }
        });

        // REVEAL ANIMATION
        function reveal(){

            const reveals = document.querySelectorAll(".reveal");

            reveals.forEach((element) => {

                const windowHeight = window.innerHeight;

                const revealTop = element.getBoundingClientRect().top;

                if(revealTop < windowHeight - 100){

                    element.classList.add("active");
                }
            });
        }

        window.addEventListener("scroll", reveal);

        reveal();

    </script>
    
    <script src="../Assets/libs/js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/Src/jquery-4.0.0.min.js"></script>
</body>
</html>