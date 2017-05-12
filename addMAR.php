<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CS143 Project 1B</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/project1c.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet" type="text/css" media="all">

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header navbar-defalt">
          <a class="navbar-brand" href="index.php">CS143 DataBase Query System</a>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Add new content</p>
            <li><a href="homepage.php">Add Actor/Director</a></li>
            <li><a href="addMovie.php">Add Movie Information</a></li>
            <li><a href="addMAR.php">Add Movie/Actor Relation</a></li>
            <li><a href="addMDR.php">Add Movie/Director Relation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Browsering Content :</p>
            <li><a href="showA.php">Show Actor Information</a></li>
            <li><a href="showM.php">Show Movie Information</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Search Interface:</p>
            <li><a href="search.php">Search/Actor Movie</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	  <form method = 'GET' action ='#'>
	    <div class="form-group">
	      <label for="movieid">Movie Title:</label>
	      <select class = "form-control" name='movieid'>
		<option value=NULL> </option>
		<?php
		   //connection setup to localhost with username CS143 and no password
		   $db_connection = mysql_connect("localhost", "cs143", "");
		   if(!$db_connection)
		   {
		   $errmsg = mysql_error($db_connection);
		   print "Connection failed: $errmsg <br />";
		   exit(1);
		   }
		   //select the CS143 database
		   mysql_select_db("CS143", $db_connection);
		   $m_query = "select id,title from Movie;";
		   $rs = mysql_query($m_query);
		   if(!$rs)
		   {
		      $message = "Invalid query: ". mysql_error()."\n";
		      $message .= "Whole query: ".$m_query;
		      die($message);
		   }else
		   {
		      $content = "";
		      while($row = mysql_fetch_row($rs))
		      {
		         $content .= '<option value="'.$row[0].'">'.$row[1].'</option>';
		      }
		      echo $content;
		   }
		   
		   ?>
	      </select>
	    </div><br>
	    <div class = "form-group">
	      <label for="actorid">Actor:</label>
	      <select class = "form-control" name='actorid'>
		<option value=NULL> </option>
		<?php
		    //connection setup to localhost with username CS143 and no password
		   $db_connection = mysql_connect("localhost", "cs143", "");
		   if(!$db_connection)
		   {
		   $errmsg = mysql_error($db_connection);
		   print "Connection failed: $errmsg <br />";
		   exit(1);
		   }
		   //select the CS143 database
		   mysql_select_db("CS143", $db_connection);
		   
		   $m_query = "select id,concat(first,' ',last) from Actor;";
		   $rs = mysql_query($m_query);
		   if(!$rs)
		   {
		      $message = "Invalid query: ". mysql_error()."\n";
		      $message .= "Whole query: ".$m_query;
		      die($message);
		   }else
		   {
		      $content = "";
		      while($row = mysql_fetch_row($rs))
		      {
		         $content .= '<option value="'.$row[0].'">'.$row[1].'</option>';
		      }
		      echo $content;
		   }
		   ?>
	      </select>
	    </div><br>
	    <div class = "form-group">
	      <label for="role">Role:</label>
	      <input type='text' name='role' class="form-control"><br>
	      <input type='submit' class="btn btn-default" value='Click me!'>
	    </div>
	  </form>
	  
	  <?php
	     //connection setup to localhost with username CS143 and no password
	     $db_connection = mysql_connect("localhost", "cs143", "");
	     if(!$db_connection)
	     {
	     $errmsg = mysql_error($db_connection);
	     print "Connection failed: $errmsg <br />";
	     exit(1);
	     }
	     //select the CS143 database
	     mysql_select_db("CS143", $db_connection);

	     //boolean flags to control program flow
	     $role_present = FALSE;
	     $movie_present = FALSE;
	     $actor_present = FALSE;
	     if($_GET["movieid"])
	     {
	        $m_movie = $_GET["movieid"];
	        if($m_movie != "NULL")
	        {
	           $movie_present = TRUE;
	        }else
	        {
	           print "<br>Movie field cannot be empty";
	        }
	     }
	     if($_GET["actorid"])
	     {
	        $m_actor = $_GET["actorid"];
	        if($m_actor != "NULL")
	        {
	           $actor_present = TRUE;
	        }else
	        {
	           print "<br>Actor field cannot be empty";
	        }
	     }
	     
	     if($_GET["role"])
	     {
	        $m_role = $_GET["role"];
	        $role_present = TRUE;
	     }
	     
	     if($movie_present && $actor_present && $role_present)
	     {
	        //print "<br>movieid: ".$m_movie."<br>actorid: ".$m_actor."<br>role: ".$m_role;
	     
	        $main_query = "insert into MovieActor 
			       values(".$m_movie.",".$m_actor.",'".$m_role."');";	     
	        $m_rs = mysql_query($main_query);
	        if(!$m_rs)
	        {
	           $message = "Invalid query: ". mysql_error()."\n";
                   $message .= "Whole query: ".$main_query;
                   die($message);
	        }else
	        {
	           print "<br>Add success.";
	        }
	     }
	     ?>
	</div>
      </div>
    </div>
  </body>
</html>
