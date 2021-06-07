<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT']);
require_once(ROOTPATH."/config.php");

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
    $sql="SELECT soa_no,
    soa_sopp,
    (select mst_text from tbl_mstcode where mst_id = soa_departemen_id) as soa_departemen_name,
    (select usr_jabatan from tbl_user where usr_id = soa_pa_id) as  soa_pa_name,
    soa_lastupdate_at as soa_created_at,
    (select ma_code from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma,
    soa_nominal,
    soa_perihal,
    (select usr_jabatan from tbl_user where usr_id = soa_lastupdate_by) as soa_lokasi,
    soa_lastupdate_status as soa_status
    FROM tbl_soa order by soa_id desc";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $soas;
}

function loadReportPerMataAnggaran(){
    global $db;
    $sql="SELECT
    (select ma_code from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma_code,
    (select ma_name from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma_name,
    '1000000000' as soa_saldo,
    SUM(soa_nominal) as soa_total_nominal
    FROM tbl_soa
    where soa_lastupdate_status = 'Registered'
    GROUP BY soa_ma_code";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $soas;
}

function loadReportPerDepartemen($start_date,$end_date){
    global $db;
    $sql="SELECT
    (select mst_text from tbl_mstcode where mst_id = soa_departemen_id) as soa_departemen,
    (SELECT CONVERT_TZ(soa_lastupdate_at,'+00:00','+7:00')) as soa_lastupdate_at,
    SUM(soa_nominal) as soa_total_nominal
    FROM tbl_soa
    where soa_lastupdate_status = 'Registered' AND (SELECT CONVERT_TZ(soa_lastupdate_at,'+00:00','+7:00') between '".$start_date."' and '".$end_date." 23:59:59')
    GROUP BY soa_departemen;";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $soas;
}

function loadReportPerPemegangAnggaran(){
    global $db;
    $sql="SELECT
    (select usr_jabatan from tbl_user where usr_id = soa_pa_id) as soa_pa,
    SUM(soa_nominal) as soa_total_nominal
    FROM tbl_soa
    where soa_lastupdate_status = 'Registered'
    GROUP BY soa_pa_id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $soas;
}

function loadReportTotalSoaMataAnggaran(){
    global $db;
    $sql="SELECT
    (select ma_code from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma_code,
    (select ma_name from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma_name,
    count(soa_id) as soa_total_count
    FROM tbl_soa
    where soa_lastupdate_status = 'Registered'
    GROUP BY soa_ma_code";
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