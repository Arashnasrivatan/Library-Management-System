<?php
$db = mysqli_connect('localhost','root','','library_system');
$error ='';
if (!isset($_COOKIE['adminlogin']) && !isset($_COOKIE['adminpass'])) {
    header('Location: ../index.php');
}

if (isset($_POST['adminsubmit'])) {
    $adminlogin = trim($_POST['adminlogin']);
    $adminpass = trim($_POST['adminpass']);
    $error = '';

    // Validate inputs
    if (strlen($adminpass) < 5 || strlen($adminpass) > 15) {
        $error = "Admin Password Must be between 5 and 15 characters";
    }
    if (strlen($adminlogin) < 5 || strlen($adminlogin) > 15) {
        $error = "Admin Username Must be between 5 and 15 characters";
    }

    if (empty($error)) {
        // Check if the new username is already taken
        $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param('s', $adminlogin);
        $stmt->execute();
        $result_check = $stmt->get_result();

        if (mysqli_num_rows($result_check) > 0) {
            $error = 'The username you are attempting to use is already in use.';
        }

        if (empty($error)) {
            // Update admin details
            $stmt = $db->prepare("UPDATE admins SET username = ?, password = ? WHERE username = ?");
            $stmt->bind_param('sss', $adminlogin, $adminpass, $_COOKIE['adminlogin']);

            if ($stmt->execute()) {
                // Update cookies
                setcookie('adminlogin', $adminlogin, time() + (86400 * 30), "/");
                setcookie('adminpass', $adminpass, time() + (86400 * 30), "/");
                header('Location: ../index.php?res=Admin username or password has been updated successfully');
                exit();
            } else {
                header('Location: ../index.php?res=There was a problem updating, try again later');
                exit();
            }
        }
    }

    if (!empty($error)) {
        header('Location: ../index.php?res=' . urlencode($error));
        exit();
    }
}

if (isset($_POST['addsubmit'])) {
    $adminusername = trim($_POST['adminusername']);
    $adminpassword = trim($_POST['adminpassword']);
    $error = '';

    // Validate inputs
    if (strlen($adminpassword) < 5 || strlen($adminpassword) > 15) {
        $error = "Admin Password Must be between 5 and 15 characters";
    }
    if (strlen($adminusername) < 5 || strlen($adminusername) > 15) {
        $error = "Admin Username Must be between 5 and 15 characters";
    }

    if (empty($error)) {
        // Check if the new username is already taken
        $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param('s', $adminusername);
        $stmt->execute();
        $result_check = $stmt->get_result();

        if (mysqli_num_rows($result_check) > 0) {
            $error = 'The username you are attempting to use is already in use.';
        }

        if (empty($error)) {
            // Insert new admin
            $stmt = $db->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
            $stmt->bind_param('ss', $adminusername, $adminpassword);

            if ($stmt->execute()) {
                header('Location: ../index.php?res=New admin added successfully');
                exit();
            } else {
                header('Location: ../index.php?res=There was a problem adding admin, try again later');
                exit();
            }
        }
    }

    if (!empty($error)) {
        header('Location: ../index.php?res=' . urlencode($error));
        exit();
    }
}
?>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">Arash library</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul style="padding:5px;" class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../index.php">Back to library</a></li>
                        <li><a class="dropdown-item" href="helpers/logout.php">Log out from admin panel</a></li>
                        <li class="border rounded-1 p-1 mt-1">
                        <form action="helpers/header.php" method="post">
                        <label for="username" class="px-2 mt-1">Admin Username</label>
                        <input maxlength="15" type="text" class="form-control mt-1" id="username" name="adminlogin" value="<?php echo $_COOKIE['adminlogin']; ?>">
                        <label for="pass" class="px-2 mt-2">Admin Password</label>
                        <input maxlength="15" type="text" class="form-control mt-1" id="pass" name="adminpass" value="<?php echo $_COOKIE['adminpass']; ?>">
                        <button class="btn bgc btn-warning w-100 mt-2" name="adminsubmit">UPDATE</button>
                        </form>
                        </li>
                    </ul>
                    </ul>
                </li>
            </ul>
            
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Main</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-hourglass-start"></i></div>
                                Books status
                            </a>
                            <div class="sb-sidenav-menu-heading">info</div>
                            <a class="nav-link" href="books.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                               Books
                            </a>
                            <a class="nav-link" href="users.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                               users
                            </a>
                            <div class="sb-sidenav-menu-heading">ADD</div>
                            <a data-bs-toggle="modal" data-bs-target="#addadmin" class="nav-link">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-plus"></i></div>
                               Add Admin
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged:</div>
                        <?php echo $_COOKIE['adminlogin']; ?>
                    </div>
                </nav>
                </div>

                <div class="modal fade" id="addadmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Admin</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="helpers/header.php" method="post">
        <label for="password" class="form-label mt-2">admin username</label>
      <input type="text" class="form-control text-center" id="adminusername" name="adminusername" required>
      <label for="password" class="form-label mt-2">admin password</label>
      <input type="text" class="form-control text-center" id="adminpassword" name="adminpassword" required>
        
      </div>
      <div class="modal-footer">
        <button type="submit" name="addsubmit" class="btn btn-warning text-center bgc w-100">ADD</button>
      </div>
      </form>
    </div>
  </div>
</div>

                <script>
        document.addEventListener('keydown', function(event) {
    if (event.keyCode === 32) { 
        event.preventDefault(); 
        return false; 
    }
});
    </script>