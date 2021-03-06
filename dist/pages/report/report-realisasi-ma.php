<?php
session_start();
require_once 'data.php';

function rupiah($angka){
  $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
  return $hasil_rupiah;  
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
            <h1>Jumlah Realisasi per<br /><span>Mata Anggaran</span></h1>
          </div>
        </div>
      </div>

      <div class="main__content report__content">
        <section class="main__content-buttons report__content-buttons">
          <form class="download single" action="export.php" method="POST">
            <button class="single" type="submit"  name="export_ma"><i class="fas fa-file-download"></i> &MediumSpace; Download</button>
          </form>
        </section>
        <section class="main__content-table report__content-table">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Mata Anggaran</th>
                  <th scope="col">Aktivitas</th>
                  <th scope="col">Saldo</th>
                  <th scope="col">Realisasi</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $soas = loadReportPerMataAnggaran();
                foreach($soas as $key=>$data){
                  $realisasi = rupiah($data['soa_total_nominal']);
                  $saldo = rupiah($data['soa_saldo']);

                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td class='soadata-table'>".$data['soa_ma_code']."</td>";
                  echo "<td class='soadata-table'>".$data['soa_ma_name']."</td>";
                  echo "<td>".$saldo."</td>";
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

    <script src="../js/kabag-kadep.js"></script>
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
