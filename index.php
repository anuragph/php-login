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
  

  if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    foreach($users as $user) {
      if ($username === $user['username'] && $password === $user['pass']) {
        // Create session
        session_start();
        $_SESSION['username'] = $username;
        // Redirect
        header('Location: ./welcome.php');
      } else {
        $message = 'Oops! Looks like you could not log in. Try again or ';
      }
    }
  }

  
?>

<!DOCTYPE html>
<html lang="en">
<?php include('./templates/header.php'); ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <label for="password">Password:</label>
    <input type="text" name="password" required>
    <input type="submit" name="submit" value="Log In">
  </form>
  <p><?php echo $message ?><a href="./signup.php">Sign up!</a></p>
  
</body>
</html>