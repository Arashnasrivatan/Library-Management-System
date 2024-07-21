<?php
include ("db.php");
$username="";
$password= "";
$error ='';

if(isset($_COOKIE['namefull']) || isset($_COOKIE['username']) || isset($_COOKIE['email']) || isset($_COOKIE['password'])){
  header("Location:index.php");
}

// Database connection assumed to be established as $db

if (isset($_POST['loginsubmit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize input
    $username = trim($username);
    $password = trim($password);

    // Check for errors
    $error = '';

    // Check if username exists
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result_check2 = $stmt->get_result();

    // Check if password exists
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result_check3 = $stmt->get_result();

    if ($result_check2->num_rows == 0 || $result_check3->num_rows == 0) {
        $error = 'The username or password is wrong';
    }

    if (strlen($password) < 8 || strlen($password) > 20) {
        $error = 'Password must be between 8 and 20 characters';
    }

    if (strlen($username) < 8 || strlen($username) > 20) {
        $error = 'Username must be between 8 and 20 characters';
    }

    if (empty($error)) {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $sql = $stmt->get_result();

        if ($row = $sql->fetch_assoc()) {
            // Set cookie expiration time to 1 month
            $cookieExpiration = time() + 2592000; // 2592000 seconds = 1 month
            setcookie('id', $row['id'], $cookieExpiration, '/');
            setcookie('namefull', $row['namefull'], $cookieExpiration, '/');
            setcookie('username', $row['username'], $cookieExpiration, '/');
            setcookie('email', $row['email'], $cookieExpiration, '/');
            // Note: Storing hashed passwords in cookies is not secure. Remove this if possible.
            setcookie('password', $row['password'], $cookieExpiration, '/');
            header("Location: loginregister.php?okay=You have successfully logged in");
            exit;
        } else {
            header("Location: loginregister.php?error=$error&username=$username");
            exit;
        }
    } else {
        header("Location: loginregister.php?error=$error&username=$username");
        exit;
    }
}

if (isset($_POST['signupsubmit'])) {
    $namefull = $_POST['namefull'];
    $username1 = $_POST['username1'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];

    // Sanitize input
    $namefull = trim($namefull);
    $username1 = trim($username1);
    $email = trim($email);
    $password1 = trim($password1);

    // Check for errors
    $error1 = '';

    if (strlen($password1) < 8 || strlen($password1) > 20) {
        $error1 = 'Password must be between 8 and 20 characters';
    }

    if (strlen($username1) < 8 || strlen($username1) > 20) {
        $error1 = 'Username must be between 8 and 20 characters';
    }

    if (strlen($namefull) < 3 || strlen($namefull) > 50) {
        $error1 = 'Please enter a valid name';
    }

    // Check if email is already used
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result_check = $stmt->get_result();
    if ($result_check->num_rows > 0) {
        $error1 = 'Email already exists, please try another email';
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
        $error1 = 'Please enter a valid Gmail address';
    }

    if (empty($error1)) {
        // Check if username exists
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username1);
        $stmt->execute();
        $result_check = $stmt->get_result();
        if ($result_check->num_rows > 0) {
            $error1 = 'Username already exists, please try another username';
        }

        if (empty($error1)) {
            // Insert new user
            $stmt = $db->prepare("INSERT INTO users (namefull, username, password, email) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $namefull, $username1, $password1, $email);
            $stmt->execute();

            // Insert verification code
            $code = random_int(1000, 9999);
            $stmt = $db->prepare("INSERT INTO verifycode (email, verifycode) VALUES (?, ?)");
            $stmt->bind_param('si', $email, $code);
            $stmt->execute();

            // Send email with PHPMailer
            require './PHPMailer/src/Exception.php';
            require './PHPMailer/src/PHPMailer.php';
            require './PHPMailer/src/SMTP.php';

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Use a secure method to store and retrieve credentials
            $mail->Password = 'your-email-password'; // Use a secure method to store and retrieve credentials
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom('your-email@gmail.com');
            $mail->addAddress($email);
            $mail->Subject = 'Confirmation Code';
            $mail->Body = "<h1>The code is $code</h1>";

            if ($mail->send()) {
                header("Location: loginregister.php?okay1=A confirmation code has been emailed to you&namefull=$namefull&username1=$username1&email=$email&password1=$password1");
                exit;
            } else {
                $error1 = 'Failed to send confirmation code';
            }
        }
    }

    if ($error1 !== '') {
        header("Location: loginregister.php?error1=$error1&namefull=$namefull&username1=$username1&email=$email&password1=$password1");
        exit;
    }
}

if (isset($_POST['email']) && isset($_POST['code']) && strlen($_POST['code']) == 4) {
    $code = $_POST['code'];
    $email = $_POST['email'];

    // Fetch the most recent verification code
    $stmt = $db->prepare("SELECT verifycode FROM verifycode WHERE email = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $code_org = $result->fetch_assoc()['verifycode'];

    if ($code_org == $code) {
        // Proceed with registration
        $stmt = $db->prepare("INSERT INTO users (namefull, username, password, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $namefull, $username1, $password1, $email);
        $stmt->execute();

        header("Location: loginregister.php?okay1=You have successfully registered&namefull=$namefull&username1=$username1&email=$email&password1=$password1");
        exit;
    } else {
        header("Location: loginregister.php?error1=Verification code is incorrect. Please try again.&namefull=$namefull&username1=$username1&email=$email&password1=$password1");
        exit;
    }
}
?>
