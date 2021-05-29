<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT']);
require_once(ROOTPATH."/config.php");

if(isset($_POST['deptId'])){
    global $db;
    $sql="SELECT * FROM tbl_user WHERE usr_departemen_id = ".$_POST['deptId'];
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
?>