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
    $rstrive = filter_input(INPUT_POST, 'strive', FILTER_SANITIZE_STRING);
    $rnota = filter_input(INPUT_POST, 'nota', FILTER_SANITIZE_STRING);
    $rspk = filter_input(INPUT_POST, 'spk', FILTER_SANITIZE_STRING);
    $rpks = filter_input(INPUT_POST, 'pks', FILTER_SANITIZE_STRING);
    $rpo = filter_input(INPUT_POST, 'po', FILTER_SANITIZE_STRING);
    $rpr = filter_input(INPUT_POST, 'pr', FILTER_SANITIZE_STRING);
    $rfaktur = filter_input(INPUT_POST, 'fp', FILTER_SANITIZE_STRING);
    $rkb = filter_input(INPUT_POST, 'kb', FILTER_SANITIZE_STRING);
    $rnpwp = filter_input(INPUT_POST, 'npwp', FILTER_SANITIZE_STRING);
    $rsiup = filter_input(INPUT_POST, 'siup', FILTER_SANITIZE_STRING);
    $rba = filter_input(INPUT_POST, 'ba', FILTER_SANITIZE_STRING);
    $rfoto = filter_input(INPUT_POST, 'foto', FILTER_SANITIZE_STRING);
    // $soa_no = filter_input(INPUT_GET, 'soa_no', FILTER_SANITIZE_STRING);
    
    if($rsopp == "Y" && $rnota == "Y" 
    && $rspk == "Y" && $rpks == "Y" 
    && $rpo == "Y" && $rpr == "Y" 
    && $rfaktur == "Y" && $rkb == "Y" 
    && $rnpwp == "Y" && $rsiup == "Y" 
    && $rba == "Y" && $rfoto == "Y"){
        $lastStatus = "Register";
    }else{
        $lastStatus = "Rejected";
    }

    // menyiapkan query
    $sql = "UPDATE tbl_soa SET is_sopp = :is_sopp, is_nd = :is_nota,
    is_spk = :is_spk, is_pks = :is_pks,
    is_po = :is_po, is_pr = :is_pr,
    is_fp = :is_fp, is_kb = :is_kb,
    is_npwp = :is_npwp, is_siup = :is_siup,
    is_ba = :is_ba, is_fss = :is_fss, is_strive = :is_strive,
    soa_lastupdate_by = :usr_id, soa_lastupdate_status = :last_status where soa_no = :soa_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_no" => $soa_no,
        ":is_sopp" => $rsopp,
        ":is_strive" => $rstrive,
        ":is_nota" => $rnota,
        ":is_spk" => $rspk,
        ":is_pks" => $rpks,
        ":is_po" => $rpo,
        ":is_pr" => $rpr,
        ":is_fp" => $rfaktur,
        ":is_kb" => $rkb,
        ":is_npwp" => $rnpwp,
        ":is_siup" => $rsiup,
        ":is_ba" => $rba,
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
                    <label for="sopp-4">
                      tidak perlu
                      <input type="radio" name="sopp" id="sopp-4" required value ='U' <?php if($soa['is_sopp']=="U") echo 'checked'; ?>/>
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
              <div class="info-choice strive">
                <label for="">Strive</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="strive-1">
                      ada
                      <input type="radio" name="strive" id="strive-1" required value ='Y' <?php if($soa['is_strive']=="Y") echo 'checked'; ?>/>
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="strive-2">
                      tidak ada
                      <input type="radio" name="strive" id="strive-2" required value ='N' <?php if($soa['is_strive']=="N") echo 'checked'; ?>/>
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div class="option">
                    <?php
                      if(isset($soa['is_strive'])&&$soa['is_strive']!="N"&&$soa['is_strive']!="Y"){
                        echo "<label for='strive-3'>";
                        echo $soa['is_sopp'];
                        echo "<input class='option-lainnya' type='radio' name='strive' id='strive-3' checked value='".$soa['is_strive']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='strive-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='strive' id='strive-3' required/>";
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
              <div class="info-choice kb">
                <label for="">Kwitansi Bermaterai</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="kb-1">
                      ada
                      <input type="radio" name="kb" id="kb-1" required value ='Y' <?php if($soa['is_kb']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="kb-2">
                      tidak ada
                      <input type="radio" name="kb" id="kb-2" required value ='N' <?php if($soa['is_kb']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_kb'])&&$soa['is_kb']!="N"&&$soa['is_kb']!="Y"){
                        echo "<label for='kb-3'>";
                        echo $soa['is_kb'];
                        echo "<input class='option-lainnya' type='radio' name='kb' id='kb-3' checked value='".$soa['is_kb']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='kb-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='kb' id='kb-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice fp">
                <label for="">Faktur Pajak</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="fp-1">
                      ada
                      <input type="radio" name="fp" id="fp-1" required value ='Y' <?php if($soa['is_fp']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="fp-2">
                      tidak ada
                      <input type="radio" name="fp" id="fp-2" required value ='N' <?php if($soa['is_fp']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_fp'])&&$soa['is_fp']!="N"&&$soa['is_fp']!="Y"){
                        echo "<label for='fp-3'>";
                        echo $soa['is_fp'];
                        echo "<input class='option-lainnya' type='radio' name='fp' id='kb-3' checked value='".$soa['is_fp']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='fp-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='fp' id='fp-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice spk">
                <label for="">Copy SPK</label>
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
              <div class="info-choice pks">
                <label for="">Copy PKS</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="pks-1">
                      ada
                      <input type="radio" name="pks" id="pks-1" required value ='Y' <?php if($soa['is_pks']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="pks-2">
                      tidak ada
                      <input type="radio" name="pks" id="pks-2" required value ='N' <?php if($soa['is_pks']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_pks'])&&$soa['is_pks']!="N"&&$soa['is_pks']!="Y"){
                        echo "<label for='pks-3'>";
                        echo $soa['is_pks'];
                        echo "<input class='option-lainnya' type='radio' name='pks' id='pks-3' checked value='".$soa['is_pks']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='pks-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='pks' id='pks-3' required/>";
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
              <div class="info-choice ba">
                <label for="">Berita Acara</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="ba-1">
                      ada
                      <input type="radio" name="ba" id="ba-1" required value ='Y' <?php if($soa['is_ba']=="Y") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                    <label for="ba-2">
                      tidak ada
                      <input type="radio" name="ba" id="ba-2" required value ='N' <?php if($soa['is_ba']=="N") echo 'checked'; ?>/>
                      <span class='checkmark'></span>
                    </label>
                  </div>
                  <div class="option">
                  <?php
                      if(isset($soa['is_ba'])&&$soa['is_ba']!="N"&&$soa['is_ba']!="Y"){
                        echo "<label for='ba-3'>";
                        echo $soa['is_ba'];
                        echo "<input class='option-lainnya' type='radio' name='ba' id='ba-3' checked value='".$soa['is_ba']."' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }else{
                        echo "<label for='ba-3'>";
                        echo " lainnya";
                        echo "<input class='option-lainnya' type='radio' name='ba' id='ba-3' required/>";
                        echo "<span class='checkmark'></span>";
                        echo "</label>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="info-choice siup">
                <label for="">Copy SIUP</label>
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
              <div class="info-choice npwp">
                <label for="">Copy KTP & NPWP</label>
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
              <div class="info-choice foto">
                <label for="">Foto Sebelum, Pengerjaan dan Sesudah</label>
                <div class="info-choice-options flex flex-ai-c">
                  <div class="option">
                    <label for="foto-1">
                      ada
                      <input type="radio" name="foto" id="foto-1" required value ='Y' <?php if($soa['is_fss']=="Y") echo 'checked'; ?>/>
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
              <button id="confirmBtn" type="submit" value="confirm" name="submit">register</button>
            </div>
          </form>
        </section>
      </div>
    </main>

    <script src="../../js/kabag-kadep.js"></script>
  </body>
</html>
