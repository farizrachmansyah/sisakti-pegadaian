<?php
session_start();
require_once 'data.php';

function rupiah($angka){
  $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
  return $hasil_rupiah;  
}

if(isset($_POST['submit'])){
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];

    // filter data yang diinputkan
    $rsopp = filter_input(INPUT_POST, 'sopp', FILTER_SANITIZE_STRING);
    $rnota = filter_input(INPUT_POST, 'nota', FILTER_SANITIZE_STRING);
    $rspk = filter_input(INPUT_POST, 'spk', FILTER_SANITIZE_STRING);
    $rpkb = filter_input(INPUT_POST, 'pkb', FILTER_SANITIZE_STRING);
    $rpo = filter_input(INPUT_POST, 'po', FILTER_SANITIZE_STRING);
    $rpr = filter_input(INPUT_POST, 'pr', FILTER_SANITIZE_STRING);
    $rfaktur = filter_input(INPUT_POST, 'fp', FILTER_SANITIZE_STRING);
    $rktp = filter_input(INPUT_POST, 'ktp', FILTER_SANITIZE_STRING);
    $rnpwp = filter_input(INPUT_POST, 'npwp', FILTER_SANITIZE_STRING);
    $rsiup = filter_input(INPUT_POST, 'siup', FILTER_SANITIZE_STRING);
    $rtdp = filter_input(INPUT_POST, 'tdp', FILTER_SANITIZE_STRING);
    $rfoto = filter_input(INPUT_POST, 'foto', FILTER_SANITIZE_STRING);
    // $soa_no = filter_input(INPUT_GET, 'soa_no', FILTER_SANITIZE_STRING);
    
    if($rsopp == "Y" && $rnota == "Y" 
    && $rspk == "Y" && $rpkb == "Y" 
    && $rpo == "Y" && $rpr == "Y" 
    && $rfaktur == "Y" && $rktp == "Y" 
    && $rnpwp == "Y" && $rsiup == "Y" 
    && $rtdp == "Y" && $rfoto == "Y"){
        $lastStatus = "Register";
    }else{
        $lastStatus = "Rejected";
    }

    // menyiapkan query
    $sql = "UPDATE tbl_soa SET is_sopp = :is_sopp, is_nd = :is_nota,
    is_spk = :is_spk, is_pkb = :is_pkb,
    is_po = :is_po, is_pr = :is_pr,
    is_fp = :is_fp, is_ktp = :is_ktp,
    is_npwp = :is_npwp, is_siup = :is_siup,
    is_tdp = :is_tdp, is_fss = :is_fss,
    soa_lastupdate_by = :usr_id, soa_lastupdate_status = :last_status where soa_no = :soa_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_no" => $soa_no,
        ":is_sopp" => $rsopp,
        ":is_nota" => $rnota,
        ":is_spk" => $rspk,
        ":is_pkb" => $rpkb,
        ":is_po" => $rpo,
        ":is_pr" => $rpr,
        ":is_fp" => $rfaktur,
        ":is_ktp" => $rktp,
        ":is_npwp" => $rnpwp,
        ":is_siup" => $rsiup,
        ":is_tdp" => $rtdp,
        ":is_fss" => $rfoto,
        ":usr_id" => $userId,
        ":last_status" => $lastStatus
        
    );    
    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) header("Location: dashboard.php");
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
          <div class="download ma">
            <a class="ma" href="#"><i class="fas fa-file-download"></i> &MediumSpace; Download</a>
          </div>
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
                <tr>
                  <td>1</td>
                  <td>1710101</td>
                  <td>Aktiva Tetap SGU Bangunan Kantor dan Rumah</td>
                  <td>Rp. 1.000.000.000</td>
                  <td>Rp. 130.000.000</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>5143501</td>
                  <td>Biaya Penanganan Pandemi</td>
                  <td>Rp. 1.000.000.000</td>
                  <td>Rp. 8.350.000</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>5142301</td>
                  <td>Biaya Penyaluran Bina Lingkungan</td>
                  <td>Rp. 1.000.000.000</td>
                  <td>Rp. 10.000.000</td>
                </tr>
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
