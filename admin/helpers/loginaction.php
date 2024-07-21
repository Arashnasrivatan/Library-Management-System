<?php
include ("../../db.php");
$username="";
$password= "";
$error ='';

if (isset($_POST['loginsubmit'])) {

    // Get and sanitize user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $error = '';

    // Input validation
    if (strlen($password) < 5 || strlen($password) > 20) {
        $error = 'Password must be between 5 and 20 characters';
    }

    if (strlen($username) < 5 || strlen($username) > 20) {
        $error = 'Username must be between 5 and 20 characters';
    }

    if (empty($error)) {
        $stmt = $db->prepare("SELECT * FROM admins WHERE username = ? and password = ?");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
                // Set session and cookies
                $_SESSION['adminlogin'] = $row['username'];
                $cookieExpiration = time() + 2592000; // 1 month

                setcookie('adminlogin', $row['username'], $cookieExpiration, '/');
                // Note: You shouldn't store plain passwords in cookies
                setcookie('adminpass', $row['password'], $cookieExpiration, '/');

                header("Location: ../login.php?okay=" . urlencode('You have successfully logged in'));
                exit();
            } else {
                $error = 'The username or password is incorrect';
            }
        } else {
            $error = 'The username or password is incorrect';
        }
    }

    if ($error != '') {
        header("Location: ../login.php?error=" . urlencode($error) . "&username=" . urlencode($username));
        exit();
    }

?>