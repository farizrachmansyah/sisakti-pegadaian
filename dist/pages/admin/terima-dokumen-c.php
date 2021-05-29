<?php
require_once 'data.php';



if(isset($_POST['terima'])){
    // filter data yang diinputkan
    $soa_ma = filter_input(INPUT_POST, 'mata_anggaran', FILTER_SANITIZE_STRING);
    $soa_no = filter_input(INPUT_POST, 'soa', FILTER_SANITIZE_STRING);
    $soa_sopp = filter_input(INPUT_POST, 'sopp', FILTER_SANITIZE_STRING);
    $soa_perihal = filter_input(INPUT_POST, 'perihal', FILTER_SANITIZE_STRING);
    $soa_nominal = filter_input(INPUT_POST, 'nominal', FILTER_SANITIZE_STRING);
    $soa_departemen_id = filter_input(INPUT_POST, 'departemen', FILTER_SANITIZE_STRING);
    $soa_pa_id = filter_input(INPUT_POST, 'pemegang_anggaran', FILTER_SANITIZE_STRING);

    // menyiapkan query
    $sql = "INSERT INTO tbl_soa (soa_ma, soa_no, soa_sopp, soa_perihal, soa_nominal, soa_departemen_id,soa_pa_id) 
            VALUES (:soa_ma, :soa_no, :soa_sopp, :soa_perihal,:soa_nominal, :soa_departemen_id, :soa_pa_id)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_ma" => $soa_ma,
        ":soa_no" => $soa_no,
        ":soa_sopp" => $soa_sopp,
        ":soa_perihal" => $soa_perihal,
        ":soa_nominal" => $soa_nominal,
        ":soa_departemen_id" => $soa_departemen_id,
        ":soa_pa_id" => $soa_pa_id
    );
    

    // eksekusi query untuk menyimpan ke database
    //$saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    //if($saved) header("Location: login.php");
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
            parsedUsers.forEach()
          })
        })
      })
    </script>

  </head>
  <body>
    <main class="main">
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

      <div class="main__content">
        <!-- Desc -->
        <section class="main__content-desc flex">
          <div class="icon">
            <i class="fas fa-lightbulb"></i>
          </div>
          <p>Untuk menambah daftar penerimaan dokumen, isi setiap data yang dibutuhkan dengan benar.</p>
        </section>

        <!-- Form -->
        <section class="main__content-input">
          <form action="" method="POST">
            <input type="text" placeholder="SOA" name="soa" required/>
            <input type="text" placeholder="SOPP" name="sopp" required/>
            <select class="input" name="departemen" id="departemen">
            <option selected="" disabled="">Departemen</option>
            <?php
              $departmens = loadDepartemen();
              foreach($departmens as $departmen){
                echo "<option id='".$departmen['mst_id']."' value='".$departmen['mst_id']."'>".$departmen['mst_text']."</option>";
              }

            ?>
              <!-- <option value="0">Departemen</option>
              <option value="02.01">Keuangan</option>
              <option value="03.01">SDM</option>
              <option value="04.01">Logistik</option>
              <option value="05.01">Legal Officer</option>
              <option value="06.01">Humas</option>
              <option value="07.01">Bussiness Support</option>
              <option value="08.01">Manajemen Risiko</option> -->
            </select>
            <input type="text" placeholder="Mata Anggaran" name="mata_anggaran" required />
            <div class="permintaan flex flex-ai-c">
              <span>Rp. </span>
              <input type="number" placeholder="Jumlah Permintaan" name="nominal" required />
            </div>
            <select class="input" name="pemegang_anggaran" id="">            <input type="text" placeholder="Perihal" name="perihal" required />
              <option value="Kadep">Kadep</option>
              <option value="Kadep">Kabag</option>
            </select>
            <button type="submit" name="terima"><i class="fas fa-plus"></i> &MediumSpace; tambahkan</button>
          </form>
        </section>
      </div>
    </main>
  </body>
</html>