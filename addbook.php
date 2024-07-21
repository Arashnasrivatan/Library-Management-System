<?php
include("db.php");
date_default_timezone_set("Asia/Tehran");
mysqli_set_charset($db, 'utf8');

    if(!isset($_COOKIE['namefull']) || !isset($_COOKIE['username']) || !isset($_COOKIE['email']) || !isset($_COOKIE['password'])){
        header("Location:loginregister.php");
      }
$bookimage ='';
if(isset($_SESSION['bookimg2'])){
$bookimage2 = $_SESSION['bookimg2'];
}
if(isset($_POST["submit_image"])) {

    $target_dir = "assets/uploads";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    $bookimage= random_int(10000000,99999999).'.jpg';

    $_SESSION['bookimg2'] = "assets/uploads".$bookimage;
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "assets/uploads".$bookimage)) {

    } else {
        header('Location: addbook.php?res=Upload failed.');
    }
    
}else{
    $_SESSION['bookimg2'] = "assets/uploadsnotfound.png";
}
 
if(isset($_POST['bookname']) && isset($_POST['Author']) && isset($_POST['bookpage'])) {
    $bookname = $_POST['bookname'];
    $author = $_POST['Author'];
    $bookpage = $_POST['bookpage'];
    $stmt = $db->prepare("INSERT INTO books (bookimg, bookname, Author, bookpage) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $bookimage2, $bookname, $author, $bookpage);
    
    if ($stmt->execute()) {
        $_SESSION['bookimg2'] = '';
        header('Location: addbook.php?res=The book has been successfully added and can be displayed and reserved after confirmation');
    } else {
        error_log('MySQL error: ' . $stmt->error);
        header('Location: addbook.php?res=The book could not be added, please try again in a few minutes');
    }
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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/res.css">
    <title>arash library</title>
</head>
<body style="overflow:hidden;">
<?php include('helpers/header.php'); ?>

<?php
    if(isset($_GET['res'])){
      echo'<div style="margin:10px auto;" data-aos="fade-up" class="alert bgc mt-5 text-center w-50">'.htmlspecialchars($_GET['res']).'</div>';
    }
    ?>
    <div data-aos="fade-down" class="fs-1 fw-semibold mt-5 w-100 text-center text-white">ADD BOOK</div>


    <div data-aos="flip-right" data-aos-duration="1500" class="addbookmain w-100 mt-5">
        <div class="addbook w-75">
    <?php 

if (strlen($bookimage)>6){

echo'
<div class="imgbookpr">
<img style="width: auto; max-height: 100px; border-radius:8px;" src="assets/uploads'.$bookimage.'">
</div>
';

}else{
    echo '
    <form action="addbook.php" method="post" enctype="multipart/form-data" class="formimg d-flex justify-content-between w-50"> 
    <input required style="width:250px;" class="form-control" type="file" name="fileToUpload" id="fileToUpload">
    <input required type="submit" class="btn uploadbtn bgc text-black btn-warning" value="UPLOAD" name="submit_image">
  </form>
  ';
}


?>
<form action="addbook.php" class="formaddbook" method="post">
<div class="inputdiv mt-5">
<label class="px-2 text-white" for="bookname">Enter book name</label>
<input id="bookname" type="text" maxlength="20" name="bookname" class="form-control px-3" required placeholder="free butterflies">
</div>
<div class="inputdiv mt-5">
<label for="author" class="px-2 text-white">Enter author name</label>
<input id="author" type="text" maxlength="20" name="Author" class="form-control px-3" required placeholder="Robert Murph">
</div>
<div class="inputdiv mt-5 ">
<label class="px-2 text-white" for="page">Enter page number</label>
<input id="page" type="int" onkeydown="handleSpace(event)" maxlength="20" name="bookpage" class="form-control px-3" required placeholder="200">
</div>



<button type="submit" class="btn textcenter mt-4 bgc text-black btn-warning" >UPLOADS</button>


</div>
</form>
    </div>

<script src="https://arash456.s3.ir-thr-at1.arvanstorage.ir/nav.js?versionId="></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  AOS.init();
        
  document.getElementById("page").addEventListener("input", function() {
            var userInput = this.value;
            if (isNaN(userInput)) {
                alert("Please enter only numbers");
                this.value = "";
            }
        });
 
function handleSpace(event) {
    if (event.keyCode === 32) {

                event.preventDefault();
                return false;
            }
        }
    </script>
</body>
</html>