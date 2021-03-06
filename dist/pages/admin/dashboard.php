<?php
  session_start();
  require_once 'data.php';

  function rupiah($angka){
	
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    return $hasil_rupiah;
   
  }
  $soa_no = '';
  if(isset($_POST['soa'])){
    if(!isset($_SESSION["user"])||$userId=''){
      header("Location: ../../../login.php");
    }
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];
    $soa_no = $_POST['soa'];
    $lastStatus = "Done";

    $sql = "UPDATE tbl_soa SET soa_lastupdate_status = :last_status where soa_no = :soa_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_no" => $soa_no,
        ":last_status" => $lastStatus   
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);
    if($saved) header("Location: dashboard.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SiSAKTI &MediumSpace;-&MediumSpace; Staf Administrasi</title>

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
    <!-- Pop Up Registered -->
    <div id="popup-registered" class="popup flex flex-ai-c">
      <p>Dokumen transaksi sudah dibayarkan</p>
      <form method="POST">
        <input id="popup-registered-data" type="hidden" name="soa" />
        <button type="submit">Selesai</button>
      </form>
    </div>

    <main class="main admin">
      <!-- Header -->
      <div class="header-container">
        <div class="header-container-user flex flex-ai-c flex-jc-sb">
          <div class="btn-group">
            <a class="name btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Staf Admin
            </a>
            <div class="dropdown-menu">
              <a class="name-page dropdown-item" href="#">Halaman Utama</a>
              <a class="name-page dropdown-item" href="./ump/dashboard-ump.php">Halaman UMP</a>
            </div>
          </div>

          <a href="../../../logout.php" type="submit" class="logout">logout &MediumSpace;<i class="fas fa-sign-out-alt"></i></a>
        </div>

        <div class="header-container-content top-space flex">
          <div class="logo">
            <img src="../../assets/logo-login.png" alt="logo pegadaian" />
          </div>
          <div class="title">
            <h1>daftar dokumen</h1>
          </div>
        </div>
      </div>

      <div class="main__content admin__content">
        <section class="main__content-buttons admin__content-button">
          <form action="../report/export.php" method="POST">
            <button type="submit" name="export_db">Download</button>
          </form>
        </section>

        <!-- Table -->
        <section class="main__content-table admin__content-table">
          <!-- Bootstrap Table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr class="table-secondary">
                  <th scope="col">No</th>
                  <th scope="col">SOA/UMP</th>
                  <th scope="col">SOPP</th>
                  <th scope="col">Departemen</th>
                  <th scope="col">Pemegang Anggaran</th>
                  <th scope="col">Jumlah Permintaan</th>
                  <th scope="col">Tanggal Masuk</th>
                  <th scope="col">Jam</th>
                  <th scope="col">Mata Anggaran</th>
                  <th scope="col">Perihal</th>
                  <th scope="col">Lokasi</th>
                  <th scope="col" id="statusfield-table">Status</th>
                  <th scope="col" id="button-table-action"></th>
                </tr>
              </thead>
              <tbody>
              <?php
                $soas = loadListDashboard();
                foreach($soas as $key=>$data){
                  date_default_timezone_set('UTC');
                  $userTimeZone = new DateTimeZone('Asia/Jakarta');
                  $soa_date_time = new DateTime($data['soa_created_at']);
                  $soa_date_time->setTimeZone($userTimeZone);
                  $soa_date = $soa_date_time->format('d-m-Y');
                  $soa_time = $soa_date_time->format('H:m');
                  $jumlah_permintaan = rupiah($data['soa_nominal']);

                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td class='soadata-table'>".$data['soa_no']."</td>";
                  echo "<td class='soadata-table'>".$data['soa_sopp']."</td>";
                  echo "<td>".$data['soa_departemen_name']."</td>";
                  echo "<td>".$data['soa_pa_name']."</td>";
                  echo "<td>".$jumlah_permintaan."</td>";
                  echo "<td>".$soa_date."</td>";
                  echo "<td>".$soa_time."</td>";
                  echo "<td>".$data['soa_ma']."</td>";
                  echo "<td>".$data['soa_perihal']."</td>";
                  echo "<td>".$data['soa_lokasi']."</td>";
                  echo "<td class='statusdata-table'>".$data['soa_status']."</td>";
                  echo "<td><button class='btn-edit'></button></td>";
                  echo "</tr>";
                }
              ?>
              </tbody>
            </table>
          </div>
        </section>

        <!-- Button Submit -->
        <section class="admin__content-footer">
          <a href="terima-dokumen.php" type="submit" class="btn btn-terima"><i class="fas fa-plus"></i> &MediumSpace; tambah dokumen</a>
        </section>
      </div>
    </main>

    <script src="../../js/main.js"></script>
    <script src="../../js/admin.js"></script>
    <!-- Bootstrap Dropdown requirements -->
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
