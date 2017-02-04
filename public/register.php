<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $first_name = $_POST['first_name'] ?? '';
  $last_name = $_POST['last_name'] ?? '';
  $email = $_POST['email'] ?? '';
  $username = $_POST['username'] ?? '';
  $errors=array();
  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  if(is_post_request()) {

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php
    
    //Validate first name
    if(is_blank($first_name)) {
      $errors[] = 'First name cannot be blank.';
    }
    elseif(!has_length($first_name, ['min' => 2, 'max' => 255])) {
      $errors[] = 'First name must be between 2 and 255 characters.';
    }

    //Validate last name
    if(is_blank($last_name)) {
      $errors[] = 'Last name cannot be blank.';
    }
    elseif(!has_length($last_name, ['min' => 2, 'max' => 255])) {
      $errors[] = 'Last name must be between 2 and 255 characters.';
    }

    //Validate email
    if(is_blank($email)) {
      $errors[] = 'Email cannot be blank.';
    }
    elseif(!has_valid_email_format($email)) {
      $errors[] = 'Email must be a valid format.';
    }

    //Validate username
    if(is_blank($username) || !has_length($username, ['min' => 8, 'max' => 255])) {
      $errors[] = 'Username must be at least 8 characters.';
    }
    
    // if there were no errors, submit data to database
    if(count($errors) == 0) {
      // Write SQL INSERT statement
      $sql = "INSERT INTO user (first_name, last_name, email, username, created_at) VALUES ('" . $first_name . "', '" . $last_name . "', '" . $email . "', '" . $username . "', '" . date("Y-m-d H:i:s") . "')" ;

      // For INSERT statments, $result is just true/false
      $result = db_query($db, $sql);
      if($result) {
        db_close($db);

      //   TODO redirect user to success page
        redirect_to('registration_success.php');
      }
      else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
        echo db_error($db);
        db_close($db);
        exit;
      }
    }
  }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    echo display_errors($errors);
  ?>

  <!-- TODO: HTML form goes here -->

  <!DOCTYPE html>
  <html>
    <body>
      <form action="register.php" method="post">
        <p>First Name: <br /><input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name) ?>"/></p> 
        <p>Last Name: <br /><input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name) ?>"/></p>
        <p>Email: <br /><input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>" /></p>
        <p>Username: <br /><input type="text" name="username" value="<?php echo htmlspecialchars($username) ?>" /></p>
        <br />
        <div class="submit">
          <input type="submit" name="submit" value="Submit" />
        </div>
      </form>
    </body>
  </html>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
