<?php
session_start();
require_once 'data.php';

if(isset($_GET['soa'])){
    $soa_no = $_GET['soa'];
    $soa = loadPengembalianSoa($soa_no);
    
    $currRegNo = 0;
    $register_no_list = getCurrentRegisterNo();
    foreach($register_no_list as $key=>$data){
      $first4String = substr($data['soa_register_no'], 0, 4);
      $currNum = intval($first4String);
      if($currNum>$currRegNo){
        $currRegNo = $currNum;
      }
    }
    $regNo = str_pad($currRegNo + 1,4,'0',STR_PAD_LEFT)."/".$soa['soa_departemen_code']."/".$soa["soa_year"];
    
}

if(isset($_POST['reject'])){
    
    if(!isset($_SESSION["user"])||$userId=''){
      header("Location: ../../../login.php");
    }
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];
    
    // filter data yang diinputkan
    $lastStatus = "Pending";
    

    // menyiapkan query
    $sql = "UPDATE tbl_soa SET soa_lastupdate_status = :last_status where soa_no = :soa_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_no" => $soa['soa_no'],
        ":last_status" => $lastStatus
        
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
    <title>Pengembalian</title>

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
    <main class="main dokumen-action">
      <!-- Header -->
      <div class="header-container">
        <div class="header-container-content flex">
          <div class="logo">
            <img src="../../assets/logo-login.png" alt="logo pegadaian" />
          </div>
          <div class="title">
            <h1>Pengembalian Dokumen</h1>
          </div>
        </div>
      </div>

      <div class="main__content dokumen-action__content">
        <section class="main__content-form dokumen-action__content-form">
          <form class="flex" action="" method="POST">
            <input class="soa" type="text" name="soa-reject" disabled value = "<?php echo $soa['soa_no'] ?>"/>
            <select class="input" name="dept-reject" id="">
              <option selected disabled value = "<?php echo $soa['soa_departemen_name'] ?>"><?php echo $soa['soa_departemen_name'] ?></option>
            </select>
            <input class="penerima" type="text" name="penerima-reject" placeholder="Penerima" value = "<?php echo $soa['soa_lokasi'] ?>"/>
            <button class="btn reject" type="submit" name="reject">Return</button>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/admin.js"></script>
  </body>
</html>
