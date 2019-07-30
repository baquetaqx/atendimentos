<?php 
function getConnection(){
    $host = "localhost";
    $banco= "fmssuporte";
    $usr = "root";
    $pwd= "";
try {
  $conn = new PDO("mysql:host=".$host.";dbname=".$banco, $usr, $pwd); 

  return $conn;
  
    }catch(PDOException $e) {
    return "ERROR: " . $e->getMessage();
    }
}

?>