<?php
include ('db.php');

$error = isset($_GET['error']);
$okay = isset($_GET['okay']);

if(isset($_COOKIE['namefull']) || isset($_COOKIE['username']) || isset($_COOKIE['email']) || isset($_COOKIE['password'])){
    header("Location:index.php");
  }
?>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/loginsignup.css">
    <title>login</title>
</head>
<body>
<div class="container">
        <div class="forms">
            <!-- Login -->
            <div class="form login">
                <span class="title">Login</span>
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
                <form action="logreg.php" method="post">
                    <div class="input-field">
                        <input value="<?php if(isset($_GET['username'])){ echo $_GET['username'];}?>" type="text" name="username" id="usernameinp1" placeholder="Enter Your Username" required>
                        <i class="uil uil-user icon"></i>
                    </div>
                    <div class="input-field">
                        <input value="<?php if(isset($_GET['password'])){ echo $_GET['password'];}?>" type="password" name="password" id="passinp1" class="password" placeholder="Enter Your Password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="checkbox-text">
                        <a href="forgotpass.php" class="text">Forgot Your Password?</a>
                    </div>
                    <div class="input-field button">
                        <input name="loginsubmit" type="submit" value="Login">
                    </div>
                </form>
                <div class="login-signup">
                <span class="text">Not registered yet?
                         <a href="#" class="text signup-link">Sign up now</a>
                    </span>
                </div>
            </div>
            <!--Sign up-->
            <div class="form signup" id="signup">
                <span class="title">Sign up</span>
                <?php if (isset($_GET['error1'])) { ?>
	 		<div class="alert alert-warning mt-3 text-center" role="alert">
			  <?php echo htmlspecialchars($_GET['error1']);?> 
			</div>
			<?php } 
            if (isset($_GET['okay1'])) { ?>
	 		<div class="alert alert-success mt-3 text-center" role="alert">
			  <?php echo htmlspecialchars($_GET['okay1']);?> 
			</div>
			<?php } 
if(isset($_GET['okay1']) && $_GET['okay1'] == 'You have successfully registered'){ ?>
        <script>
        let sabtnamemovafagh = setTimeout(function() {
        localStorage.removeItem("containerActive");
        window.location.href = "loginregister.php";
        clearTimeout(sabtnamemovafagh);
        }, 2000);
        </script>
<?php } ?>

                <form action="logreg.php" method="POST">
                    <div class="input-field">
                        <input value="<?php if(isset($_GET['namefull'])){ echo $_GET['namefull'];}?>" type="text" id="namefull" name="namefull"
                        placeholder="Enter your first and last name" required>
                        <i class="uil uil-user"></i>
                    </div>
                    <div class="input-field">
                        <input maxlength="20" value="<?php if(isset($_GET['username1'])){ echo $_GET['username1'];}?>"type="text" name="username1" id="usernameinp" placeholder="Enter your username" required>
                        <i class="uil uil-user icon"></i>
                    </div>
                    <div class="input-field">
                        <input value="<?php if(isset($_GET['email'])){ echo $_GET['email'];}?>" type="email" name="email" class="email" id="emailinp" placeholder="Enter your email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input maxlength="20" value="<?php if(isset($_GET['password1'])){ echo $_GET['password1'];}?>" type="password" name="password1" class="password" id="passinp" placeholder="Enter your password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <?php if(isset($_GET['okay1'])&& $_GET['okay1']=='A confirmation code has been emailed to you' ||isset($_GET['error1'])&&$_GET['error1']=='verify code is incorrect try again'){ ?>
                        <div class="input-field">
                        <input maxlenght="4" type="text" name="code" class="code" placeholder="Enter The Code" required>
                        <i class="uil uil-lock icon"></i>
                    </div>
                        <?php } ?>
                    <div class="input-field button">
                        <input id="signupsubmit" type="submit" name="signupsubmit" value="Sign up">
                    </div>
                </form>
                <div class="login-signup">
                <span class="text">Do you have an account?
                         <a href="#" class="text login-link">Login</a>
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
                    })
                }
            }) 
        })
    })
    document.addEventListener("DOMContentLoaded", function() {
    const container = document.querySelector(".container");
    const isActive = localStorage.getItem("containerActive");

    if (isActive === "true") {
        container.classList.add("active");
    }

    signUp.addEventListener("click", function() {
        container.classList.add("active");
        localStorage.setItem("containerActive", "true");
    });

    login.addEventListener("click", function() {
        container.classList.remove("active");
        localStorage.removeItem("containerActive");
    });
});

document.addEventListener('keydown', function(event) {
    var targetElement = event.target;
    var targetId = targetElement.getAttribute('id');

    if (targetId !== "namefull" && event.keyCode === 32) { 
        event.preventDefault(); 
        return false; 
    }
});
    </script>
</body>
</html>