<?php
  require('./user_validation.php');
  include('./config/db_connect.php');
  

  // Get assoc array of existing users for validation
  $sql = "SELECT username FROM users";
  $result = mysqli_query($conn, $sql);
  $existing_users_raw = mysqli_fetch_all($result, MYSQLI_ASSOC);  
  mysqli_free_result($result);

  // Get indexed array from assoc array
  $existing_users = array_map('getUsers', $existing_users_raw);

  function getUsers($arr) {
    return $arr['username']; // column name is key
  }

  
  if(isset($_POST['submit'])) {
    // Run validation
    $validation = new SignUpValidation($_POST, $existing_users);
    $errors = $validation->validate();
    

    if(count($errors) === 0) {
            
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
        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($_POST['username'] ?? ""); ?>">
        <span class="text-danger"><?php echo $errors['username'] ?? ""; ?></span>
      </div>
      <div class="form-group">
        <label for="password" class="text-muted">Password:</label>
        <input type="password" name="password" class="form-control">
        <span class="text-danger"><?php echo $errors['password'] ?? ""; ?></span>
      </div>
      <div class="d-flex justify-content-center">
        <input type="submit" name="submit" value="Sign up" class="btn btn-primary">
      </div>
    </form>
  </div>
  
</body>
</html>