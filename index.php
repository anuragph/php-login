<?php

  $message = '';

  include('./config/db_connect.php');

  // Make query
  $sql = "SELECT * FROM users";
  // Get result
  $result = mysqli_query($conn, $sql);
  // Fetch result as array
  $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
  
  mysqli_free_result($result);
  mysqli_close($conn);
  
  // Log in
  if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    foreach($users as $user) {
      // Check credentials
      if ($username === $user['username'] && $password === $user['pass']) {
        // Create session
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $user['id']; // To be used to delete data
        // Redirect
        header('Location: ./welcome.php');
      } else {
        // Failure to login
        $message = 'Oops! Try again or ';
      }
    }
  }

  
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
      <div class="d-flex justify-content-between">
        <input type="submit" name="submit" value="Log In" class="btn btn-success">
        <p class="text-secondary"><?php echo $message ?><a href="./signup.php">Sign up!</a></p>
      </div>
    </form>
    
  </div>
  
</body>
</html>