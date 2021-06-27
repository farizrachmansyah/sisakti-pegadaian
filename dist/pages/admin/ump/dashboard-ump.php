<?php
  session_start();
  require_once 'data-ump.php';

  function rupiah($angka){
	
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    return $hasil_rupiah;
   
  }
  $ump_no = '';
  if(isset($_GET['ump'])){
    if(!isset($_SESSION["user"])||$userId=''){
      header("Location: ../../../../login.php");
    }
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];
    $ump_no = $_GET['ump'];
    $lastStatus = "Done";

    $sql = "UPDATE tbl_ump SET ump_lastupdate_status = :last_status where ump_no = :ump_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":ump_no" => $ump_no,
        ":last_status" => $lastStatus   
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);
    if($saved) header("Location: dashboard-ump.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UMP &MediumSpace;-&MediumSpace; Staf Administrasi</title>

    <!-- Bootstrap -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="../../../css/main.min.css" />

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
        <input id="popup-registered-data" type="hidden" name="ump" />
        <button type="submit">Selesai</button>
      </form>
    </div>

    <main class="main admin">
      <!-- Header -->
      <div class="header-container">
        <div class="header-container-user flex flex-ai-c flex-jc-sb">
          <div class="btn-group">
            <a class="name btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Staf Admin - UMP
            </a>
            <div class="dropdown-menu">
              <a class="name-page dropdown-item" href="../dashboard.php">Halaman Utama</a>
              <a class="name-page dropdown-item" href="#">Halaman UMP</a>
            </div>
          </div>

          <a href="../../../../login.html" type="submit" class="logout">logout &MediumSpace;<i class="fas fa-sign-out-alt"></i></a>
        </div>

        <div class="header-container-content top-space flex">
          <div class="logo">
            <img src="../../../assets/logo-login.png" alt="logo pegadaian" />
          </div>
          <div class="title">
            <h1>daftar dokumen UMP</h1>
          </div>
        </div>
      </div>

      <div class="main__content admin__content">
        <!-- Table -->
        <section class="main__content-table admin__content-table">
          <!-- Bootstrap Table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr class="table-secondary">
                  <th scope="col">No</th>
                  <th scope="col">UMP</th>
                  <th scope="col">Register</th>
                  <th scope="col">Perihal</th>
                  <th scope="col">Nominal</th>
                  <th scope="col">Kode Bagian</th>
                  <th scope="col">FC</th>
                  <th scope="col">Jatuh Tempo</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Lokasi</th>
                  <th scope="col" id="statusfield-table">Status</th>
                  <th scope="col" id="button-table-action"></th>
                  <th scope="col" class="docid-ump">docID</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $umps = loadListDashboardUmp();
                foreach($umps as $key=>$data){
                  date_default_timezone_set('UTC');
                  $userTimeZone = new DateTimeZone('Asia/Jakarta');
                  $ump_date_time = new DateTime($data['ump_created_at']);
                  $ump_date_time->setTimeZone($userTimeZone);
                  $ump_date = $ump_date_time->format('d-m-Y');
                  $ump_time = $ump_date_time->format('H:m');
                  $jumlah_permintaan = rupiah($data['ump_nominal']);

                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td class='soadata-table'>".$data['ump_no']."</td>";
                  echo "<td>".$data['ump_register_no']."</td>";
                  echo "<td>".$data['ump_perihal']."</td>";
                  echo "<td>".$jumlah_permintaan."</td>";
                  echo "<td>".$data['ump_bagian_id']."</td>";
                  echo "<td>".$data['is_fc']."</td>";
                  echo "<td class='jtempo-data'>".$ump_date."</td>";
                  echo "<td>".$ump_time."</td>";
                  echo "<td>".$data['ump_lokasi']."</td>";
                  echo "<td class='statusdata-table'>".$data['ump_status']."</td>";
                  echo "<td><button class='btn-edit'></button></td>";
                  echo "<td class='docid-ump'>docId</td>";
                  echo "</tr>";
                }
              ?>
                <tr>
                  <td>3</td>
                  <td>003/UMP/01/2021</td>
                  <td></td>
                  <td>Biaya BBM Operasional Januari 2021</td>
                  <td>Rp. 20.000.000</td>
                  <td>4</td>
                  <td>icon ceklis</td>
                  <td class="jtempo-data">5-2-2021</td>
                  <td>tanggal</td>
                  <td>KABAG Tresuri & Perpajakan</td>
                  <td class="statusdata-table">register</td>
                  <td><button class='btn-edit'></button></td>
                  <td class="docid-ump">docId</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>003/UMP/01/2021</td>
                  <td></td>
                  <td>Biaya BBM Operasional Januari 2021</td>
                  <td>Rp. 20.000.000</td>
                  <td>4</td>
                  <td>icon ceklis</td>
                  <td class="jtempo-data">5-2-2021</td>
                  <td>tanggal</td>
                  <td>Kepala Departemen</td>
                  <td class="statusdata-table">registered</td>
                  <td><button class='btn-edit'></button></td>
                  <td class="docid-ump">docId</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>003/UMP/01/2021</td>
                  <td></td>
                  <td>Biaya BBM Operasional Januari 2021</td>
                  <td>Rp. 20.000.000</td>
                  <td>4</td>
                  <td>icon ceklis</td>
                  <td class="jtempo-data">5-2-2021</td>
                  <td>tanggal</td>
                  <td>KABAG Tresuri & Perpajakan</td>
                  <td class="statusdata-table">rejected</td>
                  <td><button class='btn-edit'></button></td>
                  <td class="docid-ump">docId</td>
                </tr>
                
              </tbody>
            </table>
          </div>
        </section>

        <!-- Button Submit -->
        <section class="admin__content-footer">
          <a href="./tambah-ump.php" type="submit" class="btn btn-terima"><i class="fas fa-plus"></i> &MediumSpace; tambah UMP</a>
        </section>
      </div>
    </main>

    <script src="../../../js/main.js"></script>
    <script src="../../../js/admin.js"></script>
    <script src="../../../js/ump.js"></script>
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