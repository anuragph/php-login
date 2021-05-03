<?php

  session_start();
  
  // Log out
  if(isset($_GET['log_out'])) {
    session_unset();
    header('Location: ./index.php');
  }
  
  // Delete account
  if(isset($_POST['delete'])) {
    include('./config/db_connect.php');

    $id_to_delete = $_SESSION['id'];
    $sql = "DELETE FROM users WHERE id=$id_to_delete";
    
    // Delete data and check
    if(mysqli_query($conn, $sql)) {
      session_unset();
      mysqli_close($conn); // Close connection before redirect
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

  <div class="container mt-5">
    
    <h3 class="text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
    
      <div class="d-flex flex-column align-items-center mt-5">
      <!-- Logout -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
        <input type="submit" name="log_out" value="Log out" class="btn btn-primary">
      </form>
      </br>
      <!-- Delete user -->
      <button type="button" data-toggle="collapse" data-target="#delete-account" class="btn btn-outline-danger">Delete Account</button>
              
      <div id="delete-account" class="collapse m-3 p-2">
        <p class="text-danger">Are you sure? This action cannot be undone.</p>
        <div class="d-flex justify-content-between">
          <button type="button" data-toggle="collapse" data-target="#delete-account" class="btn btn-outline-success">No, go back</button>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="submit" name="delete" value="Yes, I'm sure" class="btn btn-outline-secondary">
          </form>
        </div>
      </div>
      
    </div>
  </div>
</body>
</html>