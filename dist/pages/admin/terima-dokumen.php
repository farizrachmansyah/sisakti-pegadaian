<?php
if(!empty($_SESSION)){ }else{ session_start(); }
require_once 'data.php';

if(isset($_POST['submit'])){
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];
    // filter data yang diinputkan
    $soa_akt = filter_input(INPUT_POST, 'aktivitas', FILTER_SANITIZE_STRING);
    $soa_no = filter_input(INPUT_POST, 'soa', FILTER_SANITIZE_STRING);
    $soa_sopp = filter_input(INPUT_POST, 'sopp', FILTER_SANITIZE_STRING);
    $soa_perihal = filter_input(INPUT_POST, 'perihal', FILTER_SANITIZE_STRING);
    $soa_nominal = filter_input(INPUT_POST, 'nominal', FILTER_SANITIZE_STRING);
    $soa_departemen_id = filter_input(INPUT_POST, 'departemen', FILTER_SANITIZE_STRING);
    $soa_pa_id = filter_input(INPUT_POST, 'pemegang-anggaran', FILTER_SANITIZE_STRING);

    // menyiapkan query
    $sql = "INSERT INTO tbl_soa (soa_akt_id, soa_no, soa_sopp, soa_perihal, soa_nominal, soa_departemen_id,soa_pa_id, soa_lastupdate_by, soa_lastupdate_status) 
            VALUES (:soa_akt, :soa_no, :soa_sopp, :soa_perihal,:soa_nominal, :soa_departemen_id, :soa_pa_id, :usr_id, 'Accepted')";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_akt" => $soa_akt,
        ":soa_no" => strval($soa_no)."/SOA-00108/2021",
        ":soa_sopp" => $soa_sopp,
        ":soa_perihal" => $soa_perihal,
        ":soa_nominal" => $soa_nominal,
        ":soa_departemen_id" => $soa_departemen_id,
        ":soa_pa_id" => $soa_pa_id,
        ":usr_id" => $userId
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
    <script src="../../js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#departemen").change(function(){
          var deptId = $("#departemen").val();
          $.ajax({
            url : 'data.php',
            method : 'post',
            data : 'deptId='+deptId
          }).done(function(users){
            console.log(users);
            parsedUsers = JSON.parse(users);
            $("#pemegang-anggaran").empty();
            parsedUsers.forEach(function(user){
              $("#pemegang-anggaran").append("<option value='"+user.usr_id+"'>"+ user.usr_jabatan+'</option>')
            })
          })
        })
      })
    </script>

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
          <span id="primary-warning"><i class="fas fa-exclamation-triangle"></i> &MediumSpace; SOA atau UMP harus terisi salah satu</span>
          <form action="" method="POST">
            <div id="kode-utama" class="flex">
              <div class="soa flex flex-ai-c">
                <input id="soa" class="soa-ump" type="text" placeholder="SOA" autocomplete="off" autofocus />
                <div class="soa-format">
                  <p>/SOA-00108/2021</p>
                </div>
              </div>
              <select name="ump" id="ump" class="input soa-ump ump">
                <option value="" selected>UMP</option>
                <?php
                $umps = loadUmp();
                foreach($umps as $ump){
                  echo "<option id='".$ump['ump_id']."' value='".$ump['ump_no']."'>".$ump['ump_no']."</option>";
                }
              ?>
              </select>
            </div>
            <input id="sopp" type="text" placeholder="SOPP" name="sopp" required />
            <select class="input" name="departemen" id="departemen">
              <option selected="" disabled="">Departemen</option>
              <?php
                $departmens = loadDepartemen();
                foreach($departmens as $departmen){
                  echo "<option id='".$departmen['mst_id']."' value='".$departmen['mst_id']."'>".$departmen['mst_text']."</option>";
                }
              ?>
              <!-- <option selected disabled>Departemen</option>
              <option value="02.01">Keuangan</option>
              <option value="03.01">SDM</option>
              <option value="04.01">Logistik</option>
              <option value="05.01">Legal Officer</option>
              <option value="06.01">Humas</option>
              <option value="07.01">Bussiness Support</option>
              <option value="08.01">Manajemen Risiko</option> -->
            </select>
            <select class="input" name="pemegang-anggaran" id="pemegang-anggaran">
              <option selected disabled>Pemegang Anggaran</option>
              <!-- <option value="bs-analisa">KABAG Analisa Bisnis & Evaluasi Kerja</option>
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
              <option value="risiko-operasional">KABAG Risiko Operasional & Kepatuhan</option> -->
            </select>

            <!-- <div class="datetime flex">
              <input type="date" required />
              <input type="time" required />
            </div> -->
             <select class="input" name="aktivitas" id="aktivitas">
              <option selected="" disabled="">Mata Anggaran</option>
              <?php
                $aktivitas = loadActivity();
                foreach($aktivitas as $data){
                  echo "<option id='".$data['akt_id']."' value='".$data['akt_id']."'>".$data['akt_name']." - ".$data['akt_ma_code']."</option>";
                }

              ?>
             
            </select>
            <!-- <input type="number" placeholder="Mata Anggaran" name="mata-anggaran" required/> -->
            <div class="permintaan flex flex-ai-c">
              <span>Rp. </span>
              <input type="number" placeholder="Jumlah Permintaan" name="nominal" required />
            </div>
            
            <input type="text" placeholder="Perihal" name="perihal" required />
            <button type="submit" name="submit">submit</button>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/admin.js"></script>
  </body>
</html>
