<?php
 define('ROOTPATH', $_SERVER['DOCUMENT_ROOT']);
 require_once(ROOTPATH."/config.php"); 
 if(isset($_POST["export_ma"]))  { 
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
   //  print_r($soas);
   //  die();
    header('Content-Type: text/csv; charset=utf-8'); 

    header('Content-Disposition: attachment; filename=data.csv'); 

    $output = fopen("php://output", "w"); 

    fputcsv($output, array('Mata Anggaran', 'Aktivitas', 'Saldo', 'Realisasi')); 

    
    foreach($soas as $key=>$data){ 
           fputcsv($output, $data); 
    }
    fclose($output); 

 } 

 ?> 