<?php
$db = mysqli_connect('localhost','root','','library_system');
$error='';
if(isset($_POST['profilesubmit'])){
  $namefull = $_POST['namefull'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];


if (strlen($password)<8) {
  $error = "Password must be more than 8 words";
}

$sql_check = "SELECT * FROM users WHERE `username` = '$username'";
        $result_check = mysqli_query($db, $sql_check);
       
        if (mysqli_num_rows($result_check) > 0) {
            $error = 'Username is taken.';
        }
       
if (strlen($username)<8 ||strlen($username)>20) {
  $error = "Username must be more than 8 words";
 }
 
 if($error <> '') {
  header('Location: ../index.php?error='.$error.'');

}

if($error == '' && isset($_POST['username']) && isset($_POST['password'])){
  $profilesql = mysqli_query($db, "UPDATE `users` SET `username`='$username', `password`='$password' WHERE `email`='$email' ");
  if($profilesql){
    $id=$_COOKIE['id'];
setcookie('id', $id, $cookieExpiration, '/');
setcookie('namefull', $namefull, $cookieExpiration, '/');
setcookie('username', $username, $cookieExpiration, '/');
setcookie('email', $email, $cookieExpiration, '/');
setcookie('password', $password, $cookieExpiration, '/');
header("Location: ../index.php?okay=Your profile has been successfully updated");
  }
}


}

?>
    
    
    
    
    
    <html>
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
      <nav class="nav">
        <a href="index.php" class="logo">Pixel Library</a>

      <div class="search-box">
      <form action="search.php" method="post">
        <button style="border:none;"><i class="uil uil-search search-icon"></i></button>
        <input required name="search" id="searchinp" type="text" placeholder="Search . . ." />
        </form>
      </div>
      
      
      <ul class="nav-links" style="margin-bottom:0 !important;">
        <i class="uil uil-times navCloseBtn"></i>
        <li><a href="index.php">Home</a></li>
        <li><a href="books.php">Books</a></li>
        <li><a href="reservedb.php">Reserved Books</a></li>
        <li><a href="addbook.php">Add Book</a></li>
        <li><a href="admin/login.php">Admin Panel</a></li>
        <li><a href=""></a></li>
        <div class="dropdown-center">
  <a class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user"></i></a>
  <ul class="dropdown-menu">
    <li><button id="profile" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-address-card"></i> Profile</button></li>
    <li><a class="dropdown-item" href="helpers/logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-flip-horizontal" style="color: #f00f0f;"></i> Logout</a></li>
  </ul>
</div>
      </ul>
      <i class="uil uil-search search-icon" id="searchIcon"></i>
      <i class="uil uil-bars navOpenBtn"></i>

      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="padding:5px !important;">
        <img class="profilegif" src="assets/img/profilebook.gif" alt="profilegif"><span class="modal-title fs-4" id="staticBackdropLabel">Profile</span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="helpers/header.php" method="post">
      <label for="namefull" class="form-label">Full Name (readonly)</label>
      <input type="text" class="form-control text-center" id="namefull" name="namefull" readonly value="<?php echo $_COOKIE['namefull']; ?>" required>
      <label for="username" class="form-label mt-2">Username</label>
      <input onkeydown="handleSpace(event)" type="text" class="form-control text-center" id="username" name="username" value="<?php echo $_COOKIE['username']; ?>" required>
      <label for="email" class="form-label mt-2">Email (readonly)</label>
      <input onkeydown="handleSpace(event)" type="text" class="form-control text-center" readonly id="email" name="email" value="<?php echo $_COOKIE['email']; ?>" required>
      <label for="password" class="form-label mt-2">Password</label>
      <input onkeydown="handleSpace(event)" type="text" class="form-control text-center" id="password" name="password" value="<?php echo $_COOKIE['password']; ?>" required>
      </div>
      <div class="modal-footer">
        <button type="submit" name ="profilesubmit" class="btn bgc btn-warning w-100">Update Profile</button>
        <?php if (isset($_GET['error'])) { ?>
	 		<div class="alert alert-warning mt-2 w-100 text-center" role="alert">
			  <?php echo htmlspecialchars($_GET['error']);?> 
			</div> 
      <?php } if (isset($_GET['okay'])) { ?>
	 		<div class="alert alert-success mt-2 w-100 text-center" role="alert">
			  <?php echo htmlspecialchars($_GET['okay']);?> 
			</div>
			<?php } ?>
      </div>
    </form>
    </div>
  </div>
</div>
    </nav>
    </body>
    </html>
    <script>
      function handleSpace(event) {
    if (event.keyCode === 32) {

                event.preventDefault();
                return false;
            }
        }
    </script>
    
