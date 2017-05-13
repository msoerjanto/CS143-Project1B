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
          <h3><b> User Review Page:</b></h3>
         <hr>
		 <?php
			if($_GET["identifier"])
			{
				$id = $_GET["identifier"];

				// Create input forms
				print "<form method=\"GET\" id=\"userform\">";
				print "<div class=\"form-group\">";
				print "<h4><b>Add movie review here:</b></h4>";
				print "<label for=\"title\">Your name</label>";
				print "<input type=\"text\" name=\"viewer\" class=\"form-control\" placeholder=\"Your name here\" id=\"title\">";
				print "</div>";

				print "<div class=\"hidden\"><select class=\"form-control\" name=\"mid\" id\"rating\"><option value=\"$id\">$id</option></select></div>";

				print "<div class=\"form-group\"><label for=\"rating\">Rating</label>";
				print "<select class=\"form-control\" name=\"score\" id=\"rating\">";
				print "<option value=\"1\">1</option>";
				print "<option value=\"2\">2</option>";
				print "<option value=\"3\">3</option>";
				print "<option value=\"4\">4</option>";
				print "<option value=\"5\">5</option>";
				print "</select></div>";

				print "<div class=\"form-froup\">";
				print "<textarea class=\"form-control\" name=\"comment\" rows=\"5\" placeholder=\"No more than 500 characters\">";
				print "</textarea><br></div><button type=\"submit\" class=\"btn btn-default\">Submit rating!</button></form>";
			}
			else if($_GET["score"])
			{
				$user = $_GET["viewer"];
				$score = $_GET["score"];
				$mid = $_GET["mid"];
				$comment = $_GET["comment"];

				$db_connection = mysql_connect("localhost", "cs143", "");
				if(!$db_connection)
	    	 	{
					$errmsg = mysql_error($db_connection);
					print "Connection failed: $errmsg <br />";
					exit(1);
	    	 	}
	    	 	mysql_select_db("CS143", $db_connection);

				$add_query = "insert into Review values('$user', NOW(), $mid, $score, '$comment');";
				$rs = mysql_query($add_query, $db_connection);
				if(!$rs)
				{
					print "Failed to add the review to our database!<br>";
				}
				else
				{
					print "Thank you for your feedback!<br>";
				}

				print "<a href=\"showM.php?identifier=$mid\">Click here to go back to the movie page</a><hr>";

				mysql_close($db_connection);
			}
		?>
         </div>
      </div>
    </div>
  

</body>
</html>
