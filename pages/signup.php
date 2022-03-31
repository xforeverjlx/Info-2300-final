<?php
include("../includes/init.php");
$title = "Sign Up";
$nav_join_class = "current_page";


if (!$is_admin) {
  // ----- INSERT -----
  // feedback message
  $first_name_feedback_class = 'hidden';
  $last_name_feedback_class = 'hidden';
  $request_feedback_class = 'hidden';

  // additional validation constraints
  $record_inserted = False;
  $record_insert_failed = False;

  // form values
  $request = NULL;

  // sticky values
  $sticky_request = '';

  if (isset($_POST['add_person'])) {
    $request = trim($_POST['request']); // untrusted
    
    // Assume the form is valid...
    $form_valid = True;

    if (empty($request)) {
      $form_valid = False;
      $name_feedback_class = '';
    }

    if ($form_valid) {
      $db->beginTransaction();

      // insert upload into DB
      $result = exec_sql_query(
        $db,
        "INSERT INTO info (user_id, request) VALUES (:user_id, :request);",
        array(
          ':user_id' => $current_user['id'],
          ':request' => $request, // tainted
        )
      );

      if ($result) {
        $record_inserted = True;

        $record_id = $db->lastInsertId('id');
        
      } else {
        $record_insert_failed = True;
      }

      $db->commit();
    } else {
      // form is invalid, set sticky values
      $sticky_request = $request;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?php echo $title; ?></title>

  <link rel="stylesheet" type="text/css" href="../public/styles/site.css" media="all" />
</head>

<body>
  <?php include("../includes/header.php"); ?>

  <main>
    <section class='heading'>
      <h1><?php echo $title ?></h1>
    </section>

    <?php if (is_user_logged_in() && $is_admin) {    ?>
      <p>TODO log contact requests</p>

    <?php
    } else if (!is_user_logged_in()) {
    ?>
      <p>Please sign in to view your previous requests.</p>

    <?php
      echo_login_form("/pages/signup", $session_messages);
    } ?>

    <?php if (!$is_admin) { ?>

      <section id='add_person'>
        <?php if ($record_inserted) { ?>
                <p id='insert_successful'><?php echo htmlspecialchars($name); ?> is successfully added to the platform</p>
              <?php } ?>

        <?php if ($record_insert_failed) { ?>
          <p cid='insert_failed' lass="feedback">Failed to add <?php echo htmlspecialchars($name)  ?> to the platform.</p>
        <?php } ?>

        <form id="add" action="/pages/signup" enctype="multipart/form-data" method="post" novalidate>

          <p id="request_feedback_class" class="feedback <?php echo $request_feedback_class; ?>">Enter your request.</p>
          <div class="group_label_input">
            <label for="add_request">Request:</label>
            <input id="add_request" type="text" name="request" value="<?php echo htmlspecialchars($sticky_request); ?>" required />
          </div>

          <div class="align-right">
            <button type="submit" name="add_person" id='add_person_button'>Join</button>
          </div>
        </form>
      </section>
    <?php
    } ?>
  </main>


</body>

</html>
