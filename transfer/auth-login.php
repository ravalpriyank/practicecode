<?php
// Initialize the session

// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

if (isset($_GET) && isset($_GET["login"]) == "failed") {
    $login_error = "<span style='font-size:15px;' class='text-danger fw-bold'>* Invalid Company Code , Username Or Password *</span>";
}

// Define variables and initialize with empty values
$username = $password = $company_code = "";
$username_err = $password_err = $company_code_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION["company_code"] = $_POST["company_code"];

    require_once("connection.php");

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

    // Check if companycode is empty
    if (empty(trim($_POST["company_code"]))) {
        $company_code_err = "Please enter company code.";
    } else {
        $company_code = trim($_POST["company_code"]);
    }

    $username = !empty($_POST["username"]) ? strtolower($_POST["username"]) : "";
    $password = !empty($_POST["password"]) ? $_POST["password"] : "";

    $sql = "select * from `users` where `username` = '$username' AND password ='$password'";
    $result = mysqli_query($conn2, $sql);
    $data = mysqli_fetch_assoc($result);

    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $login = true;

        $date = date('d M H : i : s');

        $_SESSION['loggedin'] = true;
        $loginuser = $_SESSION['loggedin'];
        $_SESSION['username'] = !empty($data["username"]) ? $data["username"] : "";
        $query1 = "SELECT * FROM `parcel_companies` WHERE `username` = '" . $_SESSION['username'] . "'";
        $run_query1 = mysqli_query($conn1, $query1);
        $query_data = mysqli_fetch_assoc($run_query1);

        if ($query_data["isBranch"] == "no") {
            header("location: branch_setting.php?first=true");
        } else {
            header("location: index.php");
        }

    } else {
        $password_err = "Credentials are Incorrect";
    }
}
?>
<?php require_once('layouts/core/languageset.php'); ?>

<head>

    <title>Login | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>

    <?php require_once('layouts/stylescript/head-style.php'); ?>

</head>

<?php require_once('layouts/main/body.php'); ?>
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-4  ">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-3 text-center">
                                <a href="index.php" class="d-block auth-logo">
                                    <img src="assets/images/logo-sm.svg" alt="" height="28"> <span class="logo-txt">GT
                                        Solution</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">Welcome Back !</h5>
                                    <p class="text-muted mt-2">Sign in to continue to GT Transport Solution.</p>
                                </div>
                                <div>
                                    <?php echo isset($_GET["login"]) ? $login_error : ""; ?>
                                </div>
                                <form class="custom-form login-form mt-4 pt-2" id="login-form" action="auth-login.php"
                                    method="post">
                                    <div class="mb-3 <?php echo (!empty($company_code_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label" for="company_code">Company Code</label>
                                        <input type="text" class="form-control" id="company_code"
                                            placeholder="Enter company code" name="company_code" required>
                                        <span class="text-danger"><?php echo $company_code_err; ?></span>
                                    </div>
                                    <div class="mb-3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" id="username"
                                            placeholder="Enter username" name="username" required>
                                        <span class="text-danger"><?php echo $username_err; ?></span>
                                    </div>
                                    <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                        </div>

                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control w-100"
                                                placeholder="Enter password" name="password" aria-label="Password"
                                                aria-describedby="password-addon" required>
                                            <span class="text-danger"><?php echo $password_err; ?></span>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <button class="btn btn-primary w-100 btn_login_user waves-effect waves-light"
                                            type="submit">Log In</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-1 mt-md-3 text-center">
                                <p class="mb-0">©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script> GT Transport Solution . Crafted with <i
                                        class="mdi mdi-heart text-danger"></i> by <b>GT Solution</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
            <!-- end col -->
            <div class="col-xxl-9 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 text-center">
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
                    <div class="row text-center justify-content-center align-items-center">
                        <div class="text-center ">
                            <div class="text-white">
                                <div class="text-center">
                                    <img src="assets/images/logo-sm.svg" style="width: 300px; height:270px;"
                                        class="m-4 p-4 avatar-md img-fluid rounded-circle" alt="...">
                                    <h1 class="mt-4 text-center text-big fw-medium lh-base text-white">“GT Solution”
                                    </h1>
                                    <h4 class="text-white">A company dedicated to Accounting, ERP, HRM, CRM & transport
                                        software services for many years</h4>
                                    <h3><a class="text-blue" href="tel:7229082373">Call us : 7229082373</a></h3>
                                </div>
                            </div>
                        </div>
                        <!-- end review carousel -->
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
<!-- password addon init -->
<script src="assets/js/pages/pass-addon.init.js"></script>

</body>

</html>