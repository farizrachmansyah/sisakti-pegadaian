<?php
session_start();
require_once 'data.php';
function rupiah($angka){
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    return $hasil_rupiah;  
  }

if(isset($_GET['soa'])){
    $soa_no = $_GET['soa'];
    $soa = loadRegisterSoa($soa_no);

    $jumlah_anggaran = rupiah($soa['soa_nominal']);
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

if(isset($_POST['register'])){
    
    if(!isset($_SESSION["user"])||$userId=''){
      header("Location: ../../../login.php");
    }
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];
    
    // filter data yang diinputkan
    $lastStatus = "Registered";
    

    // menyiapkan query
    $sql = "UPDATE tbl_soa SET soa_lastupdate_by = :usr_id, soa_lastupdate_status = :last_status, soa_register_no = :register_no where soa_no = :soa_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_no" => $soa_no,
        ":usr_id" => $userId,
        ":register_no" => $regNo,
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
    <title>Register</title>

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
            <h1>Register SOA</h1>
          </div>
        </div>
      </div>

      <div class="main__content dokumen-action__content">
        <section class="main__content-form dokumen-action__content-form">
          <form class="flex" action="" method="POST">
            <input class="soa" type="text" name="soa-regis" value=<?php echo $soa['soa_no'];?> disabled />
            <input class="noregis" type="text" name="no-regis" value=<?php echo $regNo;?> disabled />
            <input class="permintaan" type="text" name="nominal-regis" value=<?php echo $jumlah_anggaran;?> disabled />
            <button class="btn" type="submit" name="register">Register</button>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/admin.js"></script>
  </body>
</html>