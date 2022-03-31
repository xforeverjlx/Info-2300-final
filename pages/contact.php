
<?php
include("../includes/init.php");

include_once("../includes/db.php");
$db = init_sqlite_db('../db/site.sqlite', '../db/init.sql');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Contact - <?php echo htmlspecialchars($title); ?></title>

  <link rel="stylesheet" type="text/css" href="../styles/site.css" media="all" />
</head>

<body>
  <header>
    <!-- <h1 id="title"><?php echo htmlspecialchars($title); ?></h1> -->

    <nav id="menu">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </header>

  <div id="content-wrap">
  <form action="contact.php" method="get">
          <fieldset> 
            <legend> Your Details: </legend>
            <label> Name: <input type="text" name="employerName" size="30" maxlength="100"> </label>
            <br />
            <br />
            <label> Email: <input type="email" name="employerEmail" size="30" maxlength="100"> </label>
            <br />
            <br />
            <legend> Your Message: </legend>
            <label for="employerText"> <textarea rows="4" cols="40" id="employerText" ></textarea> </label>
            <br />
            <input type="submit" value="Submit Message"/>
          </fieldset>
        </form>
    </div>

</body>
</html>