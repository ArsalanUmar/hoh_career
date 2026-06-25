<?php

  require_once('database.php');

  $db = new Database;
  $conn = $db->Conn();
  
  if(!empty($_GET['ref'])){
      // Escape and decode the reference
      $ref_encoded = $conn->real_escape_string($_GET['ref']);
      $ref = base64_decode($ref_encoded);
      
      if(empty($ref)){
          header("Location: competency.php?error=invalid_ref");
          exit;
      }
      
      // First, get the PDF file path before deleting the record
      $sql_select = "SELECT pdf_file_path FROM `tbl_competencies` WHERE id='".$conn->real_escape_string($ref)."'";
      $result_select = $conn->query($sql_select);
      
      if($result_select && $result_select->num_rows > 0){
          $record = $result_select->fetch_assoc();
          $pdf_file_path = $record['pdf_file_path'];
          
          // Delete the PDF file if it exists
          if(!empty($pdf_file_path)){
              $full_pdf_path = "pdf_files/".$pdf_file_path;
              if(file_exists($full_pdf_path)){
                  @unlink($full_pdf_path);
              }
          }
          
          // Delete the database record
          $sql = "DELETE FROM `tbl_competencies` WHERE id='".$conn->real_escape_string($ref)."'";
          $result_logged = $conn->query($sql);
          
          if($result_logged){
              header("Location: competency.php?deleted=1");
          } else {
              header("Location: competency.php?error=delete_failed");
          }
      } else {
          // Record not found
          header("Location: competency.php?error=not_found");
      }
      exit;
  } else {
      // No reference provided
      header("Location: competency.php?error=no_ref");
      exit;
  }
  
?>