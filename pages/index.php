<?php
function console_log($data){
  echo'<script>';
  echo 'console.log('.json_encode($data).')';
  echo'</script>';
}
include("../includes/init.php");

include_once("../includes/db.php");
$db = init_sqlite_db('../db/site.sqlite', '../db/init.sql');

$sql_select_query = 'SELECT * FROM Resume';
$sql_select_params = array();

//search
$search_terms = trim($_GET['q']);
if(empty($search_terms)){$search_terms = NULL;} //null instead of ""
$sticky_search_terms = $search_terms;

if($search_terms){
  $sql_select_query = "SELECT * FROM Resume WHERE (name LIKE '%' || :search || '%') OR (description LIKE '%' || :search || '%')";
  $sql_select_params = array(':search' => $search_terms);
  // console_log($sql_select_query);
}

//filter
$sticky_filter = array();
$role_filter_exprs = '';
$has_filtering = False;
foreach ($roles as $role){
  // $role_param = str_replace('', '-',strtolower($role));
  $should_filter = (bool) $_GET[$role];
  $sticky_filter[$role] = ($should_filter ? 'checked':'');

  if($should_filter){
    $has_filtering = True;
    $role_filter_exprs = $role_filter_exprs . "(role = '".$role."')";
    // console_log($role_filter_exprs);
  }
}
if($has_filtering){
  $sql_select_query = "SELECT * FROM Resume WHERE " . $role_filter_exprs . ";";
  // console_log($sql_select_query);
}

//sort
$sort_newest = '';
$sort_oldest = '';
$sort = $_GET['sort'];
$sort_css_classes = array('newest'=>'', 'oldest'=>'');

if(in_array($sort, array('newest', 'oldest'))){
  $sql_select_query = "SELECT * FROM Resume";
  if($sort == 'newest'){
    $sql_select_query = $sql_select_query . ' ORDER BY start_date DESC;';
    $sort_css_classes['newest'] = 'active';
    // console_log($sql_select_query);

  }
  else if ($sort == 'oldest'){
    $sql_select_query = $sql_select_query . ' ORDER BY start_date ASC;';
    $sort_css_classes['oldest'] = 'active';
    // console_log($sql_select_query);
  }
  else{$sort = NULL;}
}

//tags
$selected_tag = $_GET['tag'];
if ($selected_tag != NULL){
  $sql_select_query = "SELECT DISTINCT Resume.id, Resume.name, Resume.role, Resume.start_date, Resume.description FROM Resume INNER JOIN User_tag_rel ON (User_tag_rel.user_id = Resume.id) INNER JOIN Tags ON (User_tag_rel.tag_id = Tags.id) WHERE (Tags.tag_name = '".$selected_tag."');";
  // console_log($sql_select_query);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Portfolio - <?php echo htmlspecialchars($title); ?></title>

  <link rel="stylesheet" type="text/css" href="../styles/site.css" media="all" />
</head>

<body>
  <?php include("../includes/header.php"); ?>
  <!-- <header> -->
    <!-- <h1 id="title"><?php echo htmlspecialchars($title); ?></h1> -->

    <!-- <nav id="menu">
      <ul>
        <li><a href="index.php">Portfolio</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </header> -->

  <div id="content-wrap">
    <article id="content">
      <h1 id="article-title">Johann's Current Works</h1>

      <p>This is a catalogue of Johann's current work, projects, and achievements. For his past work please see the 'Past Works' page.</p>

      <div class="flex_box">
        <div id='main_table'>
          <h2>Catalogue</h2>
          <section class="sort">
            <p> Sort by:
              <a class="<?php echo $sort_css_classes['newest'];?>" href="?sort=newest">Newest</a> | 
              <a class="<?php echo $sort_css_classes['oldest'];?>" href="?sort=oldest">Oldest</a>
            </p>
          </section>
          
          <section class = "all_tags">
            <?php $tags = exec_sql_query($db, "SELECT tag_name FROM Tags;")->fetchAll();
            foreach ($tags as $tag){
              ?>
              <!-- html -->
              <div>
                <a class="tag_label" href="?tag=<?php echo $tag[0]?>"> <?php echo $tag[0]?></a>
              </div>
              <?php
            }
            ?>
          </section>



        <div id="side_bar">
          <form action="" method="get" id='search_group' novalidate>
            <!-- <label for="search">Search Key Word:</label> -->
            <input id="search" type="text" name="q" placeholder="Search Key Word" required value="<?php echo htmlspecialchars($sticky_search);?>"/>
            <button type="submit" id="search_button"> Search</button>
          </form>
          <!-- <form action="" method="get" class="filter" novalidate>
            <div>
              <p> Filter by Role </p>
              <?php
              foreach ($roles as $role){?>
                <label>
                  <input type="checkbox" name="<?php echo htmlspecialchars($role);?>" value="1"<?php echo $sticky_filter[$role];?>/>
                  <?php echo htmlspecialchars($role);?>
                </label>
              <?php 
              } ?>
             </div>

            <button type="submit" id="filter_button"> Filter</button>
          </form> -->
          
        </div>



          <section class='gallery'>
            <?php 
            console_log($sql_select_query);
            // console_log($sql_select_params);
            $records = exec_sql_query($db, $sql_select_query, $sql_select_params)->fetchAll();
            if(count($records) >0){
            ?>
              <ul>
              <?php foreach($records as $record){?>
                <li>
                <a href="?<?php echo http_build_query(array('id'=>$record['id']));?>">
                  <img src="../images/thumbnails/<?php echo $record['id'].'.jpeg'; ?>" style="max-weidth:100px; max-height:100px"/>
                  <p id='name'><?php echo htmlspecialchars($record['name']);?></p>
                  <p id='role'><?php echo htmlspecialchars($record['role']);?> </p>  
                </a>

                <section class="tag">
                  <?php $tags = exec_sql_query($db, "SELECT tag_name FROM User_tag_rel INNER JOIN Tags ON (User_tag_rel.tag_id = Tags.id) WHERE (user_id = :user_id);", 
                  array(':user_id' => $record['user_id'])) ->fetchAll(); //'user_id'
                  
                  foreach($tags as $tag){?>
                    <li>
                      <a class="tag_label" href="?tag=<?php echo strtolower($tag[0])?>">
                      <?php echo $tag[0]?></a>
                    </li>
                    <?php
                  }
                  ?>
                </section>
                </li>
              <?php } ?>
              </ul>
            <?php } ?>
          </section>
        </div>     
        
        
      </div>
    </article>
  </div>

  <footer>
  </footer>
</body>


</html>