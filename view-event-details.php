<?php 
include('includes/autoload.php'); 

date_default_timezone_set('Asia/kolkata');

require('includes/login_auth.php'); 
$_SESSION['LAST_ACTIVE_LOGIN'] = time();
$id = $_SESSION['id'];
$LAST_LOGIN = $_SESSION['LAST_ACTIVE_LOGIN'];

if (isset($_GET['name'])) {
      if (empty($_GET['name'])) {
            echo "<script>window.location.href='view-events.php';</script>";
      } else {
            $paralLink = $_GET['name'];
      }
} else {
      echo "<script>window.location.href='view-events.php';</script>";
}

$getDetails = "SELECT * from event where sellerId = '$id' and paralLink = '$paralLink' limit 1";
$getRes = mysqli_query($con,$getDetails);
if (($count = mysqli_num_rows($getRes)) == 1) {
$getRows = mysqli_fetch_array($getRes);

  $rDate = strtotime($getRows['event_regEndDate']);
  $cDate = strtotime(date('Y-m-d'));

  if ($cDate <= $rDate) {
    $status = "Live";
    $val = "text-success";
  } else {
    $status = "Closed";
    $val = "text-danger";
  }
?>
      <!-- Main Content -->
      <div class="main-content">
        
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
              <div class="card ">
                <div class="card-header">
                    <img src="assets/uploads/event-banner/<?= $getRows['event_banner'] ?>" width="80%" height="240px" style="padding: 10px;">
                    <div class="card-header-action" style="background-color: #F0F3FF; color: #6F7EF0; padding-left: 10px; padding-top: 10px; width: 459px;">
                        <h3 style="">About Events - <span class="<?= $val ?>"><?= $status ?></span></h3>
                        <div class="col-7 col-xl-7 mb-3">
                              by: <span class="text-big"><?= $_SESSION['name'] ?></span>
                        </div>
                        <div class="col-7 col-xl-7 mb-3">
                              Type: <span class="text-big" style="font-weight: bold;"><?= strtoupper($getRows['event_category']) ?></span>
                        </div>
                        <div class="col-7 col-xl-7 mb-3">
                              Price: <span class="text-big">₹ <?= $getRows['event_price'] ?></span>
                        </div>
                        <div class="col-7 col-xl-7 mb-3">
                              Start Date & Time: <span class="text-big"><?= date('d-m-Y',strtotime($getRows['event_startDate'])) ?></span>
                        </div>
                        <div class="col-7 col-xl-7 mb-3">
                              Location: <span class="text-big"><?= $getRows['event_location'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-9" style="padding-left: 20px;">
                      <div id="chart1"></div>
                      <div class="row mb-0">
                              <h1><?= $getRows['event_name'] ?></h1>
                      </div>
                      <div class="row mb-0">
                              <?= $getRows['event_details'] ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      </div>
<?php
} else {
      echo "<script>window.location.href='view-events.php';</script>";
}
?>
<?php include('includes/footer.php'); ?>