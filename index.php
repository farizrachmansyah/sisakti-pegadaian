<?php
    //sessionstart();
    if(!empty($_SESSION)){ }else{ session_start(); }
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $vlocation = "./dist/pages/";
        switch ($user["usr_jabatan"]) {
            case "Staf Admin":
              header("Location: ".$vlocation."admin/dashboard.php");
              break;
            case "KABAG Anggaran & Akuntansi":
              header("Location: ".$vlocation."kabag-aa/dashboard.php");
              break;
            case "KABAG Tresuri & Perpajakan":
              header("Location: ".$vlocation."kabag-tresuri/dashboard.php");
              break;
            case "Kepala Departemen Keuangan":
              header("Location: ".$vlocation."kadep/dashboard.php");
              break;
            default:
              header("Location: ".$vlocation."pemegang-anggaran/dashboard.php");
          }
          exit();
    }else{
        header("Location: "."login.php");
    }
?>