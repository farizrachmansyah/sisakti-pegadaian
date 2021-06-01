<?php
session_start();
require_once 'data.php';



if(isset($_GET['soa'])){
    $soa_no = $_GET['soa'];
    $soa = loadSoa($soa_no);
}

if(isset($_POST['submit'])){
    
    if(!isset($_SESSION["user"])||$userId=''){
      header("Location: ../../../login.php");
    }
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];
    // filter data yang diinputkan
    $sa = filter_input(INPUT_POST, 'sa', FILTER_SANITIZE_STRING);
    $ma = filter_input(INPUT_POST, 'ma', FILTER_SANITIZE_STRING);
    // $soa_no = filter_input(INPUT_GET, 'soa_no', FILTER_SANITIZE_STRING);
    
    if($sa == "Y" && $ma == "Y"){
        $lastStatus = "Accepted";
    }else{
        $lastStatus = "Rejected";
    }
    print_r($userId);

    // menyiapkan query
    $sql = "UPDATE tbl_soa SET is_ma = :is_ma, is_sa = :is_sa, soa_lastupdate_by = :usr_id, soa_lastupdate_status = :last_status where soa_no = :soa_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_no" => $soa_no,
        ":is_ma" => $ma,
        ":is_sa" => $sa,
        ":usr_id" => $userId,
        ":last_status" => $lastStatus
        
    );    

    print_r($params);
    die();

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
    <title>Konfirmasi Dokumen</title>

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
    <main class="main konfirmasi">
      <div class="header-container">
        <div class="header-container-content flex">
          <div class="logo">
            <img src="../../assets/logo-login.png" alt="logo pegadaian" />
          </div>
          <div class="title">
            <h1>konfirmasi dokumen</h1>
          </div>
        </div>
      </div>

      <div class="main__content konfirmasi__content">
        <section class="main__content-form konfirmasi__content-form">
          <form class="flex" method="POST">
            <div class="part profile">
              <input id="soafield" type="text" disabled name = "soa_no" value='<?php echo $soa['soa_no']; ?>'/>
              <input id="perihalfield" type="text" placeholder="Perihal" value='<?php echo $soa['soa_perihal'];?>'/>
            </div>

            <div class="part info">
              <p>Keterangan</p>
              <div class="info-choice ma">
                <label for="">Mata Anggaran</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="ma" id="1" value ='Y' <?php if($soa['is_ma']=="Y") echo 'checked'; ?>/>
                    sesuai
                  </div>
                  <div class="option">
                    <input type="radio" name="ma" id="2" value ='N' <?php if($soa['is_ma']=="N") echo 'checked'; ?>/>
                    tidak sesuai
                  </div>
                </div>
              </div>
              <div class="info-choice sa">
                <label for="">Saldo Anggaran</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="sa" id="1" value ='Y' <?php if($soa['is_sa']=="Y") echo 'checked'; ?>/>
                    tersedia
                  </div>
                  <div class="option">
                    <input type="radio" name="sa" id="2" value ='N' <?php if($soa['is_sa']=="N") echo 'checked'; ?>/>
                    tidak tersedia
                  </div>
                </div>
              </div>
              <span class="info-warning">Mohon dilakukan pergeseran mata anggaran</span>
            </div>

            <div class="part buttons flex flex-ai-c">
              <button type="submit" value="cancel">cancel</button>
              <button id="confirmBtn" type="submit" name="submit" value="confirm">konfirmasi</button>
            </div>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/kabag-kadep.js"></script>
  </body>
</html>
