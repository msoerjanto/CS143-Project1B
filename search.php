<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CS143 Project 1B</title>

    <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="project1B.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet" type="text/css" media="all">
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header navbar-defalt">
          <a class="navbar-brand" href="index.php">CS143 Project1B</a>
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
          <h3><b> Searching Page :</b></h3>
         <hr>
          <label for="search_input">Search:</label>
          <form class="form-group" method ="GET" id="usrform">
              <input type="text" id="search_input"class="form-control" placeholder="Search..." name="result"><br>
              <input type="submit" value="Click Me!"class="btn btn-default" style="margin-bottom:10px">
          </form>
          <!--php query start from here -->
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

	     
	     if($_GET["result"])
	     {
	        $m_search = $_GET["result"];
	        $words = preg_split('/\s+/', trim($m_search));
	        $actor_query = "select concat(first, ' ', last), dob, id
				from Actor
				where ";
	        $num_word = count($words, COUNT_NORMAL);
		for($i = 0; $i < $num_word; $i++)
		{
		   $actor_query .= "concat(first, ' ', last) like '%";
		   $actor_query .= $words[$i];
		   $actor_query .= "%'";
		   if($i != ($num_word - 1))
		   {
		      $actor_query .= " and ";
		   }
		}
		$actor_query .= ";";
		//print "$actor_query<br>";
	        
	        $movie_query = "select title, year, id
				from Movie
				where ";
		for($j = 0; $j < $num_word; $j++)
		{
		   $movie_query .= "title like '%";
		   $movie_query .= $words[$j];
		   $movie_query .= "%'";
		   if($j != ($num_word - 1))
		   {
		      $movie_query .= " and ";
		   }
		}
		$movie_query .= ";";
	        //print "$movie_query<br/>";
	        
		$actor_rs = mysql_query($actor_query, $db_connection);
		if(!$actor_rs)
		{
		   $message = "Invalid query: ". mysql_error()."\n";
		   $message .= "Whole query: ".$actor_query;
		   die($message);
		}
		
		$actor_table = "<h4><b>Matching Actors Are:</b></h4>";
		$actor_table .= "<div class='table-responsive'><table class='table table-bordered table-condensed table-hover'><thead>";
		$actor_table .= "<td><b>Name</b></td>";
		$actor_table .= "<td><b>Date of Birth</b></td><tbody>";
		while($row = mysql_fetch_row($actor_rs))
		{
		   $actor_table .= "<tr align=center>";
		   $actor_table .= "<td><a href=\"showA.php?identifier=$row[2]\">".$row[0]."</a></td>";
		   $actor_table .= "<td>".$row[1]."</td></tr>";
		}
		$actor_table .= "</tbody></table></div><hr>";


		$movie_rs = mysql_query($movie_query, $db_connection);
		if(!$movie_rs)
		{
		   $message = "Invalid query: ". mysql_error()."\n";
		   $message .= "Whole query: ".$movie_query;
		   die($message);
		}

		$movie_table = "<h4><b>Matching Movies are:</b></h4>";
		$movie_table .= "<div class='table-responsive'><table class='table table-bordered table-condensed table-hover'><thead>";
		$movie_table .= "<td><b>Title</b></td>";
		$movie_table .= "<td><b>Year</b></td>";
		while($row = mysql_fetch_row($movie_rs))
		{
		   $movie_table .= "<tr align=center>";
		   $movie_table .= "<td>".$row[0]."</td>";
		   $movie_table .= "<td>".$row[1]."</td></tr>";
		}
		$movie_table .= "</tbody></table></div>";


		print "<br>$actor_table<br />";
		print "<br>$movie_table<br />";
 
	     }
	     //now functioning, need to add links
		 mysql_close($db_connection);
	     ?>
  <!--php query end from here -->
        </div>
      </div>
    </div>





</body>
</html>
