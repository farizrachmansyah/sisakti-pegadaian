<?php
if(!empty($_SESSION)){ }else{ session_start(); }
require_once 'data-ump.php';

if(isset($_POST['submit'])){
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];
    // filter data yang diinputkan
    $ump_bagian = filter_input(INPUT_POST, 'kode-bagian', FILTER_SANITIZE_STRING);
    $ump_no = filter_input(INPUT_POST, 'ump-no', FILTER_SANITIZE_STRING);
    $ump_fc = filter_input(INPUT_POST, 'fc', FILTER_SANITIZE_STRING);
    $ump_perihal = filter_input(INPUT_POST, 'perihal', FILTER_SANITIZE_STRING);
    $ump_nominal = filter_input(INPUT_POST, 'nominal', FILTER_SANITIZE_STRING);
    $ump_due_date = filter_input(INPUT_POST, 'jatuh-tempo', FILTER_SANITIZE_STRING);

    if($ump_fc == 'Y'){
     $sql = "INSERT INTO tbl_ump (ump_bagian_id, ump_no, ump_perihal, ump_nominal, is_fc,ump_due_date, ump_lastupdate_by, ump_lastupdate_status) 
            VALUES (:ump_bagian, :ump_no, :ump_perihal, :ump_nominal, :is_fc, :ump_due_date, :usr_id, 'Accepted')";
    $stmt = $db->prepare($sql);
    // bind parameter ke query
    $params = array(
        ":ump_bagian" => $ump_bagian,
        ":ump_no" => strval($ump_no)."/UMP-00108/2021",
        ":ump_perihal" => $ump_perihal,
        ":ump_nominal" => $ump_nominal,
        ":is_fc" => $ump_fc,
        ":ump_due_date" => $ump_due_date,
        ":usr_id" => $userId
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);
    
    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) header("Location: dashboard-ump.php");

    }else{
      $sql = "INSERT INTO tbl_ump (ump_bagian_id, ump_no, ump_perihal, ump_nominal, is_fc, ump_lastupdate_by, ump_lastupdate_status) 
            VALUES (:ump_bagian, :ump_no, :ump_perihal, :ump_nominal, :is_fc, :usr_id, 'Accepted')";
    $stmt = $db->prepare($sql);
    // bind parameter ke query
    $params = array(
        ":ump_bagian" => $ump_bagian,
        ":ump_no" => strval($ump_no)."/UMP-00108/2021",
        ":ump_perihal" => $ump_perihal,
        ":ump_nominal" => $ump_nominal,
        ":is_fc" => $ump_fc,
        ":usr_id" => $userId
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);
    
    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) header("Location: dashboard-ump.php");
    
    }

    // menyiapkan query
    
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah UMP</title>

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
            <h1>Tambah UMP</h1>
          </div>
        </div>
      </div>

      <div class="main__content terima__content">
        <!-- Desc -->
        <section class="main__content-desc terima__content-desc flex">
          <div class="icon">
            <i class="fas fa-lightbulb"></i>
          </div>
          <p>Untuk menambah daftar dokumen UMP, isi setiap data yang dibutuhkan dengan benar.</p>
        </section>

        <!-- Form -->
        <section class="main__content-input terima__content-input">
          <form action="" method="POST">
            <div class="ump flex flex-ai-c">
              <input id="ump" type="text" placeholder="UMP" name="ump-no" required />
              <div class="ump-format">
                <p>/UMP-00108/2021</p>
              </div>
            </div>
            <input type="text" name="perihal" placeholder="Perihal" name="perihal" required />
            <div class="nominal flex flex-ai-c">
              <span>Rp. </span>
              <input type="number" placeholder="Nominal" name="nominal" required />
            </div>
            <select class="input" name="kode-bagian" id="">
              <option selected disabled>Bagian</option>
              <?php
                $bagians = loadBagian();
                foreach($bagians as $bagian){
                  echo "<option id='".$bagian['mst_id']."' value='".$bagian['mst_id']."'>".$bagian['mst_code']." - ".$bagian['mst_text']."</option>";
                }
              ?>
            </select>
            <div class="fc input">
              <span>Fotocopy:</span>
              <label class="fc-radio">
                Ada
                <input type="radio" name="fc" id="fc-ada" value="Y"/>
                <span class="checkmark"></span>
              </label>
              <label class="fc-radio">
                Tidak Ada
                <input type="radio" name="fc" id="fc-gada" value="N" checked/>
                <span class="checkmark"></span>
              </label>
            </div>
            <input type="date" placeholder="Jatuh Tempo" name="jatuh-tempo"/>

            <button type="submit" name="submit">submit</button>
          </form>
        </section>
      </div>
    </main>

    <script src="../../../js/admin.js"></script>
    <script src="../../../js/ump.js"></script>
  </body>
</html>
