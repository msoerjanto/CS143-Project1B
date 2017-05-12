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
            <h3>Add new Actor/Director</h3>
            <form method = "GET" action="#">
               <label class="radio-inline">
                    <input type="radio" checked="checked" name="identity" value="Actor"/>
                    Actor
                </label>
                <label class="radio-inline">
                    <input type="radio" name="identity" value="Director"/>Director
                </label>
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input type="text" class="form-control" placeholder="Text input"  name="fname"/>
                </div>
                <div class="form-group">
                  <label for="last_name">Last Name</label>
                  <input type="text" class="form-control" placeholder="Text input" name="lname"/>
                </div>
                <label class="radio-inline">
                    <input type="radio" name="sex" checked="checked" value="male">Male
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sex" value="female">Female
                </label>
                <div class="form-group">
                  <label for="DOB">Date of Birth</label>
                  <input type="text" class="form-control" placeholder="Text input" name="dateb">ie: 1997-05-05<br>
                </div>
                <div class="form-group">
                  <label for="DOD">Date of Die</label>
                  <input type="text" class="form-control" placeholder="Text input" name="dated">(leave blank if alive now)<br>
                </div>
                <button type="submit" value="submit" class="btn btn-default">Add!</button>
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
   $fname_present = FALSE;
   $lname_present = FALSE;
   $dob_present = FALSE;
   $dod_present = FALSE;
   $dod_valid = TRUE;
   

   if($_GET["fname"])
   {
      $first_name = $_GET["fname"];
      $fname_present = TRUE;
   }
   if($_GET["lname"])
   {
      $last_name = $_GET["lname"];
      $lname_present = TRUE;
   }
   if($_GET["dateb"])
   {
      $birth_date = $_GET["dateb"];
      $m_dob = strtotime($birth_date);
      if($m_dob == false || $m_dob == -1 || strlen($birth_date) == 1)
      {
         print "<br>Invalid Date Format!<br />";
      }else
      {
         $dob_present = TRUE;
      }
   }
   $death_date = "NULL";
   $m_dod = "NULL";
   if($_GET["dated"])
   {
      $death_date = $_GET["dated"];
      $m_dod = strtotime($death_date);
      if($m_dod == false || $m_dod == -1 || strlen($death_date) == 1 )
      {
         print "<br>Invalid Date Format!<br />";
         $dod_valid = FALSE;
      }else
      {
         $dod_present = TRUE;
         $death_date = "'".$_GET["dated"]."'";
      }
   }
   
   //All required parameters valid
   if($fname_present && $lname_present && $dob_present && $dod_valid)
   {
      //get the selected identity
      $table_name = "";
      if($_GET["identity"] == "Director")
      {
         $table_name = "Director";
      }else
      {
         $table_name = "Actor";
      }
      //get the selected sex
      $sex = "";
      if($_GET["sex"] == "male")
      {
         $sex = "Male";
      }else
      {
         $sex = "Female";
      }
      
      //some constant queries to get the id for the new record as well as the query to update the MaxPersonID value
      $get_id = "(select * from MaxPersonID)";
      $update_id = "update MaxPersonID set id=id+1";
      $m_query = "";
   
      //constructing the query to insert new tuple, need two cases since
      //the Director relation has no sex attribute
      if($table_name == "Actor")
      {
         $m_query = "insert into Actor values(".$get_id.",'".$last_name."','".$first_name."','".$sex."','".$birth_date."',".$death_date.");";
      }else
      {
         $m_query = "insert into Director values(".$get_id.",'".$last_name."','".$first_name."','".$birth_date."',".$death_date.");";
      }

      //execute the constructed query
      $rs = mysql_query($m_query, $db_connection);

      if(!$rs)
      //if the query fails we exit
      {
        $message = "Invalid query: ". mysql_error()."\n";
	$message .= "Whole query: ".$m_query;
	die($message);
      }else
      //if the query succeeds we update the MaxPersonId value
      {
         $update_rs = mysql_query($update_id, $db_connection);
         if(!$update_rs)
         {
            $message = "Invalid query: ". mysql_error()."\n";
            $message .= "Whole query: ".$update_id;
	    die($message);
         }
         $verify_query = "select * from ".$table_name." where id = ".$get_id."- 1 ;";
         $verify_rs = mysql_query($verify_query, $db_connection);
         $row = mysql_fetch_row($verify_rs);
         $verify_string = "<br>Add Success:<br>";
         for($l = 0; $l < mysql_num_fields($verify_rs); $l++)
	 {
	    if(mysql_field_name($verify_rs, $l) == "dod")
	    {
		if($death_date == "NULL")
		{
		   $verify_string .= "Still alive";
	        }else
	        {
	           $verify_string .= $row[$l]." ";
	        }
	    }else
	    {
		$verify_string .= $row[$l]." ";
	    }
	    
	 }
	 print $verify_string;
      }
      //DATE INSERTION PROBLEM, always get 0000-00-00
      $first_name = "";
      $last_name = "";
      $birth_date = "";
      $death_date = "";
   }

      
?>  

        </div>
      </div>
    </div>
</body>
</html>
