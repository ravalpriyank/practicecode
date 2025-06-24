<?php
require 'vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;
$generator = new BarcodeGeneratorPNG();

$insert = false;
$update = false;
$delete = false;
$insertdelivery = false;
$Undeletelrnumber = false;
$deletelrnumber = false;
require_once("connection.php");
$date = date('d M');

//get gst setting from branchlog 
$gsql = "SELECT * FROM `branchlog` WHERE `name` = '$userbranch'";
$run_gsql = mysqli_query($conn2, $gsql);
$gdata = mysqli_fetch_assoc($run_gsql);

$add_sql = "SELECT `field_name` FROM `additional_fields` WHERE `display` = 'on'";
$run_add_sql = mysqli_query($conn2, $add_sql);
$add_feilds = array();

if (mysqli_num_rows($run_add_sql) > 0) {
  while ($row = mysqli_fetch_assoc($run_add_sql)) {
    $add_feilds[] = $row;
  }
}
//get print setting

$pr_query = "SELECT * FROM `settingprint` WHERE `sno` = 1";
$run_pr_query = mysqli_query($conn2, $pr_query);
$pr_data = mysqli_fetch_assoc($run_pr_query);

// Get Last Number 
$selecterlastnum = "SELECT * FROM `transportz` WHERE `branch` = '$userbranch' AND `gst` = 'NO' ORDER BY `sno` DESC LIMIT 1";
$selecterresult = mysqli_query($conn2, $selecterlastnum);
$lastnumberrow = mysqli_fetch_assoc($selecterresult);
if (isset($lastnumberrow['lrn'])) {
  if ($lastnumberrow['lrn'] == $maxnumberhere) {
    $lastnumber = $minnumberhere;
  } else {
    $lastnumber = $lastnumberrow['lrn'] + 1;
  }
} else {
  $lastnumber = $minnumberhere;
}


//get current gst series number
$gst_query = "SELECT * FROM `transportz` WHERE branch = '$userbranch' AND `gst` = 'YES' ORDER BY `sno` DESC LIMIT 1";
$run_gst_query = mysqli_query($conn2, $gst_query);
$viewlastgstrow = mysqli_fetch_assoc($run_gst_query);

if (isset($viewlastgstrow['lrn'])) {
  if ($date == "01 April" && $gdata["gst_reset"] == 0) {
    $viewlastgstnumber = 1;
  } else {
    $viewlastgstnumber = $viewlastgstrow['lrn'] + 1;
  }
} else {
  $viewlastgstnumber = 1;
}


if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `transportz` WHERE `sno` = $sno";
  $result = mysqli_query($conn2, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['LREditSave'])) {
    $active_tab = !empty($_POST["active"]) ? $_POST["active"] : "";
    $lrn = !empty($_POST["LRNUMBEREdit"]) ? $_POST["LRNUMBEREdit"] : "";
    $sendersave = !empty($_POST["senderEdit"]) ? $_POST["senderEdit"] : "";
    $sendernumsave = !empty($_POST["sendernumEdit"]) ? $_POST["sendernumEdit"] : "";
    $reciversave = !empty($_POST["reciverEdit"]) ? $_POST["reciverEdit"] : "";
    $recivernumsave = !empty($_POST["recivernumEdit"]) ? $_POST["recivernumEdit"] : "";
    $senderGST = !empty($_POST["senderGST"]) ? strtoupper($_POST["senderGST"]) : "";
    $reciverGST = !empty($_POST["reciverGST"]) ? strtoupper($_POST["reciverGST"]) : "";

    if (isset($_POST["detail"]) && is_array($_POST["detail"])) {
      $details = implode(", ", $_POST["detail"]);
    }
    if (isset($_POST["rate"]) && is_array($_POST["rate"])) {
      $rate = implode(", ", $_POST["rate"]);
      foreach ($_POST["rate"] as &$rate) {
        if ($rate == 0) {
          $rate = 1;
        }
      }
      $rate = implode(", ", $_POST["rate"]);
    }
    if (isset($_POST["qty"]) && is_array($_POST["qty"])) {

      foreach ($_POST["qty"] as &$value) {
        if ($value == 0) {
          $value = 1;
        }
      }
      $qtyarray = implode(", ", $_POST["qty"]);

      $qtysave = 0;
      foreach ($_POST["qty"] as $value) {
        if ($value == 0) {
          $value = 1;
        }
        $qtysave += $value;
      }

    }

    if (isset($_POST["weight"]) && is_array($_POST["weight"])) {
      $weightarray = implode(", ", $_POST["weight"]);
      $weightsave = 0;
      foreach ($_POST["weight"] as $value) {
        if (intval($value) >= 0) {
          $weightsave += floatval($value);
        }
      }
    }

    if (isset($_POST["total"]) && is_array($_POST["total"])) {
      $totalarray = implode(", ", $_POST["total"]);
      $totalsave = 0;
      foreach ($_POST["total"] as $value) {
        $totalsave += floatval($value);
      }
    }

    $totalsave = $totalsave + $extra_charge;

    if (isset($_POST["rateEdit"]) && is_array($_POST["rateEdit"])) {
      $ratesave = implode(", ", $_POST["rateEdit"]);
    }


    if (isset($_POST["active"])) {
      if ($_POST["active"] == "gst") {
        $gst = "YES";
      } else {
        $gst = "NO";
      }

    }

    $paymentsave = !empty($_POST["paymentEdit"]) ? $_POST["paymentEdit"] : "";
    $placesave = !empty($_POST["placeEdit"]) ? $_POST["placeEdit"] : "";
    $placefilter = CleanBranchCode($placesave);
    $remarksave = !empty($_POST["remarkEdit"]) ? $_POST["remarkEdit"] : "";
    $drivernumber = !empty($_POST["driverEdit"]) ? $_POST["driverEdit"] : "";

    $sql = "UPDATE `transportz` SET `nameone` = '$sendersave' , `numone` = '$sendernumsave' , `gstone` = '$senderGST' , `nametwo` = '$reciversave' , `numtwo` = '$recivernumsave' , `gsttwo` = '$reciverGST', `item` = '$details', `qty` = '$qtysave', `qtyarray` = '$qtyarray', `weight` = '$weightsave', `weightarray` = '$weightarray', `rate` = '$rate', `total` = '$totalsave', `totalarray` = '$totalarray', `type` = '$paymentsave' , `place` = '$placesave' , `placefilter` = '$placefilter' , `remark` = '$remarksave' , `drivernumber` = '$drivernumber' WHERE `transportz`.`lrn` = '$lrn'";
    $result = mysqli_query($conn2, $sql);
    if ($result) {
      $update = true;
    } else {
      echo "We could not update the LR successfully";
    }
  } elseif (isset($_POST['LRNUMBERNew'])) {

    if ($_POST["placeEdit"] != "not") {
      $placesave = $_POST["placeEdit"];
    } else {
      header("location: branch_setting.php?noplace=true");
      return;
    }

    if (isset($_GET["page"]) && !empty($_GET["page"])) {
      $active_tab = $_GET["page"];
    } else {
      $active_tab = $_POST["active"];
    }

    if ($active_tab == "gst") {
      $last_lrn = $viewlastgstnumber;
    } else {
      $last_lrn = $lastnumber;
    }

    if (isset($active_tab) && $active_tab == "gst") {
      $lr_with_code = !empty($branch_code_data["gst_code"]) && !empty($last_lrn) ? $branch_code_data["gst_code"] . "-" . $last_lrn : "";
    } else {
      $lr_with_code = !empty($branch_code_data["code"]) && !empty($last_lrn) ? $branch_code_data["code"] . "-" . $last_lrn : "";
    }

    $sendersave = !empty($_POST["senderEdit"]) ? $_POST["senderEdit"] : "";
    $sendernumsave = !empty($_POST["sendernumEdit"]) ? $_POST["sendernumEdit"] : "";
    $reciversave = !empty($_POST["reciverEdit"]) ? $_POST["reciverEdit"] : "";
    $recivernumsave = !empty($_POST["recivernumEdit"]) ? $_POST["recivernumEdit"] : "";
    $senderGST = !empty($_POST["senderGST"]) ? strtoupper($_POST["senderGST"]) : "";
    $reciverGST = !empty($_POST["reciverGST"]) ? strtoupper($_POST["reciverGST"]) : "";
    $grand_total = !empty($_POST["grandtotal"]) ? $_POST["grandtotal"] : "";
    $extra_charge = !empty($_POST["total_charges"]) ? $_POST["total_charges"] : "";
    $extra_charge = !empty($_POST["total_charges"]) ? $_POST["total_charges"] : 0;
    $barcodeData = $generator->getBarcode($last_lrn, $generator::TYPE_CODE_128); 
    $base64Barcode = base64_encode($barcodeData);

    if (isset($_POST["detail"]) && is_array($_POST["detail"])) {
      $details = implode(", ", $_POST["detail"]);
    }
    if (isset($_POST["rate"]) && is_array($_POST["rate"])) {
      $rate = implode(", ", $_POST["rate"]);
      foreach ($_POST["rate"] as &$rate) {
        if ($rate == 0) {
          $rate = 1;
        }
      }
      $rate = implode(",", $_POST["rate"]);
    }


    if (isset($_POST["qty"]) && is_array($_POST["qty"])) {

      $qtyarray = implode(", ", $_POST["qty"]);
      $qtysave = 0;
      foreach ($_POST["qty"] as $value) {
        if ($value == "" || $value == 0) {
          $value = 1;
        }
        $qtysave += $value;
      }

    }

    if (isset($_POST["weight"]) && is_array($_POST["weight"])) {
      $weightarray = implode(", ", $_POST["weight"]);
      $weightsave = 0;
      foreach ($_POST["weight"] as $value) {
        if (intval($value) >= 0) {
          $weightsave += floatval($value);
        }
      }
    }

    if (isset($_POST["total"]) && is_array($_POST["total"])) {
      $totalarray = implode(", ", $_POST["total"]);
      $totalsave = 0;
      foreach ($_POST["total"] as $value) {
        $totalsave += $value;
      }
    }

    $totalsave = $totalsave + $extra_charge;
    if (isset($_POST["active"])) {
      if ($_POST["active"] == "gst") {
        $gst = "YES";
      } else {
        $gst = "NO";
      }

    }

    $paymentsave = !empty($_POST["paymentEdit"]) ? $_POST["paymentEdit"] : "";
    $remarksave = !empty($_POST["remarkEdit"]) ? $_POST["remarkEdit"] : "";
    $drivernumber = !empty($_POST["driverEdit"]) ? $_POST["driverEdit"] : "";
    $currentuser = !empty($_SESSION['username']) ? $_SESSION['username'] : "";
    if ($sendernumsave == "" && $recivernumsave == "") {
      $findnumberdb = "SELECT * FROM `transportz` WHERE nameone = '$sendersave' AND nametwo = '$reciversave' ORDER BY lrn desc";
      $stagetwooffindnumber = mysqli_query($conn2, $findnumberdb);
      while ($numbersdb = mysqli_fetch_assoc($stagetwooffindnumber)) {
        $sendernumsave = $numbersdb['numone'];
        $recivernumsave = $numbersdb['numtwo'];
      }
    }
    $placefilter = CleanBranchCode($placesave);

    // Sql query to be executed
    $sql = "INSERT INTO `transportz` (
      `lrn`,
      `lrwithcode`,
      `branch`,
      `nameone`,
      `numone`,
      `nametwo`,
      `numtwo`,
      `gstone`,
      `gsttwo`,
      `item`,
      `qty`,
      `qtyarray`,
      `weight`,
      `weightarray`,
      `rate`,
      `total`,
      `totalarray`,
      `type`,
      `place`,
      `placefilter`,
      `remark`,
      `drivernumber`,
      `createby`,
      `entrydate`,
      `gst`,
      `barcode`
  ) VALUES (
      '$last_lrn',
      '$lr_with_code',
      '$userbranch',
      '$sendersave',
      '$sendernumsave',
      '$reciversave',
      '$recivernumsave',
      '$senderGST',
      '$reciverGST',
      '$details',
      '$qtysave',
      '$qtyarray',
      '$weightsave',
      '$weightarray',
      '$rate',
      '$grand_total',
      '$totalarray',
      '$paymentsave',
      '$placesave',
      '$placefilter',
      '$remarksave',
      '$drivernumber',
      '$currentuser',
      CURRENT_TIMESTAMP(),
      '$gst',
      '$base64Barcode'
  )";

    $result = mysqli_query($conn2, $sql);
    $additional_array = !empty($_POST["fields"]) ? $_POST["fields"] : [];
    $add_query = http_build_query($additional_array);

    foreach ($additional_array as $key => $value) {
      $runtm_sql = "INSERT INTO runtime_additional_fields(`field_id`,`field_name`,`field_value`,`branch`)VALUES('$lr_with_code','$key','$value','$userbranch')";
      $run_rntm_sql = mysqli_query($conn2, $runtm_sql);
    }

    if ($result) {
      $insert = true;
    } else {
      echo "The record was not inserted successfully " . mysqli_error($conn2);
    }
  } elseif (isset($_POST['ThisDeliveyAdded'])) {

    $delivery_time = !empty($_POST["DeliveryLRTime"]) ? $_POST["DeliveryLRTime"] : "";
    $reciveris = !empty($_POST["receiver_name"]) ? $_POST["receiver_name"] : "";
    $reciverremark = !empty($_POST["receiver_pno"]) ? $_POST["receiver_pno"] : "";
    $collectiondelivery = !empty($_POST) ? $_POST["collected_money"] : "";

    if ($_POST["pay_opt"] == "upi") {
      $payment_type = 1;
    } elseif ($_POST["pay_opt"] == "cash") {
      $payment_type = 2;
    }

    $LRnumbertodeliver = !empty($_POST["DeliveryLRNum"]) ? $_POST["DeliveryLRNum"] : "";
    $currentuser = !empty($_SESSION['username']) ? $_SESSION['username'] : "";
    $thislrstatus = "close";

    // Sql query to be executed
    $sql = "UPDATE `transportz` SET `receiver` = '$reciveris' , `recivernumber` = '$reciverremark' , `status` = '$thislrstatus' , `payment_method` = '$payment_type', `exitdate` = CURRENT_DATE() , `collection` = '$collectiondelivery' , `deliverby` = '$currentuser', `tstamp` = CURRENT_DATE() WHERE `transportz`.`lrn` = '$LRnumbertodeliver' AND `transportz`.`timestamp` = '$delivery_time'";

    $result = mysqli_query($conn2, $sql);


    if ($result) { ?>
      <script>
        alert("Money Collected Successfully");
      </script>
      <?php
    } else { ?>
      <script>
        alert("The record was not inserted successfully");
      </script>
      <?php
    }
  } elseif (isset($_POST['AddDeleteNow'])) {
    $LRnumbertoDelete = $_POST["AddDeleteNow"];
    $thislrstatus = "deleted";

    // Sql query to be executed
    $sql = "UPDATE `transportz` SET `status` = '$thislrstatus' WHERE `transportz`.`lrn` = '$LRnumbertoDelete'";

    $result = mysqli_query($conn2, $sql);


    if ($result) {
      $deletelrnumber = true;
    } else {
      echo "The record was not Delete successfully " . mysqli_error($conn2);
    }
  } elseif (isset($_POST['AddUnDeleteNow'])) {
    $LRnumbertoUnDelete = $_POST["AddUnDeleteNow"];
    $thislrstatus = "open";

    // Sql query to be executed
    $sql = "UPDATE `transportz` SET `status` = '$thislrstatus' WHERE `transportz`.`lrn` = '$LRnumbertoUnDelete'";

    $result = mysqli_query($conn2, $sql);


    if ($result) {
      $Undeletelrnumber = true;
    } else {
      echo "The record was not Restore successfully " . mysqli_error($conn2);
    }
  }
}


if ($insert) {

  if ($gdata["gst_reset"] == 0) {
    $update_gst = "UPDATE `branchlog` SET `gst_reset` = '1' WHERE `name` = '$userbranch'";
    $run_ugst = mysqli_query($conn2, $update_gst);
  }

  $active_tab = $_POST["active"];

  if ($active_tab == "gst") {
    $last_lrn = $viewlastgstnumber;
  } else {
    $last_lrn = $lastnumber;
  }

  if ($pr_data["format_changed"] == "yes") {
    if ($pr_data["receipt_format"] == "format1") {
      echo "<script type=\"text/javascript\">
              window.open('format1_print.php?PrintLR=" . $last_lrn . "&" . $add_query . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format2") {
      echo "<script type=\"text/javascript\">
              window.open('format2_print.php?PrintLR=" . $last_lrn . "&" . $add_query . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format3") {
      echo "<script type=\"text/javascript\">
              window.open('format3_print.php?PrintLR=" . $last_lrn . "&" . $add_query . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format4") {
      echo "<script type=\"text/javascript\">
              window.open('format4_print.php?PrintLR=" . $last_lrn . "&extra=" . $extra_charge . "&" . $add_query . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format5") {
      echo "<script type=\"text/javascript\">
              window.open('format5_print.php?PrintLR=" . $last_lrn . "&" . $add_query . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format6") {
      echo "<script type=\"text/javascript\">
              window.open('format6_print.php?PrintLR=" . $last_lrn . "&" . $add_query . "', '_blank')
              </script>";
    }
  } else {
    if ($softwarePrintStyle == "2in1") {
      if ($softwarePrintMethod == "single") {
        echo "<script type=\"text/javascript\">
                window.open('printnewhalf.php?PrintLR=" . $last_lrn . "&" . $add_query . "', '_blank')
            </script>";
      }
      if ($softwarePrintMethod == "dual") {
        echo "<script type=\"text/javascript\">
                window.open('printnewfull.php?PrintLR=" . $last_lrn . "&" . $add_query . "', '_blank')
            </script>";
      }
    } elseif ($softwarePrintStyle == "old") {
      echo "<script type=\"text/javascript\">
              window.open('printold.php?PrintLR=" . $last_lrn . "&" . $add_query . "', '_blank')
          </script>";
    }
  }


  $selecterlastnum = "SELECT * FROM `transportz` WHERE `branch` = '$userbranch' AND `gst` = 'NO' ORDER BY `sno` DESC LIMIT 1";
  $selecterresult = mysqli_query($conn2, $selecterlastnum);
  $lastnumberrow = mysqli_fetch_assoc($selecterresult);

  if (isset($lastnumberrow['lrn'])) {
    if ($lastnumberrow['lrn'] == $maxnumberhere) {
      $lastnumber = $minnumberhere;
    } else {
      $lastnumber = $lastnumberrow['lrn'] + 1;
    }
  } else {
    $lastnumber = $minnumberhere;
  }
}
?>
<?php
if ($insertdelivery) {
  echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Parcel Delivery Added successfully.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>×</span>
      </button>
    </div>";
}
?>
<?php
if ($deletelrnumber) {
  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Parcel Record Deleted successfully.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>×</span>
      </button>
    </div>";
}
?>
<?php
if ($Undeletelrnumber) {
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Parcel Record Restored successfully.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>×</span>
      </button>
    </div>";
}
?>

<?php
if ($delete) {
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Parcel deleted successfully.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
}
?>
<?php
if ($update) {
  if ($pr_data["format_changed"] == "yes") {
    if ($pr_data["receipt_format"] == "format1") {
      echo "<script type=\"text/javascript\">
              window.open('format1_print.php?PrintLR=" . $lrn . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format2") {
      echo "<script type=\"text/javascript\">
              window.open('format2_print.php?PrintLR=" . $lrn . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format3") {
      echo "<script type=\"text/javascript\">
              window.open('format3_print.php?PrintLR=" . $lrn . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format4") {
      echo "<script type=\"text/javascript\">
              window.open('format4_print.php?PrintLR=" . $lrn . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format5") {
      echo "<script type=\"text/javascript\">
              window.open('format5_print.php?PrintLR=" . $lrn . "', '_blank')
              </script>";
    }
    if ($pr_data["receipt_format"] == "format6") {
      echo "<script type=\"text/javascript\">
              window.open('format6_print.php?PrintLR=" . $lrn . "', '_blank')
              </script>";
    }
  } else {
    if ($softwarePrintStyle == "2in1") {
      if ($softwarePrintMethod == "single") {
        echo "<script type=\"text/javascript\">
                window.open('printnewhalf.php?PrintLR=" . $lrn . "', '_blank')
            </script>";
      }
      if ($softwarePrintMethod == "dual") {
        echo "<script type=\"text/javascript\">
                window.open('printnewfull.php?PrintLR=" . $lrn . "', '_blank')
            </script>";
      }
    } elseif ($softwarePrintStyle == "old") {
      echo "<script type=\"text/javascript\">
              window.open('printold.php?PrintLR=" . $lrn . "', '_blank')
          </script>";
    }
  }
}
?>