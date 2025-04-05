<?php
Use Dotenv\Dotenv;// Import Dotenv classes into the global namespace

// Load Composer's autoloader
include './vendor/autoload.php';
require_once './Database/db.php';

// Start the session
session_start();

// Load environment variables
$dotenv = Dotenv::createImmutable('./');
$dotenv->load();

// Signin With Google Account Start
$client = new Google\Client;

$client ->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);

$client->addScope("email");
$client->addScope("profile");


$url = $client->createAuthUrl();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>innerbalance | Home page</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="Assets/CSS/styles.css">
    <link rel="stylesheet" href="Assets/CSS/main.css">
    <!-- Boostrap CSS -->
    <!-- Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
<!-- font awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    .question {
        background: #28a745;
        color: white;
        padding: 15px;
        margin: 10px 0;
        border-radius: 5px;
        text-align: center;
    }
    .suggestion {
        display: none;
        background: #e9ecef;
        padding: 15px;
        border-radius: 5px;
        margin-top: 5px;
    }
</style>
<body class="bg-light">



    <!-- Header -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center justify-content-center" href="#" style="font-size: large; font-weight: 800; font-size: 1.8rem;"> <img src="Assets/Img/image.png" alt="" class="img-fluid me-2" style="width: 40px; height: auto;">Inner Balance</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto ms-auto my-2 my-lg-0 gap-4 navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="podcast.html">Podcast</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="youtube.html">Supportive videos</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li> -->
                </ul>
                <a href="https://tawk.to/chat/67cae1dbdbe5ba190c95bbec/1ilo84h3g" class="btn text-white" style="background-color: #71c55d;">Get Started</a>
            </div>
        </div>
    </nav>

    
    

    <div class="container-fluid hero" style="background: rgb(255,255,255);
background: linear-gradient(73deg, rgba(255,255,255,1) 8%, rgba(29, 180, 44, 0.253) 87%);">
        <div class="container px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-2 py-5">

                <div class="col-10 col-sm-8 col-lg-6">
                    <img src="Assets/Img/hero.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
                </div>

                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold text-body-emphasis lh-2 mb-3">Revolutionizing Mental Health to Digital</h1>
                    

         <p class="lead">Our platform offers personalized therapy sessions, resources, and support to help you navigate life's challenges.</p>

         <div class="col-12 col-md-8">
            <!-- Question 1 -->
            <div class="question" id="tex">
                Are you battling financial stress?
                <button class="btn btn-light btn-sm mt-2" onclick="toggleSuggestion('suggestion1')">Try This</button>
            </div>
            <div class="suggestion" id="suggestion1">
                <strong>Physical Actions:</strong>
                <ul>
                    <li><b>Create a Budget:</b> Spend 15 minutes listing your income and expenses to regain control.</li>
                    <li><b>Walk it Off:</b> Take a 20-minute walk to clear your mind from money worries.</li>
                    <li><b>Organize Your Space:</b> Declutter your desk or wallet for 10 minutes to feel more in charge.</li>
                </ul>
                <strong>YouTube Resource:</strong><br>
                <a href="https://www.youtube.com/watch?v=5p6C9qLRpKM" target="_blank">How I Overcame Financial Stress</a>
            </div>
            
            <!-- Question 2 -->
            <div class="question" id="tex">
                Is drug addiction overwhelming you?
                <button class="btn btn-light btn-sm mt-2" onclick="toggleSuggestion('suggestion2')">Try This</button>
            </div>
            <div class="suggestion" id="suggestion2">
                <strong>Physical Actions:</strong>
                <ul>
                    <li><b>Reach Out:</b> Call a friend or helpline (e.g., SAMHSA: 1-800-662-HELP) for 5 minutes.</li>
                    <li><b>Move Your Body:</b> Do a 10-minute workout to shift your focus.</li>
                    <li><b>Hydrate:</b> Drink a glass of water slowly to ground yourself.</li>
                </ul>
                <strong>YouTube Resource:</strong><br>
                <a href="https://www.youtube.com/watch?v=66cYcSak6nE" target="_blank">My Addiction Recovery Story</a>
            </div>

            <!-- Question 3 -->
            <div class="question" id="tex">
                Do you feel trapped by anxiety?
                <button class="btn btn-light btn-sm mt-2" onclick="toggleSuggestion('suggestion3')">Try This</button>
            </div>
            <div class="suggestion" id="suggestion3">
                <strong>Physical Actions:</strong>
                <ul>
                    <li><b>Grounding Technique:</b> Name 5 things you see, 4 you feel, 3 you hear for 2 minutes.</li>
                    <li><b>Stretch:</b> Do a 5-minute neck and shoulder stretch to release tension.</li>
                    <li><b>Cold Water Splash:</b> Splash your face with cold water to reset your nervous system.</li>
                </ul>
                <strong>YouTube Resource:</strong><br>
                <a href="https://www.youtube.com/watch?v=8vkYJfmcgXW" target="_blank">How I Manage My Anxiety</a>
            </div>

            <!-- Question 4 -->
            <div class="question" id="tex">
                Are you struggling with depression?
                <button class="btn btn-light btn-sm mt-2" onclick="toggleSuggestion('suggestion4')">Try This</button>
            </div>
            <div class="suggestion" id="suggestion4">
                <strong>Physical Actions:</strong>
                <ul>
                    <li><b>Get Moving:</b> Walk or dance for 10 minutes to boost endorphins.</li>
                    <li><b>Sunlight:</b> Sit by a window or outside for 15 minutes.</li>
                    <li><b>Small Win:</b> Make your bed or wash a dish to feel accomplished.</li>
                </ul>
                <strong>YouTube Resource:</strong><br>
                <a href="https://www.youtube.com/watch?v=2VRRx7Mtep8" target="_blank">Living with Depression</a>
            </div>
        </div>
    </div>
</div>



    
         
                <div class="container-main">

                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="text" id="text1">Are you battling financial stress?</div>
                                <div class="text" id="text2">Is drug addiction overwhelming you?</div>
                                <div class="text" id="text3">Do you feel trapped by anxiety?</div>
                                <div class="text" id="text4">Is loneliness breaking you down?</div>
                                <div class="text" id="text5">Are you struggling with depression?</div>
                                <div class="text" id="text6">Does work stress exhaust you?</div>
                                <div class="text" id="text7">Are family issues weighing on you?</div>
                                <div class="text" id="text8">Is sleep loss affecting your mind?</div>
                                <div class="text" id="text9">Do social pressures feel unbearable?</div>
                                <div class="text" id="text10">Are you haunted by past trauma?</div>
                            </div>
                        </div>
                    </div>
                    <br><br><br>
                    <p class="lead">If you're facing any of these challenges or more, talk to our AI therapist via text or voice, chat with an agent, or explore podcasts and supportive videos. </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a type="button" class="btn text-white btn-lg px-4 me-md-2" style="background-color: #71c55d;" href="https://elevenlabs.io/app/talk-to?agent_id=Qn77CmpLjrTZtdWb4A5v">Voice Chat</a>
                        <a href="https://tawk.to/chat/67cae1dbdbe5ba190c95bbec/1ilo84h3g" type="button" class="btn btn-outline-secondary btn-lg px-4">Text Chat</a>

                        <a href="podcast.html" type="button" class="btn btn-outline-secondary btn-lg px-4">Listen to our Podcast</a>
                    </div>
                    

                    <div class="d-grid gap-2" style="margin-top: 20px; width: 300px;">
            
                        <p class="mb-2">Do you want to book an appointment with a Mental Health Specialist? Click the button below if yes:</p>
                        <a href="<?=$url?>" type="button" class="btn btn-success btn-sm px-3 py-2" style="width: 70%;">Book Appointment</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>








<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="d-flex align-items-center">
                    <img src="Assets/Img/image.png" alt="Logo" class="img-fluid me-2" style="width: 30px; height: auto;"> 
                    Inner Balance
                </h5>
                <p class="text-muted">Empowering mental wellness through innovative AI-driven therapy solutions.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Podcast</a></li>
                    <li><a href="#listen-music"></a></li>
                    <!-- <li><a href="#">Contact</a></li> -->
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Contact Us</h5>
                <p class="text-muted">Email:innerbalance254@gmail.com</p>
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank" class="icon facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com" target="_blank" class="icon twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com" target="_blank" class="icon instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://linkedin.com" target="_blank" class="icon linkedin"><i class="fab fa-linkedin-in"></i></a>
                  </div>         
                   </div>
        </div>
        <div class="row">
            <div class="col-12 text-center pt-3 border-top">
                <p class="text-muted mb-0">© 2025 Inner Balance. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>


    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/67cae1dbdbe5ba190c95bbec/1ilo84h3g';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->


    <!-- Boostrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="dist/js/bootstrap.bundle.min.js"></script>

    <elevenlabs-convai agent-id="Qn77CmpLjrTZtdWb4A5v"></elevenlabs-convai><script src="https://elevenlabs.io/convai-widget/index.js" async type="text/javascript"></script>


    <script src="Assets/js/script.js"></script>
    <script>
        function toggleSuggestion(suggestionId) {
            var suggestion = document.getElementById(suggestionId);
            suggestion.style.display = (suggestion.style.display === "block") ? "none" : "block";
        }
    </script>
</body>

</html>