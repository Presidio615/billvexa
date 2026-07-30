<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BillVexa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="shortcut icon" href="{{ asset('asset/Image/icon.png') }}" type="image/x-icon">

    <style>
        body{
            overflow-x: hidden;
            scroll-behavior: smooth;
            /* font-family: Arial, Helvetica, sans-serif; */
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
    </style>
</head>    
<body>
    <!-- Popup network -->
    <div id="statusPopup"
        class="alert text-center shadow rounded-3 fw-bold border-0">
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-white mx-auto mt-1"data-bs-theme="light" id="navbar"  style="border-radius:25px; width:90vw; margin-bottom:90px; border-bottom:1px solid azure;">
        <div class="container">

            <a href="{{ route('billvexa') }}" class="navbar-brand p-2 fw-bolder fst-italic" style="color: blueviolet; font-size: 1.5rem;">
                BillVexa
            </a>

            <button class="navbar-toggler shadow-none border-0 me-2" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu"
            aria-expanded="false"
            aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ps-2 pt-2 ms-lg-auto justify-content-end">
                        <li class="nav-item"><a href="{{ route('billvexa') }}" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="{{ route('billvexa.about') }}" class="nav-link">About</a></li>
                        <li class="nav-item"><a href="{{ route('billvexa.faqs') }}" class="nav-link">FAQs</a></li>
                        <li class="nav-item"><a href="{{ route('billvexa.contact') }}" class="nav-link">Contact Us</a></li> 
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mb-5">
        <h1 class="text-center mt-5">Privacy Policy</h1>
        <p class="text-center mt-3">Your privacy is important to us. This privacy policy explains how we   collect, use, and protect your personal information when you use our website.</p>
        <h2 class="mt-4">Information We Collect</h2>
        <p class="lead">We may collect personal information such as your name, email address, and other contact details when you voluntarily provide it to us through forms or interactions on our website.</p>
        <h2 class="mt-4">How We Use Your Information</h2>
        <p class="lead">We use the information we collect to provide and improve our services, communicate with you, and personalize your experience on our website. We do not sell or share your personal information with third parties for marketing purposes.</p>
        <h2 class="mt-4">Data Security</h2>
        <p class="lead">We take reasonable measures to protect your personal information from unauthorized access, disclosure, alteration, and destruction. However, no method of transmission over the internet or electronic storage is completely secure, and we cannot guarantee absolute security.</p>
        <h2 class="mt-4">Your Rights</h2>
        <p class="lead">You have the right to access, correct, or delete your personal information at any time. You also have the right to data portability and the right to withdraw your consent at any time.</p>
        <h2 class="mt-4">Changes to This Privacy Policy</h2>
        <p class="lead">We may update this privacy policy from time to time. We will notify you of any changes by posting the new privacy policy on this page. You are advised to review this privacy policy periodically for any changes.</p>
        <h2 class="mt-4">Contact Us</h2>
        <p class="lead">If you have any questions about this privacy policy, please contact us at [nd09079927615@gmail.com].</p>

    </div>
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
                                <li class="nav-item"><a href="{{ route('billvexa') }}" class="nav-link p-1">Home</a>
                                </li>
                                <li class="nav-item"><a href="{{ route('billvexa.about') }}" class="nav-link p-1">About</a>
                                </li>
                                <li class="nav-item"><a href="{{ route('billvexa.faqs') }}" class="nav-link p-1">FAQs</a>
                                </li>
                                <li class="nav-item"><a href="{{ route('billvexa.contact') }}" class="nav-link p-1">Contact Us</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-3 pt-4" style="font-size: medium;">
                            <h4>important links</h4>
                            <ul class="navbar-nav lead">
                                <li class="nav-item"><a href="{{ route('policy') }}" class="nav-link p-1">Privacy Policy</a>
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

    </script>
    
    
</body>
</html>