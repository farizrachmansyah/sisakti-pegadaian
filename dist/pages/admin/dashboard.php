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
    <main class="main admin">
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

      <div class="main__content admin__content">
        <!-- Table -->
        <section class="main__content-table admin__content-table">
          <!-- Bootstrap Table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr class="table-secondary">
                  <th scope="col">No</th>
                  <th scope="col">SOA</th>
                  <th scope="col">SOPP</th>
                  <th scope="col">Departemen</th>
                  <th scope="col">Pemegang Anggaran</th>
                  <th scope="col">Tanggal Masuk</th>
                  <th scope="col">Jam</th>
                  <th scope="col">Lokasi</th>
                  <th scope="col" id="statusfield-table">Status</th>
                  <th scope="col" id="button-table-action"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td class="soadata-table">0001</td>
                  <td class="soppdata-table">670</td>
                  <td>legal officer</td>
                  <td>KABAG Pengadaan & Logistik</td>
                  <td>01/07/21</td>
                  <td>08:00</td>
                  <td>KABAG Tresuri & Perpajakan</td>
                  <td class="statusdata-table">on progress</td>
                  <td>
                    <button class="btn-edit"></button>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td class="soadata-table">0002</td>
                  <td class="soppdata-table">682</td>
                  <td>humas</td>
                  <td>KABAG Operasional SDM</td>
                  <td>02/07/21</td>
                  <td>08:15</td>
                  <td>Staf Admin</td>
                  <td class="statusdata-table">accepted</td>
                  <td>
                    <button class="btn-edit"></button>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td class="soadata-table">0003</td>
                  <td class="soppdata-table">492</td>
                  <td>business support</td>
                  <td>KABAG Analisa Bisnis & Evaluasi Kinerja</td>
                  <td>03/07/21</td>
                  <td>08:25</td>
                  <td>KADEP Keuangan</td>
                  <td class="statusdata-table">rejected</td>
                  <td>
                    <button class="btn-edit"></button>
                  </td>
                </tr>
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
    <!-- Library SweetAlert2 buat modal/popup -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  </body>
</html>
