<?php
include('../db.php');

if(isset($_POST['submitres'])){
     $bookid = $_POST['id'];
     $reservedby = $_COOKIE['namefull'];
     $today_date = date("Y-m-d");
     $endres = isset($_POST['endres']) ? $_POST['endres'] : $today_date;
     $sql = mysqli_query($db, "UPDATE `books` SET `reserved`='2', `endres`='$endres', `reservedby`='$reservedby' WHERE `bookid`='$bookid' ") ;
     if($sql){ $res = 'reserved successfully'; }else{ $res = 'There is a problem in reserving the book';}
     header('Location: ../books.php?res='.$res.'');
}else{
     header('Location: ../index.php');
}
?>