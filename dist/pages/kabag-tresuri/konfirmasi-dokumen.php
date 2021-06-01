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
        $lastStatus = "Accepted";
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
                    <label for="sopp-1">
                      ada
                      <input type="radio" name="sopp" id="sopp-1" required value ='Y' <?php if($soa['is_sopp']=="Y") echo 'checked'; ?>/>
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="sopp-2">
                      tidak ada
                      <input type="radio" name="sopp" id="sopp-2" required value ='N' <?php if($soa['is_sopp']=="N") echo 'checked'; ?>/>
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div class="option">
                    <?php
                      if(isset($soa['is_sopp'])&&$soa['is_sopp']!="N"&&$soa['is_sopp']!="Y"){
                        echo "<label for='sopp-3'>";
                        echo $soa['is_sopp'];
                        echo "<input class='option-lainnya' type='radio' name='sopp' id='sopp-3' checked value='".$soa['is_sopp']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='sopp-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='sopp' id='sopp-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice notadinas">
                <label for="">Nota Dinas</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="nota-1">
                      ada
                      <input type="radio" name="nota" id="nota-1" required value ='Y' <?php if($soa['is_nd']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="nota-2">
                      tidak ada
                      <input type="radio" name="nota" id="nota-2" required value ='N' <?php if($soa['is_nd']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_nd'])&&$soa['is_nd']!="N"&&$soa['is_nd']!="Y"){
                        echo "<label for='nota-3'>";
                        echo $soa['is_nd'];
                        echo "<input class='option-lainnya' type='radio' name='nota' id='nota-3' checked value='".$soa['is_nd']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='nota-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='nota' id='nota-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice spk">
                <label for="">SPK</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="spk-1">
                      ada
                      <input type="radio" name="spk" id="spk-1" required value ='Y' <?php if($soa['is_spk']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="spk-2">
                      tidak ada
                      <input type="radio" name="spk" id="spk-2" required value ='N' <?php if($soa['is_spk']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_spk'])&&$soa['is_spk']!="N"&&$soa['is_spk']!="Y"){
                        echo "<label for='spk-3'>";
                        echo $soa['is_spk'];
                        echo "<input class='option-lainnya' type='radio' name='spk' id='spk-3' checked value='".$soa['is_spk']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='spk-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='spk' id='spk-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice pkb">
                <label for="">PKB</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="pkb-1">
                      ada
                      <input type="radio" name="pkb" id="pkb-1" required value ='Y' <?php if($soa['is_pkb']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="pkb-2">
                      tidak ada
                      <input type="radio" name="pkb" id="pkb-2" required value ='N' <?php if($soa['is_pkb']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_pkb'])&&$soa['is_pkb']!="N"&&$soa['is_pkb']!="Y"){
                        echo "<label for='pkb-3'>";
                        echo $soa['is_pkb'];
                        echo "<input class='option-lainnya' type='radio' name='pkb' id='pkb-3' checked value='".$soa['is_pkb']."' required/>";
                        echo "<span class='checkmark'></span>"
                        echo "</label>"
                      }else{
                        echo "<label for='pkb-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='pkb' id='pkb-3' required/>";
                        echo "<span class='checkmark'></span>"
                        echo "</label>"
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice po">
                <label for="">PO</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="po-1">
                      ada
                      <input type="radio" name="po" id="po-1" / required value ='Y' <?php if($soa['is_po']=="Y") echo 'checked'; ?> />
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="po-2">
                      tidak ada
                      <input type="radio" name="po" id="po-2" / required value ='N' <?php if($soa['is_po']=="N") echo 'checked'; ?> />
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_po'])&&$soa['is_po']!="N"&&$soa['is_po']!="Y"){
                        echo "<label for='po-3'>";
                        echo $soa['is_po'];
                        echo "<input class='option-lainnya' type='radio' name='po' id='po-3' checked value='".$soa['is_po']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='po-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='po' id='po-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice pr">
                <label for="">PR</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="pr-1">
                      ada
                      <input type="radio" name="pr" id="pr-1" / required value ='Y' <?php if($soa['is_pr']=="Y") echo 'checked'; ?> />
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="pr-2">
                      tidak ada
                      <input type="radio" name="pr" id="pr-2" / required value ='N' <?php if($soa['is_pr']=="N") echo 'checked'; ?> />
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_pr'])&&$soa['is_pr']!="N"&&$soa['is_pr']!="Y"){
                        echo "<label for='pr-3'>";
                        echo $soa['is_pr'];
                        echo "<input class='option-lainnya' type='radio' name='pr' id='pr-3' checked value='".$soa['is_pr']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='pr-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='pr' id='pr-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice fakturpajak">
                <label for="">Faktur Pajak</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="pajak-1">
                      ada
                      <input type="radio" name="faktur" id=" pajak-1" value ='Y' <?php if($soa['is_fp']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="pajak-2">
                      tidak ada
                      <input type="radio" name="faktur" id=" pajak-2" value ='N' <?php if($soa['is_fp']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_fp'])&&$soa['is_fp']!="N"&&$soa['is_fp']!="Y"){
                        echo "<label for='pajak-3'>";
                        echo $soa['is_fp'];
                        echo "<input class='option-lainnya' type='radio' name='faktur' id='pajak-3' checked value='".$soa['is_fp']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='pajak-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='faktur' id='pajak-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice ktp">
                <label for="">KTP</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="ktp-1">
                      ada
                      <input type="radio" name="ktp" id="ktp-1" required value ='Y' <?php if($soa['is_ktp']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="ktp-2">
                      tidak ada
                      <input type="radio" name="ktp" id="ktp-2" required value ='N' <?php if($soa['is_ktp']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_ktp'])&&$soa['is_ktp']!="N"&&$soa['is_ktp']!="Y"){
                        echo "<label for='ktp-3'>";
                        echo $soa['is_ktp'];
                        echo "<input class='option-lainnya' type='radio' name='ktp' id='ktp-3' checked value='".$soa['is_ktp']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='ktp-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='ktp' id='ktp-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice npwp">
                <label for="">NPWP</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="npwp-1">
                      ada
                      <input type="radio" name="npwp" id="npwp-1" required value ='Y' <?php if($soa['is_npwp']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="npwp-2">
                      tidak ada
                      <input type="radio" name="npwp" id="npwp-2" required value ='N' <?php if($soa['is_npwp']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_npwp'])&&$soa['is_npwp']!="N"&&$soa['is_npwp']!="Y"){
                        echo "<label for='npwp-3'>";
                        echo $soa['is_npwp'];
                        echo "<input class='option-lainnya' type='radio' name='npwp' id='npwp-3' checked value='".$soa['is_npwp']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='npwp-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='npwp' id='npwp-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice siup">
                <label for="">SIUP</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="siup-1">
                      ada
                      <input type="radio" name="siup" id="siup-1" required value ='Y' <?php if($soa['is_siup']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="siup-2">
                      tidak ada
                      <input type="radio" name="siup" id="siup-2" required value ='N' <?php if($soa['is_siup']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_siup'])&&$soa['is_siup']!="N"&&$soa['is_siup']!="Y"){
                        echo "<label for='siup-3'>";
                        echo $soa['is_siup'];
                        echo "<input class='option-lainnya' type='radio' name='siup' id='siup-3' checked value='".$soa['is_siup']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='siup-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='siup' id='siup-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice tdp">
                <label for="">TDP</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="tdp-1">
                      ada
                      <input type="radio" name="tdp" id="tdp-1" required value ='Y' <?php if($soa['is_tdp']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="tdp-2">
                      tidak ada
                      <input type="radio" name="tdp" id="tdp-2" required value ='N' <?php if($soa['is_tdp']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_tdp'])&&$soa['is_tdp']!="N"&&$soa['is_tdp']!="Y"){
                        echo "<label for='tdp-3'>";
                        echo $soa['is_tdp'];
                        echo "<input class='option-lainnya' type='radio' name='tdp' id='tdp-3' checked value='".$soa['is_tdp']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='tdp-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='tdp' id='tdp-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice foto">
                <label for="">Foto Sebelum/Sesudah</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="foto-1">
                      ada
                      <input type="radio" name="foto" id="foto-1" required value ='Y' <?php if($soa['is_fss']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="foto-2">
                      tidak ada
                      <input type="radio" name="foto" id="foto-2" required value ='N' <?php if($soa['is_fss']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <?php
                      if(isset($soa['is_fss'])&&$soa['is_fss']!="N"&&$soa['is_fss']!="Y"){
                        echo "<label for='foto-3'>";
                        echo $soa['is_fss'];
                        echo "<input class='option-lainnya' type='radio' name='foto' id='foto-3' checked value='".$soa['is_fss']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='foto-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='foto' id='foto-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="part buttons flex flex-ai-c">
              <button type="submit" value="cancel">cancel</button>
              <button id="confirmBtn" type="submit" value="confirm" name="submit">konfirmasi</button>
            </div>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/kabag-kadep.js"></script>
  </body>
</html>
