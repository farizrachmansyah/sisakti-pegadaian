<?php 
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT']);
require_once("config.php");

if(isset($_POST['login'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM tbl_user WHERE usr_username=:username";
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":username" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if($user){
        // verifikasi password
        if(password_verify($password, $user["usr_password"])){
            // buat Session
            session_start();
            $_SESSION["user"] = $user;

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
            
            
        
          }else{
            header("location:login.php?loginStatus=gagal");
          }
    }else{
      header("location:login.php?loginStatus=gagal"); 
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SiSAKTI</title>
    <link rel="stylesheet" href="./dist/css/main.min.css" />

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
    <main class="login container">
      <header class="login__header"></header>
      <div class="login__content container--p flex flex-jc-sb">
        <!-- Teks di halaman login -->
        <section class="login__content-greetings">
          <div class="title">
            <h1>
              welcome to <br />
              <span>SiSAKTI</span>
            </h1>
          </div>
          <p>sistem administrasi keuangan & tresuri</p>
        </section>

        <!-- Form di halaman login -->
        <section class="login__content-form">
          <form autocomplete="off" action="" method="POST" class="flex">
            <div class="login__content-form-input flex">
              <div class="item flex flex-ai-c">
                <i class="fas fa-user"></i>
                <input type="username" name="username" id="username" placeholder="Username" autocomplete="off" required />
              </div>
              <div class="item flex flex-ai-c">
                <i class="fas fa-key"></i>
                <input type="password" name="password" id="password" placeholder="Password" required />
              </div>
            </div>
            <button class="login__content-form-button" type="submit" name="login">Login</button>
          </form>
        </section>
      </div>
    </main>

    <script src="./dist/js/main.js"></script>
  </body>
</html>
