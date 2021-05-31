<?php
session_start();
require_once 'data.php';


if(isset($_GET['soa'])){
    $soa_no = $_GET['soa'];
    $soa = loadSoa($soa_no);
}

if(isset($_POST['submit'])){
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];

    // filter data yang diinputkan
    $rsopp = filter_input(INPUT_POST, 'sopp', FILTER_SANITIZE_STRING);
    $rnota = filter_input(INPUT_POST, 'nota', FILTER_SANITIZE_STRING);
    $rspk = filter_input(INPUT_POST, 'spk', FILTER_SANITIZE_STRING);
    $rpkb = filter_input(INPUT_POST, 'pkb', FILTER_SANITIZE_STRING);
    $rpo = filter_input(INPUT_POST, 'po', FILTER_SANITIZE_STRING);
    $rpr = filter_input(INPUT_POST, 'pr', FILTER_SANITIZE_STRING);
    $rfaktur = filter_input(INPUT_POST, 'faktur', FILTER_SANITIZE_STRING);
    $rktp = filter_input(INPUT_POST, 'ktp', FILTER_SANITIZE_STRING);
    $rnpwp = filter_input(INPUT_POST, 'npwp', FILTER_SANITIZE_STRING);
    $rsiup = filter_input(INPUT_POST, 'siup', FILTER_SANITIZE_STRING);
    $rtdp = filter_input(INPUT_POST, 'tdp', FILTER_SANITIZE_STRING);
    $rfoto = filter_input(INPUT_POST, 'foto', FILTER_SANITIZE_STRING);
    // $soa_no = filter_input(INPUT_GET, 'soa_no', FILTER_SANITIZE_STRING);
    
    if($rsopp == "Y" && $rnota == "Y" 
    && $rspk == "Y" && $rpkb == "Y" 
    && $rpo == "Y" && $rpr == "Y" 
    && $rfaktur == "Y" && $rktp == "Y" 
    && $rnpwp == "Y" && $rsiup == "Y" 
    && $rtdp == "Y" && $rfoto == "Y"){
        $lastStatus = "Register";
    }else{
        $lastStatus = "Rejected";
    }

    // menyiapkan query
    $sql = "UPDATE tbl_soa SET is_sopp = :is_sopp, is_nd = :is_nota,
    is_spk = :is_spk, is_pkb = :is_pkb,
    is_po = :is_po, is_pr = :is_pr,
    is_fp = :is_fp, is_ktp = :is_ktp,
    is_npwp = :is_npwp, is_siup = :is_siup,
    is_tdp = :is_tdp, is_fss = :is_fss,
    soa_lastupdate_by = :usr_id, soa_lastupdate_status = :last_status where soa_no = :soa_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_no" => $soa_no,
        ":is_sopp" => $rsopp,
        ":is_nota" => $rnota,
        ":is_spk" => $rspk,
        ":is_pkb" => $rpkb,
        ":is_po" => $rpo,
        ":is_pr" => $rpr,
        ":is_fp" => $rfaktur,
        ":is_ktp" => $rktp,
        ":is_npwp" => $rnpwp,
        ":is_siup" => $rsiup,
        ":is_tdp" => $rtdp,
        ":is_fss" => $rfoto,
        ":usr_id" => $userId,
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
              <div class="info-choice sopp">
                <label for="">SOPP</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="sopp" id="1" required value ='Y' <?php if($soa['is_sopp']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="sopp" id="2" required value ='N' <?php if($soa['is_sopp']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="sopp" id="3" required />
                    lainnya
                  </div>
                </div>
              </div>
              <div class="info-choice notadinas">
                <label for="">Nota Dinas</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="nota" id="1" required value ='Y' <?php if($soa['is_nd']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="nota" id="2" required value ='N' <?php if($soa['is_nd']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="nota" id="3" required />
                    lainnya
                  </div>
                </div>
              </div>
              <div class="info-choice spk">
                <label for="">SPK</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="spk" id="1" required value ='Y' <?php if($soa['is_spk']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="spk" id="2" required value ='N' <?php if($soa['is_spk']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="spk" id="3" required />
                    lainnya
                  </div>
                </div>
              </div>
              <div class="info-choice pkb">
                <label for="">PKB</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="pkb" id="1" required value ='Y' <?php if($soa['is_pkb']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="pkb" id="2" required value ='N' <?php if($soa['is_pkb']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="pkb" id="3" required />
                    lainnya
                  </div>
                </div>
              </div>
              <div class="info-choice po">
                <label for="">PO</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option"><input type="radio" name="po" id="1" / required value ='Y' <?php if($soa['is_po']=="Y") echo 'checked'; ?>> ada</div>
                  <div class="option"><input type="radio" name="po" id="2" / required value ='N' <?php if($soa['is_po']=="N") echo 'checked'; ?>> tidak ada</div>
                  <div class="option"><input class="option-lainnya" type="radio" name="po" id="3" / required> lainnya</div>
                </div>
              </div>
              <div class="info-choice pr">
                <label for="">PR</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option"><input type="radio" name="pr" id="1" / required value ='Y' <?php if($soa['is_pr']=="Y") echo 'checked'; ?>> ada</div>
                  <div class="option"><input type="radio" name="pr" id="2" / required value ='N' <?php if($soa['is_pr']=="N") echo 'checked'; ?>> tidak ada</div>
                  <div class="option"><input class="option-lainnya" type="radio" name="pr" id="3" / required> lainnya</div>
                </div>
              </div>
              <div class="info-choice fakturpajak">
                <label for="">Faktur Pajak</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="faktur" id=" required1" value ='Y' <?php if($soa['is_fp']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="faktur" id=" required2" value ='N' <?php if($soa['is_fp']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="faktur" id=" required3" />
                    lainnya
                  </div>
                </div>
              </div>
              <div class="info-choice ktp">
                <label for="">KTP</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="ktp" id="1" required value ='Y' <?php if($soa['is_ktp']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="ktp" id="2" required value ='N' <?php if($soa['is_ktp']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="ktp" id="3" required />
                    lainnya
                  </div>
                </div>
              </div>
              <div class="info-choice npwp">
                <label for="">NPWP</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="npwp" id="1" required value ='Y' <?php if($soa['is_npwp']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="npwp" id="2" required value ='N' <?php if($soa['is_npwp']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="npwp" id="3" required />
                    lainnya
                  </div>
                </div>
              </div>
              <div class="info-choice siup">
                <label for="">SIUP</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="siup" id="1" required value ='Y' <?php if($soa['is_siup']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="siup" id="2" required value ='N' <?php if($soa['is_siup']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="siup" id="3" required />
                    lainnya
                  </div>
                </div>
              </div>
              <div class="info-choice tdp">
                <label for="">TDP</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="tdp" id="1" required value ='Y' <?php if($soa['is_tdp']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="tdp" id="2" required value ='N' <?php if($soa['is_tdp']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="tdp" id="3" required />
                    lainnya
                  </div>
                </div>
              </div>
              <div class="info-choice foto">
                <label for="">Foto Sebelum/Sesudah</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <input type="radio" name="foto" id="1" required value ='Y' <?php if($soa['is_fss']=="Y") echo 'checked'; ?>/>
                    ada
                  </div>
                  <div class="option">
                    <input type="radio" name="foto" id="2" required value ='N' <?php if($soa['is_fss']=="N") echo 'checked'; ?>/>
                    tidak ada
                  </div>
                  <div class="option">
                    <input class="option-lainnya" type="radio" name="foto" id="3" required />
                    lainnya
                  </div>
                </div>
              </div>
            </div>

            <div class="part buttons flex flex-ai-c">
              <button type="submit" value="save">simpan</button>
              <button id="confirmBtn" type="submit" value="confirm" name="submit">register</button>
            </div>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/kabag-kadep.js"></script>
  </body>
</html>
