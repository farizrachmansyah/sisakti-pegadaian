<?php
if(!empty($_SESSION)){ }else{ session_start(); }
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT']);
require_once(ROOTPATH."/config.php");


if(isset($_POST['register'])){
    $user = $_SESSION["user"];
    $userId = $user["usr_id"];

    echo "alin";
    print_r($_POST);
    die();

    if(!isset($_SESSION["user"])||$userId=''){
      header("Location: ../../../login.php");
    }

    // filter data yang diinputkan
    $soa_no = filter_input(INPUT_POST, 'soa-regis', FILTER_SANITIZE_STRING);
    $ma = filter_input(INPUT_POST, 'ma', FILTER_SANITIZE_STRING);
    // $soa_no = filter_input(INPUT_GET, 'soa_no', FILTER_SANITIZE_STRING);
    $lastStatus = "Registered";
    
    // menyiapkan query
    $sql = "UPDATE tbl_soa SET soa_lastupdate_by = :usr_id, soa_lastupdate_status = :last_status where soa_no = :soa_no";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":soa_no" => $soa_no,
        ":usr_id" => $userId,
        ":last_status" => $lastStatus
    );    

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) header("Location: dashboard.php");
}


if(isset($_POST['deptId'])){
    global $db;
    $sql="SELECT usr_id, usr_jabatan FROM tbl_user WHERE usr_departemen_id = ".$_POST['deptId']." AND usr_create_access = 1";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
}

function loadDepartemen() {
    global $db;
    $sql="SELECT * FROM tbl_mstcode WHERE mst_category='DEPT'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $departmens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $departmens;
}
function loadSoa($psoa) {
    global $db;
    $sql="SELECT * FROM tbl_soa WHERE soa_no ='".$psoa."'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $soa = $stmt->fetch(PDO::FETCH_ASSOC);
    return $soa;
}
function loadListDashboard(){
    global $db;
    $sql="SELECT  soa_no,
     soa_sopp,
      (select mst_text from tbl_mstcode where mst_id = soa_departemen_id) as soa_departemen_name,
       (select usr_jabatan from tbl_user where usr_id = soa_pa_id) as  soa_pa_name,
       soa_nominal,
       (SELECT CONVERT_TZ(soa_created_at, '+00:00','+8:00')) as soa_created_at,
       (select usr_jabatan from tbl_user where usr_id = soa_lastupdate_by) as soa_lokasi,
       soa_lastupdate_status as soa_status FROM tbl_soa order by soa_id desc";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $soas;
}

function loadActivity() {
    global $db;
    $sql="SELECT akt_id,akt_code,akt_name,akt_ma_id,(select ma_code from tbl_mata_anggaran where ma_id = akt_ma_id) as akt_ma_code FROM tbl_aktivitas";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $aktivitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $aktivitas;
}
?>