<?php
 define('ROOTPATH', $_SERVER['DOCUMENT_ROOT']);
 require_once(ROOTPATH."/config.php"); 
 date_default_timezone_set('UTC');
 $userTimeZone = new DateTimeZone('Asia/Jakarta');
 $nowDate = date("Y-m-d");
 $nowDateConverted = new DateTime($nowDate);
 $nowDateConverted->setTimeZone($userTimeZone);
 $nowDay = $nowDateConverted->format('Ymd');
 if(isset($_POST["export_ma"]))  { 
    global $db;
    $sql="SELECT
    (select ma_code from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma_code,
    (select ma_name from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma_name,
    '1000000000' as soa_saldo,
    SUM(soa_nominal) as soa_total_nominal
    FROM tbl_soa
    where soa_lastupdate_status = 'Done'
    GROUP BY soa_ma_code";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
   //  print_r($soas);
   //  die();
    header('Content-Type: text/csv; charset=utf-8'); 
    $fileName = "Report_Per_Mata_Anggaran_".$nowDay;
    header("Content-Disposition: attachment; filename=".$fileName.".csv"); 

    $output = fopen("php://output", "w"); 

    fputcsv($output, array('Mata Anggaran', 'Aktivitas', 'Saldo', 'Realisasi')); 

    
    foreach($soas as $key=>$data){ 
           fputcsv($output, $data); 
    }
    fclose($output); 

 }
 
 if(isset($_POST["export_dept"]))  { 
   $start_date=$_POST["from"];   
   $end_date=$_POST["to"];  
   global $db;
   $sql="SELECT
   (select mst_text from tbl_mstcode where mst_id = soa_departemen_id) as soa_departemen,
   SUM(soa_nominal) as soa_total_nominal
   FROM tbl_soa
   where soa_lastupdate_status = 'Done' AND (SELECT CONVERT_TZ(soa_lastupdate_at,'+00:00','+7:00') between '".$start_date."' and '".$end_date." 23:59:59')
   GROUP BY soa_departemen";
   $stmt = $db->prepare($sql);
   $stmt->execute();
   $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  //  print_r($soas);
  //  die();
   header('Content-Type: text/csv; charset=utf-8'); 
   $fileName = "Report_Departemen_F".$start_date."_T".$end_date;
   header("Content-Disposition: attachment; filename=".$fileName.".csv"); 

   $output = fopen("php://output", "w"); 

   fputcsv($output, array('Departemen','Realisasi')); 

   
   foreach($soas as $key=>$data){ 
          fputcsv($output, $data); 
   }
   fclose($output); 

}

if(isset($_POST["export_pa"]))  { 
   global $db;
   $sql="SELECT
   (select usr_jabatan from tbl_user where usr_id = soa_pa_id) as soa_pa,
   SUM(soa_nominal) as soa_total_nominal
   FROM tbl_soa
   where soa_lastupdate_status = 'Done'
   GROUP BY soa_pa_id";
   $stmt = $db->prepare($sql);
   $stmt->execute();
   $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  //  print_r($soas);
  //  die();
   header('Content-Type: text/csv; charset=utf-8'); 
   $fileName = "Report_Per_Pemegang_Anggaran_".$nowDay;
   header("Content-Disposition: attachment; filename=".$fileName.".csv"); 

   $output = fopen("php://output", "w"); 

   fputcsv($output, array('Pemegang Anggaran', 'Realisasi')); 

   
   foreach($soas as $key=>$data){ 
          fputcsv($output, $data); 
   }
   fclose($output); 

}

if(isset($_POST["export_soa"]))  { 
   global $db;
   $sql="SELECT
   (select ma_code from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma_code,
   (select ma_name from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma_name,
   count(soa_id) as soa_total_count
   FROM tbl_soa
   where soa_lastupdate_status = 'Done'
   GROUP BY soa_ma_code";
   $stmt = $db->prepare($sql);
   $stmt->execute();
   $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  //  print_r($soas);
  //  die();
   header('Content-Type: text/csv; charset=utf-8'); 
   $fileName = "Report_Soa_Per_Mata_Anggaran_".$nowDay;
   header("Content-Disposition: attachment; filename=".$fileName.".csv"); 

   $output = fopen("php://output", "w"); 

   fputcsv($output, array('Mata Anggaran', 'Aktivitas', 'Total Soa')); 

   
   foreach($soas as $key=>$data){ 
          fputcsv($output, $data); 
   }
   fclose($output); 

}

if(isset($_POST["export_db"]))  { 
       global $db;
       $sql="SELECT  soa_no,
       soa_sopp,
        (select mst_text from tbl_mstcode where mst_id = soa_departemen_id) as soa_departemen_name,
         (select usr_jabatan from tbl_user where usr_id = soa_pa_id) as  soa_pa_name,
         soa_nominal,
         soa_perihal,
         (select ma_name from tbl_mata_anggaran where ma_id = (select akt_ma_id from tbl_aktivitas where akt_id = soa_akt_id)) as soa_ma,
         soa_lastupdate_at as soa_date FROM tbl_soa order by soa_id desc";
       $stmt = $db->prepare($sql);
       $stmt->execute();
       $soas = $stmt->fetchAll(PDO::FETCH_ASSOC);
      //  print_r($soas);
      //  die();
       header('Content-Type: text/csv; charset=utf-8'); 
       $fileName = "Report_All_Done_".$nowDay;
       header("Content-Disposition: attachment; filename=".$fileName.".csv"); 
    
       $output = fopen("php://output", "w"); 
    
       fputcsv($output, array('Nomor', 'SOPP', 'Departemen', 'Pemegang Anggaran', 'Nominal', 'Perihal', 'Mata Anggaran', 'Tanggal')); 
    
       
       foreach($soas as $key=>$data){ 
              fputcsv($output, $data); 
       }
       fclose($output); 
    
    }
?> 