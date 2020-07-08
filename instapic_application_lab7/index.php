<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>INSTAPic! </title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
  <style>
    .photocontainer {
      display: flex;
      margin: 0 auto;
      flex-direction: row;
      justify-content: space-around;
      flex-wrap: wrap;
    }

    h1 {
      font-family: 'Pacifico', cursive;
    }

    header {
      text-align: center;
      margin-bottom: 25px;
    }

    main {
      width: 90%;
      margin-left: auto;
      margin-right: auto;
      border: 1px solid #999;
      border-radius: 25px;
      padding: 15px;
    }

    header a {
      color: #EE12E0;
      font-size: 18px;
      text-transform: lowercase;
    }
  </style>
  <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
</head>

<body>
  <main class="container">
    <header>
      <h1>InstaPics</h1>
      <a href="add.php"> Add A New Pic</a>
    </header>

    <?php ob_start();

    // connect
    require_once('db.php');
    require_once('appvars.php');

    // write the sql query
    $sql = "SELECT * FROM pictures";

    // execute the query and store the results
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $pictures = $cmd->fetchAll();

    ?>

    <div class="photocontainer">

      <?php

      // start the html display table

      // loop through the results and show each movie in a new row and each value in a new column
      foreach ($pictures as $picture) {
        echo '
        <div><img src="' . UPLOADPATH  . $picture['photo'] . '"><p>' . $picture['picture_description'] . '</p></div>';
      }

      ?>

    </div>
    <!--end container-->

    <?php

    // close the table and body
    echo '</tbody></table>';

    // disconnect
    $conn = null;

    ob_flush();
    ?>

  </main>
</body>

</html>