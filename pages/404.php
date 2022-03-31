<?php include("../includes/init.php"); 
$title = "Page Not Found";
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?php echo $title; ?></title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all" />
</head>

<body>
  <?php include("includes/header.php"); ?>

  <main>
    <section class='heading'>
      <h1><?php echo $title; ?></h1>
    </section>

    <section>
      <p>Sorry, the page you were looking for, <em>&quot;<?php echo htmlspecialchars($request_uri); ?>&quot;</em>, does not exist. Please go back to the home page at <em>http://localhost:3000/</em> or through the navigation link above.</p>
    </section>

  </main>

</body>

</html>
