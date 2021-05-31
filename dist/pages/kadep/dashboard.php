<?php
  require_once 'data.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SiSAKTI &MediumSpace;-&MediumSpace; KADEP</title>

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
    <main class="main kepala">
      <!-- Header -->
      <div class="header-container">
        <div class="header-container-content flex">
          <div class="content-top flex flex-ai-c">
            <div class="user">Kepala Departemen</div>
            <a href="../../../logout.php" class="logout"><i class="fas fa-sign-out-alt"></i></a>
          </div>
          <div class="content-bottom flex">
            <div class="logo">
              <img src="../../assets/logo-login.png" alt="logo pegadaian" />
            </div>
            <div class="title">
              <h1>daftar dokumen</h1>
            </div>
          </div>
        </div>
      </div>

      <div class="main__content kepala__content">
        <!-- Dropdown Menu -->
        <div class="dropdown show">
          <a
            class="btn dropdown-toggle"
            href="#"
            role="button"
            id="dropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="fas fa-file-signature"></i>&MediumSpace; Report
          </a>

          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="../report.html" data-linked="realisasi-ma">Jumlah Realisasi Per Mata Anggaran</a>
            <a class="dropdown-item" href="../report.html" data-linked="realisasi-dept">Jumlah Realisasi Per Departemen(Bulan/Tahun)</a>
            <a class="dropdown-item" href="../report.html" data-linked="realisasi-pa">Jumlah Realisasi Per Pemegang Anggaran</a>
            <a class="dropdown-item" href="../report.html" data-linked="total-soa-ma">Total SOA Per Mata Anggaran</a>
          </div>
        </div>

        <!-- Table -->
        <section class="main__content-table kepala__content-table">
          <!-- Bootstrap Table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">SOA</th>
                  <th scope="col">SOPP</th>
                  <th scope="col">Departemen</th>
                  <th scope="col">Tanggal Masuk</th>
                  <th scope="col">Jam</th>
                  <th scope="col">Mata Anggaran</th>
                  <th scope="col">Perihal</th>
                  <th scope="col">Lokasi</th>
                  <th scope="col" id="statusfield-table">Status</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
              <?php
                $soas = loadListDashboard();
                foreach($soas as $key=>$data){
                  $soa_date_time = new DateTime($data['soa_created_at']);
                  $soa_date = $soa_date_time->format('d-m-Y');
                  $soa_time = $soa_date_time->format('H:m');

                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td class='soadata-table'>".$data['soa_no']."</td>";
                  echo "<td class='soadata-table'>".$data['soa_sopp']."</td>";
                  echo "<td>".$data['soa_departemen_name']."</td>";
                  echo "<td>".$soa_date."</td>";
                  echo "<td>".$soa_time."</td>";
                  echo "<td>".$data['soa_ma']."</td>";
                  echo "<td>".$data['soa_perihal']."</td>";
                  echo "<td>".$data['soa_lokasi']."</td>";
                  echo "<td class='statusdata-table'>".$data['soa_status']."</td>";
                  echo "<td>""</td>";
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
    <script src="../../js/kabag-kadep.js"></script>
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