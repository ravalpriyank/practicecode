<?php require_once('connection.php'); ?>
<?php require_once('layouts/core/languageset.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: auth-login.php");
    exit;
}
$currentuser = $_SESSION['username'];


$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = $_POST["password"];
    }

    $username = ucwords(strtolower($_POST["username"]));
    $password = $_POST["password"];
    $sql = "select * from `users` where username = '$username' AND password ='$password'";
    $result = mysqli_query($conn2, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $loginuser = $_SESSION['loggedin'];
        $_SESSION['username'] = $username;
        header("location: index.php");
    } else {
        $password_err = "Credentials are Incorrect";
    }
}
?>


<head>


    <title>Lock Screen | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>

</head>

<?php require_once('layouts/main/body.php'); ?>
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-12 col-lg-12 col-md-12">
                <div class="auth-bg pt-md-5 p-4 d-flex justify-content-center align-items-center ">
                    <div class="bg-overlay bg-dark"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                    <div class="row justify-content-center align-items-center text-center">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="index.php" class="d-block auth-logo">
                                    <img src="assets/images/logo-sm.svg" alt="" height="28"> <span
                                        class="logo-txt text-white">GT Solution</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0 text-primary">Lock screen</h5>
                                    <p class="text-muted mt-2">Enter your password to unlock the screen!</p>
                                </div>
                                <div class="user-thumb text-center mb-4 mt-4 pt-2">
                                    <img src="assets/images/users/avatar-1.jpg"
                                        class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                    <h5 class="text-white font-size-15 mt-3"><?php echo $currentuser; ?></h5>
                                </div>
                                <form class="custom-form mt-4" action="userlockscreen.php" method="post">
                                    <div class="mb-3">
                                        <input type="hidden" class="form-control" id="username"
                                            value="<?php echo $currentuser; ?>" name="username">
                                        <label class="form-label text-success" for="userpassword">Password</label>
                                        <input type="password" class="form-control" name="password" id="userpassword"
                                            placeholder="Enter password">
                                    </div>
                                    <div class="mb-3 mt-4">
                                        <button class="btn btn-primary w-100 waves-effect waves-light"
                                            type="submit">Unlock</button>
                                    </div>
                                </form>

                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">Not you ? return <a href="logout.php"
                                            class="text-primary fw-semibold"> Sign In </a> </p>
                                </div>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0 text-white h5">©
                                    <script>document.write(new Date().getFullYear())</script> GT Solution . Crafted with
                                    <i class="mdi mdi-heart text-danger"></i> by GT Developers
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>


<!-- JAVASCRIPT -->

<?php require_once('layouts/stylescript/vendor-scripts.php'); ?>

</body>

</html>