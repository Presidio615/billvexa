<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BillVexa</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

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
        z-index: 1000;
        backdrop-filter: blur(10px);
        transition: 0.4s ease;
    }

    /* NAVBAR SCROLL EFFECT */
    .nav-scroll{
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transform: translateY(-2px);
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
    /* HERO SECTION */
    .hero-section{
        /* min-height: 100vh; */
        position: relative;
        /* overflow: hidden; */

        background:
        linear-gradient(
            135deg,
            #5b21b6,
            #7c3aed,
            #2563eb
        );

        background-size: 400% 400%;

        animation: gradientMove 12s ease infinite;
    }

    /* Animated Gradient */
    @keyframes gradientMove{

        0%{
            background-position: 0% 50%;
        }

        50%{
            background-position: 100% 50%;
        }

        100%{
            background-position: 0% 50%;
        }
    }

    /* Glow circles */
    .hero-section::before,
    .hero-section::after{

        content: "";

        position: absolute;

        border-radius: 50%;

        filter: blur(80px);

        opacity: 0.35;

        z-index: 0;
    }

    /* Top Glow */
    .hero-section::before{

        width: 300px;
        height: 300px;

        background: #ffffff;

        top: -100px;
        left: -100px;
    }

    /* Bottom Glow */
    .hero-section::after{

        width: 350px;
        height: 350px;

        background: #60a5fa;

        bottom: -120px;
        right: -120px;
    }

    /* Keep content above background */
    .hero-section > *{
        position: relative;
        z-index: 2;
    }


    /* HERO IMAGE */
    .image{
        animation: floatImage 4s ease-in-out infinite;
    }

    @keyframes floatImage{
        0%{
            transform: translateY(0px);
        }
        50%{
            transform: translateY(-20px);
        }
        100%{
            transform: translateY(0px);
        }
    }

    /* CARD ANIMATION */
    .card{
        transition: 0.4s ease;
        border-radius: 20px;
        overflow: hidden;
    }

    .card:hover{
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    }

    /* ICON DESIGN */
    .card i{
        width: 70px;
        height: 70px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: 0.4s ease;
        background: rgba(138,43,226,0.1);
        color: blueviolet;
        border: none !important;
    }

    .card:hover i{
        transform: rotate(10deg) scale(1.1);
        background: blueviolet;
        color: white;
    }

    /* TEXT */
    h1,h2,h3,h4,h5{
        letter-spacing: 0.5px;
    }

    /* SCROLL ANIMATION */
    .reveal{
        opacity: 0;
        transform: translateY(80px);
        transition: all 1s ease;
    }

    .reveal.active{
        opacity: 1;
        transform: translateY(0);
    }

    /* FOOTER LINKS */
    footer .nav-link{
        transition: 0.3s ease;
    }

    footer .nav-link:hover{
        color: blueviolet !important;
        padding-left: 8px;
    }

    /* BUTTON EFFECT */
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
</style>

<body>
    <section class="p-4 hero-section">
        <div id="statusPopup"
            class="alert text-center shadow rounded-3 fw-bold border-0">
        </div>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg bg-white mx-auto mt-1" id="navbar" data-bs-theme="light" style="border-radius:25px; width:90vw; margin-bottom:90px; border-bottom:1px solid azure;"
        >
            <div class="container">

                <a href="{{ route('billvexa') }}" class="navbar-brand p-2 fw-bolder fst-italic" style="color: blueviolet; font-size: 1.5rem;">
                BillVexa
                </a>
                

                <button class="navbar-toggler shadow-none border-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                    
                    <span class="navbar-toggler-icon"></span>
                </button>
                

                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav ps-2 pt-2 ms-lg-auto justify-content-end">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('billvexa') ? 'active' : '' }}">Home</a></li>
                        <li class="nav-item"><a href="{{ route('billvexa.about') }}"  class="nav-link">About</a></li>
                        <li class="nav-item"><a href="{{ route('billvexa.faqs') }}"  class="nav-link">FAQs</a></li>
                        <li class="nav-item"><a href="{{ route('billvexa.contact') }}" class="nav-link">Contact Us</a></li>
                        <li class="nav-item ms-lg-3 d-none d-lg-block"><a href="{{ route('signin') }}"  class="btn btn-primary px-3">Signin</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="container pt-2 pb-5">
            <div class="row align-items-center">

               <!-- Text -->
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-start text-white pe-lg-3">

                    <p class="badge bg-white text-dark pe-5"
                      style="border-radius: 50px; font-family: serif;">

                        <span class="badge p-2 me-2"
                            style="background: blueviolet; border-radius: 50px; font-family: serif;">
                            New
                        </span>

                        Introducing our latest features!
                    </p>

                    <h1 class="display-4 fw-bolder"
                       style="font-family: 'Playfair Display', serif;">
                       BillVexa – The Ultimate Billing Solution
                    </h1>

                    <p class="lead">
                        Your one-stop solution for all your billing needs.
                        Manage your bills, track expenses, and stay organized with ease.
                    </p>

                </div>

                <!-- Image -->
                <div class="col-lg-6 order-1 order-lg-2 text-center">
                    <img src="{{ asset('asset/Image/payment-1-removebg-preview.png') }}"
                        alt="BillVexa"
                        class="img-fluid my-3 image">
                </div>

            </div>

            <a href="{{ route('signin') }} " class="btn btn-outline-primary px-5 me-1 d-lg-none mt-3 text-white" style="border-radius: 50px;">
                <i class="bi bi-person-circle me-1"></i> Signin
            </a>
        </div>
    </section>

    <!-- Section 2 -->
    <section class="p-5 reveal">
        <div>
            <div class="text-center pb-4">
                <h2 class="pt-5 fw-bold display-4">Our Features</h2>
                <p class="lead">Discover the powerful features that make BillVexa the perfect solution for your billing needs.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 h-100 reveal">
                        <div class="card-body">
                            <h5 class="card-title fw-bolder">Bill Management</h5>
                            <p class="card-text">Easily manage all your bills in one place. Track due dates, set reminders, and stay organized with our intuitive bill management system.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bolder">Expense Tracking</h5>
                            <p class="card-text">Keep track of all your expenses with our easy-to-use expense tracking feature. Get detailed reports and insights to help you manage your budget.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bolder">Automated Reminders</h5>
                            <p class="card-text">Never miss a payment again with our automated reminder system. Set custom reminders for each bill and never worry about late fees.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3 -->
    <section class="p-4 reveal" style="background: paleturquoise;">
        <div>
            <div class="text-center pb-4 ">
                <h1 class="pt-5 fw-bold display-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">Our Services</h1>
                <p>We offer a wide range of services to help you manage your bills and stay organized without leaving your home.</p>
            </div>

            <!-- Card -->
            <div class="container py-4">
                <div class="row g-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100 ">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-bolt" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Electricity Bills</h5>
                                <p class="card-text">Never miss a due date for your electricity bills again. Pay your electricity bills online with ease.</p>         
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-mobile-screen" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Airtime Topup</h5>
                                <p class="card-text">Recharge your mobile phone credit anytime, anywhere with our easy-to-use airtime top-up service. It's quick and convenient.</p>         
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                  <i class="fa-solid fa-futbol" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Betting</h5>
                                <p class="card-text">Place bets on your favorite sports and events with our secure and user-friendly betting platform.</p>         
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-satellite-dish" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Cable TV Subscription</h5>
                                <p class="card-text">Get uninterrupted entertainment with our reliable cable TV subscription. BillVexa makes it easy to manage your subscription.</p>         
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-mobile-screen" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Data Bundle Topup</h5>
                                <p class="card-text">Stay connected with our affordable data bundle top-up options. Choose from a variety of plans to suit your needs.</p>         
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-tv" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Showmax Subscription</h5>
                                <p class="card-text">Enjoy your favorite shows and movies on Showmax with our easy-to-use subscription service.</p>         
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body ">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-wifi" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Internet Topup</h5>
                                <p class="card-text">Stay connected with our affordable internet top-up options. Choose from a variety of plans to suit your needs.</p>         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4 -->
    <section class="py-5 bg-light reveal">
        <div class="container">

            <div class="row align-items-center gy-5">

                <!-- LEFT IMAGE -->
                <div class="col-12 col-lg-6 text-center">

                    <div class="position-relative rounded-circle border border-primary overflow-hidden mx-auto bg-body-secondary" style="width:300px; height:300px;">

                        <!-- PHONE 1 -->
                        <img 
                            src="{{ asset('asset/Image/HiShoot_20260401_051848-956x1024-removebg-preview.png') }}"
                            class="img-fluid position-absolute bottom-0 start-0"
                            style="width:190px; margin-left: 55px;">

                    </div>

                </div>

                <!-- RIGHT CONTENT -->
                <div class="col-12 col-lg-6">

                    <h1 class="fw-bold text-center text-lg-start display-6">
                        How does it work?
                    </h1>
                    <p class="lead">Follow these easy steps to get your recharge done</p>

                    <!-- STEP 1 -->
                    <div class="d-flex align-items-start gap-3 mt-5">

                        <div class="rounded-circle border border-primary text-primary fw-bold d-flex justify-content-center align-items-center flex-shrink-0"
                            style="width:45px; height:45px;">
                            1
                        </div>

                        <div>
                            <h5 class="fw-bold">Create an account</h5>

                            <p class="mb-0">
                            Sign up on our website to create an account
                            </p>
                        </div>

                    </div>

                    <!-- STEP 2 -->
                    <div class="d-flex align-items-start gap-3 mt-4">

                        <div class="rounded-circle border border-primary text-primary fw-bold d-flex       justify-content-center align-items-center flex-shrink-0"
                            style="width:45px; height:45px;">
                            2
                        </div>

                        <div>
                            <h5 class="fw-bold">Add money to your wallet</h5>

                            <p class="mb-0">
                            Add money to your wallet using our secure payment gateway
                            </p>
                        </div>

                    </div>

                    <!-- STEP 3 -->
                    <div class="d-flex align-items-start gap-3 mt-4">

                        <div class="rounded-circle border border-primary text-primary fw-bold d-flex justify-content-center align-items-center flex-shrink-0"
                            style="width:45px; height:45px;">
                            3
                        </div>

                        <div>
                            <h5 class="fw-bold">Do Recharge</h5>

                            <p class="mb-0">
                            Recharge your mobile with just a few clicks
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- SECTION 5 -->
    <section style="background:paleturquoise;" class="reveal">
        <div class="container py-5">
            <div class="text-center pt-5">
                <h2 class="fw-bold display-4">Why Choose <span style="color: blue;">BillVexa?</span></h2>
                <p>BillVexa offers a convenient and secure way to manage your bills and stay organized. With our user-friendly platform, you can easily track your expenses, set reminders for due dates, and make payments online. Our services are designed to save you time and help you stay on top of your finances.</p>
            </div>
                <div class="row g-4 mt-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                  <i class="fa-solid fa-bolt" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Fast and secure bill payments</h5>
                                <p class="card-text">Pay your bills anytime, anywhere with our easy-to-use online platform. No more waiting in long lines or dealing with complicated payment processes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-shield-halved" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Security</h5>
                                <p class="card-text">Your financial information is safe with us. We use advanced security measures to protect your data and ensure that your transactions are secure.</p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-sitemap"  style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Organization</h5>
                                <p class="card-text">Keep track of your bills and expenses in one place. Our platform allows you to set reminders for due dates and helps you stay organized with your finances.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-headset" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Customer Support</h5>
                                <p class="card-text">Our dedicated customer support team is here to assist you with any questions or issues you may have. We are committed to providing excellent service and ensuring your satisfaction.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <i class="fa-solid fa-table-cells-large" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Wide Range of Services</h5>
                                <p class="card-text">We offer a variety of services to meet your billing    eeds, including electricity bills, airtime top-up, betting, cable TV subscription, data bundle top-up, Showmax subscription, and internet top-up.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="col-md-4">
                                <i class="fa-solid fa-hand-pointer" style="border: 1px solid black; padding: 20px; border-radius: 50%;"></i>
                                </div>
                                <h5 class="card-title fw-bolder">Easy-to-use and user-friendly interface</h5>
                                <p class="card-text">Our platform is designed with the user in mind. It is easy to navigate and use, making it simple for you to manage your bills and stay organized.</p>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container-fluid bg-dark text-light py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 pt-4">
                        <h4>BillVexa </h4>
                        <p class="lead" style="font-size: medium;">
                                BillVexa is a leading online platform that provides convenient and secure solutions for managing your bills and staying organized. With our user-friendly interface and powerful features, we help you track your expenses, set reminders for due dates, and make payments online with ease. Our mission is to simplify your billing experience and help you stay on top of your finances.
                            </p>
                        </div>

                        <div class="col-lg-3 pt-4" style="font-size: medium;">
                            <h4>Page</h4>
                            <ul class="navbar-nav lead">
                                <li class="nav-item"><a href={{ route('billvexa') }} class="nav-link">Home</a></li>
                                <li class="nav-item"><a href={{ route('billvexa.about') }}  class="nav-link">About</a></li>
                                <li class="nav-item"><a href={{ route('billvexa.faqs') }}  class="nav-link">FAQs</a></li>
                                <li class="nav-item"><a href={{ route('billvexa.contact') }} class="nav-link">Contact Us</a></li> 
                            </ul>
                        </div>

                        <div class="col-lg-3 pt-4" style="font-size: medium;">
                            <h4>important links</h4>
                            <ul class="navbar-nav lead">
                                <li class="nav-item"><a href="{{ route('policy') }}"class="nav-link p-1">Privacy Policy</a>
                                </li>
                                <li class="nav-item"><a href="{{ route('terms') }}" class="nav-link p-1">Terms & Conditions</a>
                                </li>
                                <li class="nav-item"><a href="{{ route('refund') }}" class="nav-link p-1">Refund Policy</a>
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
            </span> BillVexa.
            All rights reserved.
        </div>
    </footer>        
    <script>

        const popup = document.getElementById("statusPopup");
        const navbar = document.getElementById("navbar");

        let offlineShown = false;

        // OFFLINE POPUP
        function showOffline(){

            popup.innerHTML = "❌ No Internet Connection";

            popup.className =
            "alert alert-danger text-center fw-bold shadow border-0 rounded-3 show-popup";

            offlineShown = true;
        }

        // ONLINE POPUP
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

                await fetch("https://jsonplaceholder.typicode.com/posts/1", {
                    cache: "no-cache"
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

        // AUTO CHECK
        setInterval(checkInternet, 5000);

        checkInternet();

        // NAVBAR SHADOW ON SCROLL
        window.addEventListener("scroll", () => {

            if(window.scrollY > 50){

                navbar.classList.add("nav-scroll");

            }else{

                navbar.classList.remove("nav-scroll");
            }
        });

        // SCROLL REVEAL
        function revealElements(){

            const reveals = document.querySelectorAll(".reveal");

            reveals.forEach((element) => {

                const windowHeight = window.innerHeight;
                const revealTop = element.getBoundingClientRect().top;

                if(revealTop < windowHeight - 100){

                    element.classList.add("active");
                }
            });
        }

        window.addEventListener("scroll", revealElements);

        revealElements();

    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/all.min.js"></script> -->
   
</body>
</html>