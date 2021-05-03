<?php
  include('./config/db_connect.php');

  if(isset($_POST['submit'])) {
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO users(username,pass) VALUES ('$username', '$password')";
    
    // Add use and check
    if(mysqli_query($conn, $sql)) {
      // Create session
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['id'] = mysqli_insert_id($conn); // To be used to delete data
      mysqli_close($conn);
      // Redirect
      header('Location: ./welcome.php');
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('./templates/header.php'); ?>
  <div class="container mt-5">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
      <div class="form-group">
        <label for="username" class="text-muted">Username:</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password" class="text-muted">Password:</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="d-flex justify-content-center">
        <input type="submit" name="submit" value="Sign up" class="btn btn-primary">
      </div>
    </form>
  </div>
  
</body>
</html>