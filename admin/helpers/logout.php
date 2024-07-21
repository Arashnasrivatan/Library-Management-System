<?php
if(isset($_COOKIE['adminlogin']) && isset($_COOKIE['adminpass'])){
setcookie('adminlogin', '', -1, '/');
setcookie('adminpass', '', -1, '/');
header("Location: ../login.php");
exit;
}else{
    header("Location: ../index.php");
}
?>