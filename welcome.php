<?php

  session_start();
  
  if(isset($_GET['submit'])) {
    session_unset();
    header('Location: ./index.php');
  }

  if(isset($_POST['submit'])) {
    include('./config/db_connect.php');

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
    $sql = "DELETE FROM users WHERE id=$id_to_delete";
    
    // Delete data and check
    if(mysqli_query($conn, $sql)) {
      session_unset();
      header('Location: ./index.php');
    } else {
      echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
?>

<!DOCTYPE html>
<html lang="en">
  <?php include('./templates/header.php'); ?>

  <h3>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
  
  <!-- Logout -->
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <input type="submit" name="submit" value="Log out">
  </form>
  </br>
  <!-- Delete user -->
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="hidden" name="id_to_delete" value="<?php echo $_SESSION['id']; ?>">
    <input type="submit" name="submit" value="Delete Account">
  </form>
</body>
</html>