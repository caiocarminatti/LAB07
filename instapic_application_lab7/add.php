<?php ob_start() ?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Add New INSTAPic! </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
<style>
  .photocontainer {
    display:flex;
    margin: 0 auto;
    flex-direction: row;
    justify-content:space-around;
    flex-wrap: wrap;
  }

  h1{
    font-family: 'Pacifico', cursive;
  }

  header {
    text-align:center;
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
</head>

<body>
<?php

//require the files we need for db connection and application constants
require_once('appvars.php');
require_once('db.php');

if(isset($_POST['submit'])) {
    try {
        $description = $_POST['description'];
        //1. use $_FILES to grab the image name, type & size
        $photo = $_FILES['photo']['name'];
        $photo_type = $_FILES['photo']['type'];
        $photo_size = $_FILES['photo']['size'];

        if (!empty($description) && !empty($photo)) {
            //checking for the right filetype & size
            if ((($photo_type == 'image/gif') || ($photo_type == 'image/jpeg') || ($photo_type == 'image/jpg') || ($photo_type == 'image/png')) && ($photo_size > 0) && ($photo_size <= MAXFILESIZE)) {
                //making sure no upload errors
                if ($_FILES['photo']['error'] == 0) {

                  $target = UPLOADPATH . $photo;

                   move_uploaded_file($_FILES['photo']['tmp_name'], $target);
                    //2. set up the query
                   $sql = "INSERT INTO pictures(picture_description, photo)
                           VALUES(:description, :photo);";


                    //3. prepare
                  $cmd = $conn->prepare($sql);

                    // 4. bind
                  $cmd->bindParam(":description", $description);
                  $cmd->bindParam(":photo", $photo);

                    //5. execute
                  $cmd->execute();


                    //close the db connection

                    $cmd->closeCursor();

                    $name = "";
                    $description = "";
                    $photo = "";

                    //redirect user to index.php
                    header('location:index.php');
                } else {
                    echo '<p> There was a problem uploading your file</p>';
                }
            } else {
                echo '<p> You must submit either a png, jpeg, jpg or a png and your file cannot be greater than 32kb';

            }

        } else {
            echo '<p> Please enter all the info! </p>';
        }
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        //show error message to user
        echo "<p> Sorry! An error occurs </p> ";
        echo $error_message;
    }
}
?>
<main class="container">
  <header>
    <h1> Add A New Pic! </h1>
     <a href="index.php"> View All The Pics </a>
  </header>

  <!-- don't forget to add enctype to your form! -->
  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <div class="form-group">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAXFILESIZE; ?>">

      <label for="name"> Description </label>
      <input type="text" name="description" value="<?php if (!empty($name)) echo $name;?>" class="form-control">
    </div>


    <div class="form-group">
      <label for="photo"> Photo:</label>
      <input type="file" id="photo" name="photo"/>
    </div>
    <br/>
    <input type="submit" value="Add" name="submit" class="btn btn-default"/>
    </div>

  </form>
  </main>
</body>
</html>
<?php ob_flush() ?>
