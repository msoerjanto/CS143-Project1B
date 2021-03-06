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
            <h3>Add new Movie</h3>
            <form method="GET" action="#">
                <div class="form-group">
                  <label for="title">Title:</label>
                  <input type="text" class="form-control" placeholder="Text input" name="title">
                </div>
                <div class="form-group">
                  <label for="company">Company</label>
                  <input type="text" class="form-control" placeholder="Text input" name="company">
                </div>
                <div class="form-group">
                  <label for="year">Year</label>
                  <input type="text" class="form-control" placeholder="Text input" name="year">
                </div>
                <div class="form-group">
                    <label for="rating">MPAA Rating</label>
                    <select   class="form-control" name="rate">
                        <option value="G">G</option>
                        <option value="NC-17">NC-17</option>
                        <option value="PG">PG</option>
                        <option value="PG-13">PG-13</option>
                        <option value="R">R</option>
                        <option value="surrendere">surrendere</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >Genre:</label>
                    <input type="checkbox" name="genre[]" value="Action">Action</input>
                    <input type="checkbox" name="genre[]" value="Adult">Adult</input>
                    <input type="checkbox" name="genre[]" value="Adventure">Adventure</input>
                    <input type="checkbox" name="genre[]" value="Animation">Animation</input>
                    <input type="checkbox" name="genre[]" value="Comedy">Comedy</input>
                    <input type="checkbox" name="genre[]" value="Crime">Crime</input>
                    <input type="checkbox" name="genre[]" value="Documentary">Documentary</input>
                    <input type="checkbox" name="genre[]" value="Drama">Drama</input>
                    <input type="checkbox" name="genre[]" value="Family">Family</input>
                    <input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input>
                    <input type="checkbox" name="genre[]" value="Horror">Horror</input>
                    <input type="checkbox" name="genre[]" value="Musical">Musical</input>
                    <input type="checkbox" name="genre[]" value="Mystery">Mystery</input>
                    <input type="checkbox" name="genre[]" value="Romance">Romance</input>
                    <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input>
                    <input type="checkbox" name="genre[]" value="Short">Short</input>
                    <input type="checkbox" name="genre[]" value="Thriller">Thriller</input>
                    <input type="checkbox" name="genre[]" value="War">War</input>
                    <input type="checkbox" name="genre[]" value="Western">Western</input>
                </div>
                <button type="submit" class="btn btn-default">Add!</button>
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

	       //boolean flags to control the program flow
	       $title_present = FALSE;
	       $company_present = FALSE;
	       $year_present = FALSE;
	       $genre_present = FALSE;
	       
	       if($_GET["title"])
	       {
	          $m_title = $_GET["title"];
	          $title_present = TRUE;
	       }
	       if($_GET["company"])
	       {
	          $m_company = $_GET["company"];
	          $company_present = TRUE;
	       }
	       if($_GET["year"])
	       {
	          if(ctype_digit($_GET["year"]))
	          {
	             $m_year = $_GET["year"];
	             $year_present = TRUE;
	          }else
	          {
	             print $_GET["year"]." is not a valid year";
	          }
	       }
	       
	       //if the user has filled in the required fields
	       if($year_present && $company_present && $title_present)
	       {
	          $m_rating = $_GET["rate"];
	          $genre_array = $_GET["genre"];
	          $m_genre = "";
	          foreach($genre_array as $gen)
	          {
	             $m_genre .= $gen." ";
	          }
	          //print "<br>title: ".$m_title."<br>company: ".$m_company."<br>year: ".$m_year."<br>genre: ".$m_genre."<br>rating: ".$m_rating; 
	          

	          //some constant queries to get the id for the new record as well as the query to update MaxMovieID
	          $update_id = "update MaxMovieID set id=id+1";
	          $m_query = "insert into Movie
			      values((select * from MaxMovieID),'".$m_title."',".$m_year.",'".$m_rating."','".$m_company."');";
	          //print $m_query."<br>";
	          
	          //execute the constructed query
	          $rs = mysql_query($m_query, $db_connection);
	          if(!$rs)
	          {
	             $message = "Invalid query: ". mysql_error()."\n";
                     $message .= "Whole query: ".$m_query;
                     die($message);
	          }else
	          {
	             $update_rs = mysql_query($update_id);
	             if(!$update_rs)
	             {
	                $message = "Invalid query: ". mysql_error()."\n";
                        $message .= "Whole query: ".$update_id;
                        die($message);
	             }
	             $verify_query = "select * from Movie where id =(select * from MaxMovieID) - 1;";
	             $verify_rs = mysql_query($verify_query, $db_connection);
	             if(!$verify_rs)
                     {
                        $message = "Invalid query: ". mysql_error()."\n";
                        $message .= "Whole query: ".$verify_query;
                        die($message);
                     }
	             $row = mysql_fetch_row($verify_rs);
	             $verify_string = "<br>Add Success:<br>";
	             for($l = 0; $l < mysql_num_fields($verify_rs); $l++)
		     {	
			$verify_string .= $row[$l]." ";
		     }
		     print $verify_string;
	          }
	       }

	       ?>


        </div>
      </div>
    </div>

</body>
</html>

