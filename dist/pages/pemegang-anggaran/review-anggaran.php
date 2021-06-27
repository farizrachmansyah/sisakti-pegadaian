<?php
session_start();
require_once 'data.php';

if(isset($_GET['soa'])){
    $soa_no = $_GET['soa'];
    $soa = loadSoa($soa_no);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Review Anggaran</title>

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
            <h1>review anggaran</h1>
          </div>
        </div>
      </div>

      <div class="main__content konfirmasi__content">
        <section class="main__content-form konfirmasi__content-form">
          <form class="flex" method="">
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
                    <label for="ma-1">
                      sesuai
                      <input type="radio" name="ma" id="ma-1" value ='Y' disabled <?php if($soa['is_ma']=="Y") echo 'checked'; ?>/>
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="ma-2">
                      tidak sesuai
                      <input type="radio" name="ma" id="ma-2" value ='N' disabled <?php if($soa['is_ma']=="N") echo 'checked'; ?>/>
                      <span class="checkmark"></span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="info-choice sa">
                <label for="">Saldo Anggaran</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="sa-1">
                      tersedia
                      <input type="radio" name="sa" id="sa-1" value ='Y' disabled <?php if($soa['is_sa']=="Y") echo 'checked'; ?>/>
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="sa-2">
                      tidak tersedia
                      <input type="radio" name="sa" id="sa-2" value ='N' disabled <?php if($soa['is_sa']=="N") echo 'checked'; ?>/>
                      <span class="checkmark"></span>
                    </label>
                  </div>
                </div>
              </div>
              <span class="info-warning">Mohon dilakukan pergeseran mata anggaran</span>
            </div>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/pemegang-anggaran.js"></script>
  </body>
</html>
