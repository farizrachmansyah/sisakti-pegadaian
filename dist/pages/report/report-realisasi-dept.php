<?php
session_start();
require_once 'data.php';

function rupiah($angka){
  $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
  return $hasil_rupiah; 
}
date_default_timezone_set('UTC');
$userTimeZone = new DateTimeZone('Asia/Jakarta');
$aWeekAgo = date("Y-m-d", strtotime("-7 day"));
$nowDay = date("Y-m-d");
$startDateVal = new DateTime($aWeekAgo);
$endDateVal = new DateTime($nowDay);
$startDateVal->setTimeZone($userTimeZone);
$endDateVal->setTimeZone($userTimeZone);
$startDate = $startDateVal->format('Y-m-d');
$endDate = $endDateVal->format('Y-m-d');
$soas = loadReportPerDepartemen($startDate,$endDate);


if(isset($_POST['btnFilter'])){
  $startDate = $_POST['from'];
  $endDate = $_POST['to'];
  $soas = loadReportPerDepartemen($startDate,$endDate);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Report</title>

    <!-- Bootstrap -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="../../css/main.min.css" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
      crossorigin="anonymous"
    />
  </head>
  <body>
    <main class="main report">
      <!-- Header -->
      <div class="header-container">
        <div class="header-container-content flex">
          <div class="logo">
            <img src="../../assets/logo-login.png" alt="logo pegadaian" />
          </div>
          <div class="title">
            <h1>Jumlah Realisasi per<br /><span>Departemen</span></h1>
          </div>
        </div>
      </div>

      <div class="main__content report__content">
        <section class="main__content-buttons report__content-buttons flex">
          <form class="download">
            <button type="submit" name="btnFilter"><i class="fas fa-file-download"></i> &MediumSpace; Download</button>
          </form>
          <form class="filter flex" method="POST">
            <div class="filter-date flex">
              <div class="filter-date-calender flex">
                <span>From</span>
                <input type="date" name="from" id="from" <?php if (isset($startDate)) echo "value='".$startDate."'";?>/>
              </div>
              <div class="filter-date-calender flex">
                <span>To</span>
                <input type="date" name="to" id="to" <?php if (isset($endDate)) echo "value='".$endDate."'";?>/>
              </div>
            </div>
            <button type="submit" name="btnFilter">Filter</button>
          </form>
        </section>

        <section class="main__content-table report__content-table">
          <!-- Table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Departemen</th>
                  <th scope="col">Realisasi</th>
                </tr>
              </thead>
              <tbody>
              <?php
                foreach($soas as $key=>$data){
                  $realisasi = rupiah($data['soa_total_nominal']);
                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td>".$data['soa_departemen']."</td>";
                  echo "<td>".$realisasi."</td>";
                  echo "</tr>";
                }
              ?>
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </main>

    <script src="../../js/kabag-kadep.js"></script>
    <!-- <script src="../js/report.js"></script> -->
    <script
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
