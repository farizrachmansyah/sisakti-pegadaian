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
          <div class="logo">
            <img src="../../assets/logo-login.png" alt="logo pegadaian" />
          </div>
          <div class="title">
            <h1>daftar dokumen</h1>
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
            <table class="table table-hover">
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
                </tr>
              </thead>
              <tbody>
                <tr data-linked="../konfirmasi-dokumen.html">
                  <td>1</td>
                  <td class="soadata-table">0001</td>
                  <td class="soppdata-table">670</td>
                  <td>manajemen risiko</td>
                  <td>01/07/21</td>
                  <td>08:00</td>
                  <td>1710101</td>
                  <td>Perpanjang Sewa UPC Grand Depok City 2 Tahun</td>
                  <td>KABAG Bangunan & Pengamanan Korporasi</td>
                  <td class="statusdata-table">on progress</td>
                </tr>
                <tr data-linked="../konfirmasi-dokumen.html">
                  <td>2</td>
                  <td class="soadata-table">0002</td>
                  <td class="soppdata-table">632</td>
                  <td>logistik</td>
                  <td>02/07/21</td>
                  <td>08:15</td>
                  <td>5143501</td>
                  <td>KABAG Operasional SDM</td>
                  <td>KABAG Anggaran & Akuntansi</td>
                  <td class="statusdata-table">accepted</td>
                </tr>
                <tr data-linked="../konfirmasi-dokumen.html">
                  <td>3</td>
                  <td class="soadata-table">0003</td>
                  <td class="soppdata-table">492</td>
                  <td>keuangan</td>
                  <td>03/07/21</td>
                  <td>08:25</td>
                  <td>5142301</td>
                  <td>KABAG Kemitraan Bina Lingkungan</td>
                  <td>KABAG Tresuri & Perpajakan</td>
                  <td class="statusdata-table">rejected</td>
                </tr>
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