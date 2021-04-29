<?php
  include('./config/db_connect.php');

  if(isset($_POST['submit'])) {
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO users(username,pass) VALUES ('$username', '$password')";

    if(mysqli_query($conn, $sql)) {
      // Create session
      session_start();
      $_SESSION['username'] = $username;
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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <label for="username">Username:</label>
  <input type="text" name="username">
  <label for="password">Password:</label>
  <input type="text" name="password">
  <input type="submit" name="submit" value="Sign up">
</form>
  
</body>
</html>