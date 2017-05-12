<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CS143 Project 1B</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.
7/css/bootstrap.min.css">

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
             <div class="jumbotron">
                <h2>Welcome to CS143 Query System! (Demo)</h2>
                <br>
    Declaration:
		<br><br>
    <ul>
      <li>This is just a simple demo site created by students Yi Wang and Zhen Feng. Thanks for their work!</li>
      <li>This demo site may not "fully satisfy" 
      all the requirments assigned in the spec. The only purpose of this site is to give
      you a sense. Whenever there is a conflict, the official project spec always prevails.</li>
      <li>Copycat is strongly discouraged. Feel free to beat this demo site.</li>
    </ul>
            </div>

        </div>
      </div>
    </div>
</body>
</html>
