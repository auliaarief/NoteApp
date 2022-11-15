<?php include('includes/session.php')?>
<?php include('includes/config.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php

 //********************Updation********************
    if(isset($_POST['update'])){
        $title=mysqli_real_escape_string($conn,$_POST['title']);
        $note=mysqli_real_escape_string($conn,$_POST['note']);
        // make sql query
        $query = "UPDATE notes SET title=\"$title\",note=\"$note\",updated=CURRENT_TIMESTAMP WHERE note_id = \"$get_id\" ";
        if(mysqli_query($conn, $query)){
        	echo "<script>alert('Note Updated Successfully');</script>";
      		header("Location:edit_note.php?edit=".urlencode($get_id));
        }else{
            //failure
            echo 'query error: '. mysqli_error($conn);
        }

    }

    //********************Selection********************
     $query = "SELECT * FROM notes WHERE user_id = \"$session_id\" ORDER BY updated DESC";

    if(mysqli_query($conn, $query)){

        // get the query result
        $result = mysqli_query($conn, $query);

        // fetch result in array format
        $notesArray= mysqli_fetch_all($result , MYSQLI_ASSOC);

        // print_r($notesArray);

    }else{
        //failure
        echo 'query error: '. mysqli_error($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Notebook | Web Application</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
  <link rel="stylesheet" href="./css/main.css">
  <link rel="stylesheet" href="css/app.css" type="text/css" />
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body>
  <section class="vbox">
  <header class="bg-dark dk header navbar navbar-fixed-top-xs">
      <div class="navbar-header aside-md">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
          <i class="fa fa-bars"></i>
        </a>
        <a href="notebook.php" class="navbar-brand" data-toggle="fullscreen"><img style="filter:invert(100%)"src="images/note.png" class="m-r-sm">Notebook</a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
          <i class="fa fa-cog"></i>
        </a>
      </div>
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
        <li class="dropdown">
          <?php $query= mysqli_query($conn,"select * from register where user_ID = '$session_id'")or die(mysqli_error());
                $row = mysqli_fetch_array($query);
            ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
              <img src="images/avatar_default.jpg">
            </span>
            <?php echo $row['fullName']; ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">
            <span class="arrow top"></span>
            <li class="divider"></li>
            <li>
              <a href="logout.php" data-toggle="ajaxModal" >Logout</a>
            </li>
          </ul>
        </li>
      </ul>      
    </header>
    <section>
    <div class="notes" id="app">
        <div class="notes__sidebar">
            <form action="notebook.php" method="post" id="myForm">
              <button type="submit" class="notes__add" name="add_note">Add Note</button>
            </form>
            <div class="notes__list">
            <?php foreach($notesArray as $notes){?>
                <div class="btn-group pull-right" >
                    <a href="notebook.php?delete=<?php echo $notes['note_id'];?>"><button class="button" name="delete" ><i class="fa fa-trash-o bg-danger"></i></button></a>
                </div>
                <a href="edit_note.php?edit=<?php echo $notes['note_id'];?>">
                <div class="notes__list-item" >
                    <div class="notes__small-title"><?php echo substr($notes['title'],0,20);?></title></div>
                    <div class="notes__small-body"><?php echo substr($notes['note'],0,20);?></div>
                    <div class="notes__small-updated"><?php echo $notes['updated'];?></div>
                  </div>
                </a>
            <?php } ?>
            </div>
        </div>
        
        <?php
						$query = mysqli_query($conn,"select * from notes where note_id = '$get_id' ")or die(mysqli_error());
						$row = mysqli_fetch_array($query);
				?>

        <form class="notes__preview" method="POST">
 
            <input class="notes__title" type="text" name="title" value="<?php echo $row['title']?>">
            <textarea class="notes__body" name="note"><?php echo $row['note']?></textarea>
                 
                    
            <button class="button button1" name = "update" type="submit">Submit</button>

        </form> 
        
    </div>
  </section>
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>

</body>
</html>