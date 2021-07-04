<?php
session_start();
require_once 'data-ump.php';

if(isset($_GET['ump'])){
    $ump_no = $_GET['ump'];
    $ump = loadUmp($ump_no);
}

if(isset($_POST['reject'])){
    
    if(!isset($_SESSION["user"])||$userId=''){
      header("Location: ../../../login.php");
    }
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];
    // filter data yang diinputkan
    $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);
    
    $lastStatus = "Rejected";
    
    // menyiapkan query
    $sql = "UPDATE tbl_ump SET ump_keterangan_reject= :ket_reject, ump_lastupdate_by = :usr_id, ump_lastupdate_status = :last_status where ump_no = :ump_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":ump_no" => $ump_no,
        ":ket_reject" => $keterangan,
        ":usr_id" => $userId,
        ":last_status" => $lastStatus
        
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) header("Location: dashboard-ump.php");
}

if(isset($_POST['confirm'])){
    
  if(!isset($_SESSION["user"])||$userId=''){
    header("Location: ../../../login.php");
  }
  $user = $_SESSION["user"];
  $userId = $user["usr_id"];
  // filter data yang diinputkan
  
  $lastStatus = "Accepted";
  
  // menyiapkan query
  $sql = "UPDATE tbl_ump SET ump_keterangan_reject= null,ump_lastupdate_by = :usr_id, ump_lastupdate_status = :last_status where ump_no = :ump_no";
  $stmt = $db->prepare($sql);

  // bind parameter ke query
  $params = array(
      ":ump_no" => $ump_no,
      ":usr_id" => $userId,
      ":last_status" => $lastStatus
      
  );

  // eksekusi query untuk menyimpan ke database
  $saved = $stmt->execute($params);

  // jika query simpan berhasil, maka user sudah terdaftar
  // maka alihkan ke halaman login
  if($saved) header("Location: dashboard-ump.php");
}

if(isset($_POST['cancel'])){
    
  if(!isset($_SESSION["user"])||$userId=''){
    header("Location: ../../../login.php");
  }else{
    header("Location: dashboard-ump.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi UMP</title>

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
    <!-- CSS NYA NUMPANG DI FILE TERIMIA DOKUMEN ADMIN -->
    <main class="main terima">
      <!-- Header -->
      <div class="header-container">
        <div class="header-container-content flex">
          <div class="logo">
            <img src="../../../assets/logo-login.png" alt="logo pegadaian" />
          </div>
          <div class="title">
            <h1>Konfirmasi UMP</h1>
          </div>
        </div>
      </div>

      <div class="main__content terima__content">
        <!-- Desc -->
        <section class="main__content-desc terima__content-desc flex">
          <div class="icon">
            <i class="fas fa-lightbulb"></i>
          </div>
          <p>Periksa apakah data dibawah sudah benar.</p>
        </section>

        <!-- Form -->
        <section class="main__content-input terima__content-input">
          <form action="" method="POST">
            <input id="ump" type="text" placeholder="UMP" disabled value='<?php echo $ump['ump_no']; ?>' />
            <input type="text" name="perihal" placeholder="Perihal" disabled value='<?php echo $ump['ump_perihal']; ?>' />
            <div class="nominal flex flex-ai-c">
              <span>Rp. </span>
              <input type="number" placeholder="Nominal" disabled value='<?php echo $ump['ump_nominal']; ?>'/>
            </div>
            <input type="text" name="kode-bagian" id="" placeholder="Kode Bagian" disabled value='<?php echo $ump['ump_bagian_code']." - ".$ump['ump_bagian_text']; ?>'/>
            <div class="fc input">
              <span>Fotocopy:</span>
              <label class="fc-radio">
                Ada
                <input type="radio" name="fc" id="fc-ada" disabled value ='Y' <?php if($ump['is_fc']=="Y") echo 'checked';?>/>
                <span class="checkmark"></span>
              </label>
              <label class="fc-radio">
                Tidak Ada
                <input type="radio" name="fc" id="fc-gada" disabled value ='N' <?php if($ump['is_fc']=="N") echo 'checked'; ?>/>
                <span class="checkmark"></span>
              </label>
            </div>
            <input type="text" placeholder="Jatuh Tempo" disabled value='<?php echo $ump['ump_due_date']; ?>'/>
            <input type="text" placeholder="Keterangan Rejected" name="keterangan" value='<?php echo $ump['ump_keterangan_reject']; ?>'/>

            <!-- buttonnya ubah -->
            <div class="option-btn flex flex-jc-sb">
              <button type="submit" name="cancel">cancel</button>
              <button type="submit" name="reject">reject</button>
              <button type="submit" name="confirm">confirm</button>
            </div>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/admin.js"></script>
  </body>
</html>
