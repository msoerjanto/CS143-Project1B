<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CS143 Project 1c</title>

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
          <h3><b> Actor Information Page:</b></h3>
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

				// Actor Info
				$actor_query = "select concat(first, ' ', last), sex, dob, dod from Actor where id=$id";
				$actor_rs = mysql_query($actor_query, $db_connection);
				if(!$actor_rs)
				{
					$message = "Invalid actor ID: $id!";
					print $message;
				}
				else
				{
					$row = mysql_fetch_row($actor_rs);
					if($row[3] == "")
					{
						$row[3] = "n\a";
					}

					print "<h4><b>Actor Information:</b></h4><div class='table-responsive'> <table class='table table-bordered table-condensed table-hover'><thead> <tr><td>Name</td><td>Sex</td><td>Date of Birth</td><td>Date of Death</td></thead></tr><tbody><tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr></tbody></table></div>";
				}

				print "<hr>";

				// Actor roles + movies
				$movie_query = "select title, role, mid from MovieActor, Movie where MovieActor.mid = Movie.id and MovieActor.aid = $id";
				$movie_rs = mysql_query($movie_query, $db_connection);
				if(!$movie_rs)
				{
					print "Failed to find actor's movie roles!";
				}
				else
				{
					print "<h4><b>Actor's Movie Roles:</b></h4><div class='table-responsive'> <table class='table table-bordered table-condensed table-hover'><thead> <tr><td>Movie</td><td>Role</td></thead></tr>";

					print "<tbody>";
					while($row = mysql_fetch_row($movie_rs))
					{
						print "<tr><td><a href=\"showM.php?identifier=$row[2]\">$row[0]</a></td><td>$row[1]</td></tr>";
					}
					print "</tbody></table></div>";
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
