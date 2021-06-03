<?php
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
    <title>SiSAKTI &MediumSpace;-&MediumSpace; Pemegang Anggaran</title>

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
    <main class="main">
      <!-- Header -->
      <div class="header-container">
        <div class="header-container-user flex flex-ai-c flex-jc-sb">
          <span class="name">Pemegang Anggaran</span>
          <a href="../../../logout.php" type="submit" class="logout">logout &MediumSpace;<i class="fas fa-sign-out-alt"></i></a>
        </div>

        <div class="header-container-content flex">
          <div class="logo">
            <img src="../../assets/logo-login.png" alt="logo pegadaian" />
          </div>
          <div class="title">
            <h1>daftar dokumen</h1>
          </div>
        </div>
      </div>

      <div class="main__content">
        <!-- Search Bar -->
        <section class="main__content-search">
          <form autocomplete="off" action="#" method="GET">
            <div class="find flex">
              <input autocomplete="off" type="text" name="soa" id="searchdata-soa" placeholder="SOA" onkeyup="searchTableData()" required />
              <button type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>
        </section>

        <!-- Table -->
        <section class="main__content-table">
          <!-- Bootstrap Table -->
          <div class="table-responsive">
            <table id="table-pa" class="table">
              <thead>
                <tr class="table-secondary">
                  <th scope="col">SOA</th>
                  <th scope="col">SOPP</th>
                  <th scope="col">Departemen</th>
                  <th scope="col">Pemegang Anggaran</th>
                  <th scope="col">Tanggal Masuk</th>
                  <th scope="col">Jam</th>
                  <th scope="col">Mata Anggaran</th>
                  <th scope="col">Jumlah Permintaan</th>
                  <th scope="col">Perihal</th>
                  <th scope="col">Lokasi</th>
                  <th scope="col" id="statusfield-table">Status</th>
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
                  echo "<td class='soadata-table'>".$data['soa_no']."</td>";
                  echo "<td class='soadata-table'>".$data['soa_sopp']."</td>";
                  echo "<td>".$data['soa_departemen_name']."</td>";
                  echo "<td>".$data['soa_pa_name']."</td>";
                  echo "<td>".$soa_date."</td>";
                  echo "<td>".$soa_time."</td>";
                  echo "<td>".$data['soa_ma']."</td>";
                  echo "<td>".$jumlah_permintaan."</td>";
                  echo "<td>".$data['soa_perihal']."</td>";
                  echo "<td>".$data['soa_lokasi']."</td>";
                  echo "<td class='statusdata-table'>".$data['soa_status']."</td>";
                  echo "</tr>";
                }
              ?>
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </main>

    <script src="../../js/main.js"></script>
  </body>
</html>
