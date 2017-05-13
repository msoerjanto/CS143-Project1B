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
         <h3><b> Movie Information Page :</b></h3>
         <hr>
		 <?php
			if($_GET["identifier"])
			{
				$id = $_GET["identifier"];

				$db_connection = mysql_connect("localhost", "cs143", "");
				if(!$db_connection)
	    	 	{
					$errmsg = mysql_error($db_connection);
					print "Connection failed: $errmsg <br />";
					exit(1);
	    	 	}
	    	 	mysql_select_db("CS143", $db_connection);

				// Movie Info
				$movie_query = "SELECT title, year, company, rating FROM Movie WHERE Movie.id=$id;";
				$movie_rs = mysql_query($movie_query, $db_connection);
				if(!$movie_rs)
				{
					$message = "Invalid movie ID: $id!";
					print $message;
				}
				else
				{
					$row = mysql_fetch_row($movie_rs);

					print "<h4><b>Movie Information:</b></h4>";
					print "Title: $row[0]<br>";
					print "Year: $row[1]<br>";
					print "Producer: $row[2]<br>";
					print "MPAA Rating: $row[3]<br>";

					$movie_query = "SELECT concat(first, ' ', last) FROM Movie, MovieDirector, Director WHERE Movie.id=$id AND Movie.id=MovieDirector=mid AND MovieDirector.did=Director.id;";
					$movie_rs = mysql_query($movie_query, $db_connection);
					$row = mysql_fetch_row($movie_rs);
					print "Director: $row[0]<br>";

					$movie_query = "SELECT genre FROM MovieGenre WHERE MovieGenre.mid=$id;";
					$movie_rs = mysql_query($movie_query, $db_connection);
					$row = mysql_fetch_row($movie_rs);
					print "Genre: $row[0]<br>";
				}

				print "<hr>";

				// Movie actors + roles
				$movie_query = "select concat(first, ' ', last), role, aid from MovieActor, Actor where MovieActor.mid = $id and MovieActor.aid = Actor.id";
				$movie_rs = mysql_query($movie_query, $db_connection);
				if(!$movie_rs)
				{
					print "Failed to find actor's movie roles!";
				}
				else
				{
					print "<h4><b>Actors in this movie:</b></h4><div class='table-responsive'> <table class='table table-bordered table-condensed table-hover'><thead> <tr><td>Movie</td><td>Role</td></thead></tr>";

					print "<tbody>";
					while($row = mysql_fetch_row($movie_rs))
					{
						print "<tr><td><a href=\"showA.php?identifier=$row[2]\">$row[0]</a></td><td>$row[1]</td></tr>";
					}
					print "</tbody></table></div>";
				}

				print "<hr>";

				// Get user reviews
				$review_query = "select name, rating, time, comment from Review where mid=$id;";
				$review_rs = mysql_query($review_query, $db_connection);

				if(!$review_rs)
				{
					print "Failed to get movie reviews!";
				}
				else
				{
					print "<h4><b>User Reviews:</b></h4>";
					$total = mysql_num_rows($review_rs);
					if($total == 0)
					{
						print "<a href=\"addReview.php?identifier=$id\">No one has given this movie a review yet. Be the first!</a>";
					}
					else
					{
						$avg = 0;
						$str = "";
						while($row = mysql_fetch_row($review_rs))
						{
							$str .= "<p><font color=\"red\"><b>$row[0]</b></font>";
							$str .= " rates this movie with the score <font color=\"blue\"><b>$row[1]</b></font>";
							$str .= " and left a review at $row[2] <br>comment:<br>";
							$str .= "$row[3]<br></p>";

							$avg += $row[1];
						}

						$avg /= $total;

						print "The average user score for this movie is $avg/5, based on $total review";
						if($total > 1){ print "s."; }
						else{ print "."; }
						print "<br><a href=\"addReview.php?identifier=$id\">Add your review as well!</a>";

						print "<hr><h4><b>Users said:</b></h4>$str";
					}
				}

				mysql_close($db_connection);
			}
			?>
		<hr>
            <label for="search_input">Search:</label>
            <form class="form-group" action="search.php" method ="GET" id="usrform">
              <input type="text" id="search_input"class="form-control" placeholder="Search..." name="result"><br>
              <input type="submit" value="Click Me!" class="btn btn-default" style="margin-bottom:10px">
          </form>
         </div>
      </div>
    </div>

   
  

</body>
</html>


