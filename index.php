<?php
include_once('helpers/checkres.php');
include('db.php');
if(!isset($_COOKIE['namefull']) || !isset($_COOKIE['username']) || !isset($_COOKIE['email']) || !isset($_COOKIE['password'])){
  header("Location:loginregister.php");
}
?>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.0.93/build/spline-viewer.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/res.css">
    <title>arash library</title>
</head>
<body style="background: url('assets/img/mainbackground.gif');
background-repeat: no-repeat;
  background-size: cover;
  backdrop-filter: blur(2px);
  background-position: center;
display: flex;
align-items: center;
flex-direction: column;
overflow: hidden !important;">
<?php include('helpers/header.php'); ?>


    <div class="homemaindiv">
        <div class="hometitle" data-aos="fade-up">
            <p class="fw-bold titlemain text-white">Welcome to Arash Library</p>
            <span class="fs-5 fw-semibold mb-4 hometitle2 ">You can reserve the book you want from Pixel library.</span>
            <button class="btn btn-outline-light fw-semibold">Get started now</button>
        </div>
        <div class="homeimg" data-aos="fade-right">
            <img src="assets/img/book.gif">
        </div>
    </div>
<script src="https://arash456.s3.ir-thr-at1.arvanstorage.ir/nav.js?versionId="></script>
<script>
  AOS.init();
var currentURL = window.location.href;

if(currentURL.includes("error")) {

          setTimeout(function() {
            let profile = document.getElementById("profile");
            profile.click();
          }, 1000);
}

if(currentURL.includes("okay")) {

setTimeout(function() {
  let profile = document.getElementById("profile");
  profile.click();
}, 1000);
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
