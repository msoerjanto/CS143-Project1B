<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CS143 Project 1B</title>

   <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="project1B.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet" type="text/css" media="all">

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header navbar-defalt">
          <a class="navbar-brand" href="index.php">CS143 DataBase Query System (Demo)</a>
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
            <p>&nbsp;&nbsp;Browsing Content:</p>
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
	      <label for="directorid">Director:</label>
	      <select class = "form-control" name='directorid'>
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

                   $m_query = "select id,concat(first,' ',last) from Director;";
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

	      </select><br>
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
	      
	      //boolean flags for control
	      $movie_present = FALSE;
	      $director_present = FALSE;

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
	      if($_GET["directorid"])
	      {
	         $m_director = $_GET["directorid"];
	         if($m_director != "NULL")
	         {
	            $director_present = TRUE;
	         }else
	         {
	            print "<br>Director field cannot be empty";
	         }
	      }
	      if($movie_present && $director_present)
	      {
	         print "<br>movieid: ".$m_movie."<br>directorid: ".$m_director;
	         $m_query = "insert into MovieDirector
			     values(".$m_movie.",".$m_director.");";
	         $rs = mysql_query($m_query);
	         if(!$rs)
                 {
                    $message = "Invalid query: ". mysql_error()."\n";
                    $message .= "Whole query: ".$m_query;
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
