<?php

$insert = false;
$update = false;
$delete = false;

// Get Last Number 
$selecterlastnum = "SELECT * FROM `transportz` WHERE branch = '$userbranch' ORDER BY sno DESC LIMIT 1";
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

if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `transportz` WHERE `sno` = $sno";
  $result = mysqli_query($conn2, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['LREditSave'])) {
    $active_tab = $_POST["active"];
    $lrn = $_POST["LRNUMBEREdit"];
    $sendersave = $_POST["senderEdit"];
    $sendernumsave = $_POST["sendernumEdit"];
    $reciversave = $_POST["reciverEdit"];
    $recivernumsave = $_POST["recivernumEdit"];
    $senderGST = strtoupper($_POST["senderGST"]);
    $reciverGST = strtoupper($_POST["reciverGST"]);
    if (isset($_POST["detail"]) && is_array($_POST["detail"])) {
      $details = implode(", ", $_POST["detail"]);
    }
    if (isset($_POST["rate"]) && is_array($_POST["rate"])) {
      $rate = implode(", ", $_POST["rate"]);
    }
    if (isset($_POST["qty"]) && is_array($_POST["qty"])) {
      $qtyarray = implode(", ", $_POST["qty"]);
      $qtysave = 0;
      foreach ($_POST["qty"] as $value) {
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
    // $rate = $_POST["rate"];
    // $qtysave = $_POST["qty"];
    if (isset($_POST["rateEdit"]) && is_array($_POST["rateEdit"])) {
      $ratesave = implode(", ", $_POST["rateEdit"]);
    }
    // $totalsave = $_POST["total"];

    if (isset($_POST["active"])) {
      if ($_POST["active"] == "TopayTopaid") {
        $paymentsave = $_POST["paymentEdit"];
      } else {
        $paymentsave = $_POST["accountEdit"];
      }

    }

    if ($_POST["active"] == "") {
      $paymentsave = $_POST["paymentEdit"];
    }

    $placesave = $_POST["placeEdit"];
    $remarksave = $_POST["remarkEdit"];
    $drivernumber = $_POST["driverEdit"];
    $sql = "UPDATE `transportz` SET `nameone` = '$sendersave' , `numone` = '$sendernumsave' , `gstone` = '$senderGST' , `nametwo` = '$reciversave' , `numtwo` = '$recivernumsave' , `gsttwo` = '$reciverGST', `item` = '$details', `qty` = '$qtysave', `qtyarray` = '$qtyarray', `weight` = '$weightsave', `weightarray` = '$weightarray', `rate` = '$rate', `total` = '$totalsave', `totalarray` = '$totalarray', `type` = '$paymentsave' , `place` = '$placesave' , `remark` = '$remarksave' , `drivernumber` = '$drivernumber' WHERE `transportz`.`lrn` = '$lrn'";
    $result = mysqli_query($conn2, $sql);
    if ($result) {
      $update = true;
    } else {
      echo "We could not update the LR successfully";
    }
  } elseif (isset($_POST['LRNUMBERNew'])) {

    $active_tab = $_POST["active"];
    $sendersave = $_POST["senderEdit"];
    $sendernumsave = $_POST["sendernumEdit"];
    $reciversave = $_POST["reciverEdit"];
    $recivernumsave = $_POST["recivernumEdit"];
    $senderGST = strtoupper($_POST["senderGST"]);
    $reciverGST = strtoupper($_POST["reciverGST"]);

    if (isset($_POST["detail"]) && is_array($_POST["detail"])) {
      $details = implode(", ", $_POST["detail"]);
    }
    if (isset($_POST["rate"]) && is_array($_POST["rate"])) {
      $rate = implode(", ", $_POST["rate"]);
    }


    if (isset($_POST["qty"]) && is_array($_POST["qty"])) {
      $qtyarray = implode(", ", $_POST["qty"]);
      $qtysave = 0;
      foreach ($_POST["qty"] as $value) {
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
    // $totalsave = $_POST["total"];
    if (isset($_POST["active"])) {
      if ($_POST["active"] == "TopayTopaid") {
        $paymentsave = $_POST["paymentEdit"];
      } else {
        $paymentsave = $_POST["accountEdit"];
      }

    }

    if ($_POST["active"] == "") {
      $paymentsave = $_POST["paymentEdit"];
    }

    $placesave = $_POST["placeEdit"];
    $remarksave = $_POST["remarkEdit"];
    $drivernumber = $_POST["driverEdit"];
    $currentuser = $_SESSION['username'];
    if ($sendernumsave == "" && $recivernumsave == "") {
      $findnumberdb = "SELECT * FROM `transportz` WHERE nameone = '$sendersave' AND nametwo = '$reciversave' ORDER BY lrn desc";
      $stagetwooffindnumber = mysqli_query($conn2, $findnumberdb);
      while ($numbersdb = mysqli_fetch_assoc($stagetwooffindnumber)) {
        $sendernumsave = $numbersdb['numone'];
        $recivernumsave = $numbersdb['numtwo'];
      }
    }

    // Sql query to be executed
    $sql = "INSERT INTO `transportz` (
      `lrn`,
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
      `remark`,
      `drivernumber`,
      `createby`,
      `entrydate`
  ) VALUES (
      '$lastnumber',
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
      '$totalsave',
      '$totalarray',
      '$paymentsave',
      '$placesave',
      '$remarksave',
      '$drivernumber',
      '$currentuser',
      CURRENT_TIMESTAMP()
  )";

    $result = mysqli_query($conn2, $sql);


    if ($result) {
      $insert = true;
    } else {
      echo "The record was not inserted successfully " . mysqli_error($conn2);
    }
  } elseif (isset($_POST['PrintLR'])) {
    $PrintLR = $_POST["PrintLR"];
  }
}


if ($insert) {
  if ($softwarePrintStyle == "2in1") {
    if ($softwarePrintMethod == "single") {
      echo "<script type=\"text/javascript\">
                window.open('printnewhalf.php?PrintLR=" . $lastnumber . "', '_blank')
            </script>";
    }
    if ($softwarePrintMethod == "dual") {
      echo "<script type=\"text/javascript\">
                window.open('printnewfull.php?PrintLR=" . $lastnumber . "', '_blank')
            </script>";
    }
  } elseif ($softwarePrintStyle == "old") {
    echo "<script type=\"text/javascript\">
              window.open('printold.php?PrintLR=" . $lastnumber . "', '_blank')
          </script>";
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
?>