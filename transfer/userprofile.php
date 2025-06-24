<?php
require_once('layouts/mainheader.php');
require_once("connection.php");

$username = !empty($_SESSION["username"]) ? $_SESSION["username"] : "";

$role_query = "SELECT `roll` FROM `users` WHERE `username` = '" . $_SESSION["username"] . "'";
$run_role_query = mysqli_query($conn2, $role_query);
$get_role = mysqli_fetch_assoc($run_role_query);

$similar_query = "SELECT * FROM `users` WHERE `roll` = '" . $get_role['roll'] . "' AND `username` NOT IN('" . $_SESSION["username"] . "')";
$run_similar_query = mysqli_query($conn2, $similar_query);

$similar_data = array();

if (mysqli_num_rows($run_similar_query) >= 1) {
    while ($raw = mysqli_fetch_assoc($run_similar_query)) {
        $similar_data[] = $raw;
    }
}

if (isset($_POST) && isset($_SERVER["REQUEST_METHOD"]) == "POST") {

    if (isset($_FILES) && isset($_FILES['profile_image_uploads']['name'])) {


        $img_name = $_FILES['profile_image_uploads']['name'];
        $img_tamp = $_FILES['profile_image_uploads']['tmp_name'];
        $img_location = "assets/images/" . $img_name;

        move_uploaded_file($img_tamp, $img_location);

        if (!empty($img_location)) {
            $update_query = "UPDATE `users` SET `user_profile` = '$img_location' WHERE `username` = '" . $_SESSION["username"] . "'";
            $run_update_query = mysqli_query($conn2, $update_query);

            if ($run_update_query) { ?>
                <script>
                    alert("User Profile Image Updated Successfully");
                </script>
                <?php
            } else { ?>
                <script>
                    alert("Something Went Wrong");
                </script>
                <?php
            }

            $username = !empty($_SESSION["username"]) ? $_SESSION["username"] : "";

            $query = "SELECT * FROM `users` WHERE `username` = '$username'";
            $run_query = mysqli_query($conn2, $query);
            $user_data = mysqli_fetch_assoc($run_query);
        }
    }
}

?>

<head>

    <title><?php echo $language["Profile"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <style>
        #staticBackdrop {
            position: absolute;
            top: 100px;
        }
    </style>

</head>

<?php require_once('layouts/main/body.php'); ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php require_once('layouts/menu/menu.php'); ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18"><?php echo $language["Profile"]; ?></h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a
                                            href="javascript: void(0);"><?php echo $language['Profile']; ?></a></li>
                                    <li class="breadcrumb-item active">GT Solution </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="card">
                            <div class="card-body card_body">
                                <form action="userprofile.php" method="POST" enctype='multipart/form-data'>
                                    <div class="row">
                                        <div class="col-sm order-2 order-sm-1">
                                            <div class="d-flex align-items-center gap-4 mt-3 mt-sm-0">
                                                <div class="flex-shrink-0">
                                                    <div class="preview">
                                                        <img id="img-preview"
                                                            src="<?php echo $user_data["user_profile"] ?>"
                                                            class="rounded-circle" name="user_profile"
                                                            id="user_profile" />
                                                        <div class="upload_image">
                                                            <label for="image_uploads"
                                                                class="img-upload-btn"><?php echo $language['EditImage']; ?></label>
                                                            <input type="file" id="file-input"
                                                                name="profile_image_uploads" accept=".jpg, .jpeg, .png">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h3 class="font-size-30 mb-1 text-primary">
                                                            <?php echo !empty($user_data["username"]) ? $user_data["username"] : ""; ?>
                                                        </h3>
                                                        <p class="text-muted font-size-16">
                                                            <?php echo !empty($user_data["roll"]) ? $user_data["roll"] : ""; ?>
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div
                                                class=" d-flex mt-3 align-items-start justify-content-around align-items-center ">
                                                <button type="button" class="btn btn-primary ntn-md"
                                                    style="margin-left:80px;margin-top:4px;" data-bs-toggle="modal"
                                                    data-bs-target="#staticBackdrop"><?php echo $language['Change_Password']; ?></button>
                                                <button type="submit"
                                                    class="btn btn-primary p-2 w-25"><?php echo $language['save']; ?></button>



                                            </div>
                                        </div>
                                        <div class="col-sm-auto order-1 order-sm-2">
                                            <div class="d-flex align-items-start justify-content-end gap-2">
                                                <div>
                                                    <div class="dropdown">

                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Something else
                                                                    here</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>


                    <div class="col-xl-3 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><?php echo $language['Similar']; ?></h5>

                                <div class="list-group list-group-flush">
                                    <?php
                                    if (!empty($similar_data)) {
                                        foreach ($similar_data as $data) { ?>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0 me-3">
                                                        <img src="<?php echo $data["user_profile"]; ?>" alt=""
                                                            class="img-thumbnail rounded-circle">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div>
                                                            <h5 class="font-size-14 mb-1"><?php echo $data["username"]; ?></h5>
                                                            <p class="font-size-13 text-muted mb-0"><?php echo $data["roll"]; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php }
                                    } else {
                                        echo "No similar profiles available";
                                    } ?>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Change Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="">New Password :</label>
                                        <input type="text" name="new_passwd" id="new_passwd" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Conform Password :</label>
                                        <input type="text" name="confirm_passwd" id="confirm_passwd"
                                            class="form-control">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn_change_passwd"
                                        data-bs-dismiss="modal">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <?php require_once('layouts/main/footer.php'); ?>
        </div>

    </div>

    <?php require_once('layouts/menu/right-sidebar.php'); ?>

    <?php require_once('layouts/stylescript/vendor-scripts.php'); ?>

    <script src="assets/js/app.js"></script>
    <script>
        const input = document.getElementById("file-input");
        const image = document.getElementById("img-preview");

        input.addEventListener("change", (e) => {
            if (e.target.files.length) {
                const src = URL.createObjectURL(e.target.files[0]);
                image.src = src;
            }
        });
    </script>

    </body>

    </html>