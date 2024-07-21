<?php
include ("db.php");
$email='';
$error='';
$okay='';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


    if(isset($_COOKIE['namefull']) || isset($_COOKIE['username']) || isset($_COOKIE['email']) || isset($_COOKIE['password'])){
        header("Location:index.php");
      }
      // Database connection assumed to be established as $db
      
      // Function to generate a random string for the password
      function generateRandomString($length = 8) {
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          return $randomString;
      }
      
      if (isset($_POST['submit'])) {
          if (isset($_POST['email'])) {
              $email = trim($_POST['email']);
          }
      
          $error = '';
          $okay = '';
      
          // Check if email exists
          $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
          $stmt->bind_param('s', $email);
          $stmt->execute();
          $result_check = $stmt->get_result();
      
          if ($result_check->num_rows == 0) {
              $error = 'Email does not exist';
          } else {
              // Generate a new random password
              $rand = generateRandomString();
      
              // Update user password
              $stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
              $stmt->bind_param('ss', $rand, $email);
              if ($stmt->execute()) {
                  // Send the new password via email
                  require './PHPMailer/src/Exception.php';
                  require './PHPMailer/src/PHPMailer.php';
                  require './PHPMailer/src/SMTP.php';
      
                  $subject = 'Password Reset Request';
                  $message = "<h1>Your new password is: $rand</h1>";
      
                  $mail = new PHPMailer(true);
                  $mail->isSMTP();
                  $mail->Host = 'smtp.gmail.com';
                  $mail->SMTPAuth = true;
                  $mail->Username = 'your-email@gmail.com'; // Securely manage credentials
                  $mail->Password = 'your-email-password'; // Securely manage credentials
                  $mail->Port = 465;
                  $mail->SMTPSecure = 'ssl';
                  $mail->isHTML(true);
                  $mail->setFrom('your-email@gmail.com');
                  $mail->addAddress($email);
                  $mail->Subject = $subject;
                  $mail->Body = $message;
      
                  if ($mail->send()) {
                      $okay = '<div class="alert alert-success mt-2 text-center"><b>Your password has been changed and emailed to you</b></div>';
                  } else {
                      $error = 'There was a problem sending the email';
                  }
              } else {
                  $error = 'There was a problem updating the password';
              }
          }
      }
      ?>
      
      <!DOCTYPE html>
      <html lang="en" dir="ltr">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
          <link rel="stylesheet" href="assets/css/loginsignup.css">
          <title>Forgot Password</title>
      </head>
      <body>
      <div class="container">
          <div class="forms" style="height:400px;">
              <div class="form login">
                  <span class="title fs-4">Forgot your password?</span>
                  <?php 
                  if (!empty($error)) {
                      echo '<div class="alert alert-warning mt-3 text-center"><b>' . htmlspecialchars($error) . '</b></div>';
                  }
                  if (!empty($okay)) {
                      echo $okay;
                  }
                  ?>
                  <form action="forgotpass.php" method="post">
                      <div class="input-field">
                          <input id="emailinp" value="<?php if (isset($_POST['email'])) { echo htmlspecialchars($email); } ?>" type="email" name="email" placeholder="Enter your email" required>
                          <i class="uil uil-envelope icon"></i>
                      </div>
                      <div class="input-field button">
                          <input name="submit" type="submit" value="SUBMIT">
                      </div>
                  </form>
                  <div class="login-signup">
                      <span class="text">Do you have an account?
                          <a href="loginregister.php" class="text signup-link">Login</a>
                      </span>
                  </div>
              </div>
          </div>
      </div>
      
      <script>
          document.addEventListener('keydown', function(event) {
              if (event.keyCode === 32) { 
                  event.preventDefault(); 
              }
          });
      </script>
      </body>
      </html>
      