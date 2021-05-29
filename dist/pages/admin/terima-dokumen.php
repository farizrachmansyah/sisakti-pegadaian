<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Terima Dokumen</title>

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
    <main class="main terima">
      <!-- Header -->
      <div class="header-container">
        <div class="header-container-content flex">
          <div class="logo">
            <img src="../../assets/logo-login.png" alt="logo pegadaian" />
          </div>
          <div class="title">
            <h1>terima dokumen</h1>
          </div>
        </div>
      </div>

      <div class="main__content terima__content">
        <!-- Desc -->
        <section class="main__content-desc terima__content-desc flex">
          <div class="icon">
            <i class="fas fa-lightbulb"></i>
          </div>
          <p>Untuk menambah daftar penerimaan dokumen, isi setiap data yang dibutuhkan dengan benar.</p>
        </section>

        <!-- Form -->
        <section class="main__content-input terima__content-input">
          <form action="">
            <div class="soa flex flex-ai-c">
              <input id="soa" type="text" placeholder="SOA" required />
              <div class="soa-format">
                <p>/SOA-00108/2021</p>
              </div>
            </div>
            <select class="input" name="dept" id="">
              <option selected disabled>Departemen</option>
              <option value="02.01">Keuangan</option>
              <option value="03.01">SDM</option>
              <option value="04.01">Logistik</option>
              <option value="05.01">Legal Officer</option>
              <option value="06.01">Humas</option>
              <option value="07.01">Bussiness Support</option>
              <option value="08.01">Manajemen Risiko</option>
            </select>
            <div class="datetime flex">
              <input type="date" required />
              <input type="time" required />
            </div>
            <input type="number" placeholder="Mata Anggaran" required />
            <div class="permintaan flex flex-ai-c">
              <span>Rp. </span>
              <input type="number" placeholder="Jumlah Permintaan" required />
            </div>
            <select class="input" name="pemegang-anggaran" id="">
              <option selected disabled>Pemegang Anggaran</option>
              <option value="bs-analisa">KABAG Analisa Bisnis & Evaluasi Kerja</option>
              <option value="bs-distribusi">KABAG Jaringan Distribusi & Layanan</option>
              <option value="bs-pemasaran">KABAG Pemasaran & Penjualan</option>
              <option value="bs-kemitraan">KABAG Kemitraan Bina Lingkungan</option>
              <option value="sdm-pengembangan">KABAG Pengembangan SDM</option>
              <option value="sdm-operasional">KABAG Operasional SDM</option>
              <option value="sdm-budayakerja">KABAG Budaya Kerja & Manajemen Perubahan</option>
              <option value="logistik-pengadaan">KABAG Pengadaan & Logistik</option>
              <option value="logistik-bangunan">KABAG Bangunan & Pengamanan Korporasi</option>
              <option value="humas-protokoler">KABAG Humas & Protokoler</option>
              <option value="keuangan-aa">KABAG Anggaran & Akuntansi</option>
              <option value="keuangan-tresuri">KABAG Tresuri & Perpajakan</option>
              <option value="risiko-kredit">KABAG Risiko Kredit & Asuransi</option>
              <option value="risiko-operasional">KABAG Risiko Operasional & Kepatuhan</option>
            </select>
            <input type="text" placeholder="Perihal" required />
            <button type="submit">submit &MediumSpace; <i class="fas fa-file-export"></i></button>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/admin.js"></script>
  </body>
</html>