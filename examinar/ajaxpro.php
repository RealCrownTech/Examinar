<?php

   require 'connection.php';

   $sql = "SELECT * FROM department
         WHERE falc LIKE '%".$_GET['id']."%' ORDER BY dept ASC"; 

   $result = $con->query($sql);

   $json = [];
   while($row = $result->fetch_assoc()){
        $json[$row['dept']] = $row['dept'];
   }

   echo json_encode($json);
?>