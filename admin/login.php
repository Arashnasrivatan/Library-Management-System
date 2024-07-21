<?php
include ('../db.php');

$error = isset($_GET['error']);
$okay = isset($_GET['okay']);

if(isset($_COOKIE['adminlogin']) || isset($_COOKIE['adminpass'])){
    header("Location:index.php");
}
?>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
    <title>login</title>
</head>
<body>
<div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">ADMIN LOGIN</span>
                <?php if (isset($_GET['error'])) { ?>
	 		<div class="alert alert-warning mt-3 text-center" role="alert">
			  <?php echo htmlspecialchars($_GET['error']);?> 
			</div>
			<?php } 
            if (isset($_GET['okay'])) { ?>
	 		<div class="alert alert-success mt-3 text-center" role="alert">
			  <?php echo htmlspecialchars($_GET['okay']);
              echo'<meta http-equiv="refresh" content="3; url=index.php">';?> 
			</div>
			<?php } 
                ?>
                <form action="helpers/loginaction.php" method="post">
                     <div class="input-field">
                         <input value="<?php if(isset($_GET['username'])){ echo $_GET['username'];}?>" type="text" name="username" id="usernameinp1" placeholder="Enter your username" required>
                         <i class="uil uil-user"></i>
                     </div>
                     <div class="input-field">
                         <input value="<?php if(isset($_GET['password'])){ echo $_GET['password'];}?>" type="password" name="password" id="passinp1" class="password" placeholder="Enter your password" required>
                         <i class="uil uil-lock icon"></i>
                         <i class="uil uil-eye-slash showHidePw"></i>
                     </div>
                     <div class="input-field button">
                         <input name="loginsubmit" type="submit" value="login">
                     </div>
                 </form>
                 <div class="login-signup">
                     <span class="text">Username: admin Password: admin
                         <br><a href="../index.php" class="text signup-link">Back to library</a>
                    </span>
                </div>
            </div>

        </div>
    </div>

    <script>
        const container = document.querySelector(".container"),
      pwShowHide = document.querySelectorAll(".showHidePw"),
      pwFields = document.querySelectorAll(".password"),
      signUp = document.querySelector(".signup-link"),
      signupsubmit = document.getElementById("signupsubmit"),
      login = document.querySelector(".login-link");
    pwShowHide.forEach(eyeIcon =>{
        eyeIcon.addEventListener("click", ()=>{
            pwFields.forEach(pwField =>{
                if(pwField.type ==="password"){
                    pwField.type = "text";
                    pwShowHide.forEach(icon =>{
                        icon.classList.replace("uil-eye-slash", "uil-eye");
                    })
                }else{
                    pwField.type = "password";
                    pwShowHide.forEach(icon =>{
                        icon.classList.replace("uil-eye", "uil-eye-slash");
                    });
                }
            });
        });
    });

    document.addEventListener('keydown', function(event) {
    if (event.keyCode === 32) { 
        event.preventDefault(); 
        return false; 
    }
});
    </script>
</body>
</html>