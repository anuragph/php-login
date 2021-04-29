<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <?php include('./templates/header.php'); ?>
  <h3>Welcome, <?php echo $_SESSION['username']; ?>!</h3>
  
</body>
</html>