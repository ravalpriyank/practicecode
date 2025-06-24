<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
require_once("receipt_print_logic.php");

$sno = 1;
$get_sql = "SELECT * FROM `settingprint` WHERE `settingprint`.`sno` = '$sno'";
$run_get_sql = mysqli_query($conn2, $get_sql);
$get_data = mysqli_fetch_assoc($run_get_sql);
?>

<head>
    <title><?php echo $language["print"] . $language["setting"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/company_setting.css">
    <link rel="stylesheet" href="assets/css/slider.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script scr="assets/js/custome.js"></script>
</head>

<?php require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php');
?>

<div id="layout-wrapper">
    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Bread Cump -->
                <div class="row pt-4">
                    <div class="main_title mb-4">
                        <h2 class="text-center text-primary">
                            <?php echo $language["print"] . " " . $language["setting"]; ?></h2>
                        <hr>
                    </div>
                </div>
                <form action="#" method="POST">
                    <div class="row">
                        <div class="col-lg-6 text-center">
                            <h4 class="mb-3 text-info"><?php echo $language['RateTotal']; ?></h4>
                            <ul class="list-group text-center border-0">
                                <li
                                    class="list-group-item list_group_item border-0 d-flex gap-2 align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input m-0 p-3" name="unpaid" id="unpaid"
                                        <?php echo $get_data["baki"] == "on" ? "checked" : ""; ?>>
                                    <h5 class="m-0">જયારે પેમેન્ટ (-<span class="text-danger">બાકી</span>-) હોય</h5>
                                </li>
                                <li
                                    class="list-group-item  list_group_item border-0  d-flex gap-2 align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input me-1 p-3" name="paid" id="paid" <?php echo $get_data["jama"] == "on" ? "checked" : ""; ?>>
                                    <h5 class="m-0">જયારે પેમેન્ટ (-<span class="text-success">જમા</span>-) હોય</h5>
                                </li>
                                <li
                                    class="list-group-item  list_group_item border-0  d-flex gap-2 align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input p-3" name="account" id="account"
                                        <?php echo $get_data["account"] == "on" ? "checked" : ""; ?>>
                                    <h5 class="m-0">જયારે પેમેન્ટ (-<span class="text-primary">ખાતું</span>-) હોય</h5>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-center">
                            <h4 class="mb-3 text-info"><?php echo $language['PrintTime']; ?></h4>
                            <ul class="list-group text-center border-0 ">
                                <li
                                    class="list-group-item list_group_item border-0 d-flex gap-2 align-items-center justify-content-center">
                                    <input type="checkbox" class="form-check-input me-1 p-3" name="booking_print"
                                        id="booking_print" <?php echo $get_data["dates"] == "on" ? "checked" : ""; ?>>
                                    <h5 class="m-0">બુકિંગ ટાઈમ અને પ્રિન્ટ ટાઇમ</h5>
                                </li>

                            </ul>
                            <div class="save">
                                <input type="hidden" name="generalsetting">
                                <button type="submit"
                                    class="btn btn-success w-75 btn_save_print"><?php echo $language['save']; ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="Receipt_fornmate mt-4 ">
                <h3 class="ps-4 mb-4"><?php echo $language['receipt_format']; ?></h3>
                <div class="gallery">
                    <button class="arrow" id="prevBtn">&lt;</button>
                    <div class="thumbnails-container">
                        <div class="thumbnails" id="thumbnails">
                        </div>
                    </div>
                    <button class="arrow" id="nextBtn">&gt;</button>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php require_once('layouts/main/footer.php'); ?>
</div>
<!-- end main content-->

</div>

<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<?php require_once('layouts/menu/right-sidebar.php'); ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->

<?php require_once('layouts/stylescript/vendor-scripts.php'); ?>

<!-- init js -->
<script src="assets/js/app.js"></script>

<!-- choices js -->
<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<?php require_once 'layouts/footer/transportb.php'; ?>

<!-- datatable js -->
<script type="text/javascript" charset="utf8"
    src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>


<script>
    const images = [
        { url: 'assets/images/receipt_images/Receipt1.PNG', link: 'receipt_format1.php' },
        { url: 'assets/images/receipt_images/Receipt2.PNG', link: 'receipt_format2.php' },
        { url: 'assets/images/receipt_images/Receipt3.PNG', link: 'receipt_format3.php' },
        { url: 'assets/images/receipt_images/Receipt4.PNG', link: 'receipt_format4.php' },
        { url: 'assets/images/receipt_images/Receipt5.PNG', link: 'receipt_format5.php' },
        { url: 'assets/images/receipt_images/Receipt6.PNG', link: 'receipt_format6.php' }
    ];

    const thumbnails = document.getElementById('thumbnails');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const thumbnailWidth = 230; // Width of image + margin
    let currentIndex = 0; // Start with the first image

    // Duplicate images to create the infinite effect
    function loadImages() {
        let html = '';
        images.forEach(image => {
            html += `<a href="${image.link}"><img src="${image.url}" alt="Image"></a>`;
        });
        thumbnails.innerHTML = html + html; // Duplicate once for infinite loop
        thumbnails.style.width = `${thumbnailWidth * images.length * 2}px`; // Double the width for the two sets
        updateThumbnails();
    }

    function updateThumbnails() {
        thumbnails.style.transform = `translateX(-${currentIndex * thumbnailWidth}px)`;
    }

    // Handle clicking the 'Prev' button
    prevBtn.addEventListener('click', () => {
        if (currentIndex === 0) {
            currentIndex = images.length;
            thumbnails.style.transition = 'none'; // Disable transition for the jump
            updateThumbnails();
            setTimeout(() => {
                thumbnails.style.transition = 'transform 0.5s ease-in-out'; // Re-enable transition
                currentIndex--;
                updateThumbnails();
            }, 20);
        } else {
            currentIndex--;
            updateThumbnails();
        }
    });

    // Handle clicking the 'Next' button
    nextBtn.addEventListener('click', () => {
        if (currentIndex >= images.length * 2 - 1) {
            currentIndex = images.length - 1;
            thumbnails.style.transition = 'none'; // Disable transition for the jump
            updateThumbnails();
            setTimeout(() => {
                thumbnails.style.transition = 'transform 0.5s ease-in-out'; // Re-enable transition
                currentIndex++;
                updateThumbnails();
            }, 20);
        } else {
            currentIndex++;
            updateThumbnails();
        }
    });

    loadImages();

</script>

</body>

</html>