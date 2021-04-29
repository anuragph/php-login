<?php
  $conn = mysqli_connect('localhost', /* username */, /* password */, 'login_app');
  
  // Check connection
  if(!$conn) {
    echo "error " . mysqli_error($conn);
  }
?>