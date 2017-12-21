<?php 
      $currentURI = $_SERVER[REQUEST_URI];
      $currentPage = strtok($currentURI,'?');
      $systemFolder = substr($currentPage, 1, -4);
      $offset = 12;
      if($_GET['offset'] > 0){
      $offset = $_GET['offset']; //get this as input from the user, probably as a GET from a link
      }
      $newOffset = $offset + 10;
      ?>
<!DOCTYPE html>
<html>
   <head>
  <title>Neo Geo Pocket Color</title>
      <link rel="stylesheet" type="text/css" href="style.css">
   </head>
   <body>
      <div id="container">
      <h1 class="title">Neo Geo Pocket Color</h1>
      <span class="breadcrumb"><a href="index.php"><< Back To Menu</a></span>
      <div class="uploader">
         <form enctype="multipart/form-data" action="<?php echo $currentPage; ?>" method="POST">
            <p>Upload ROM (.ngc files)</p>
            <input type="file" name="uploaded_file"></input><br />
            <input type="submit" value="Upload"></input>
         </form>
      </div>
      <div class="rom-table">
         <table class="demo">
            <thead>
               <tr>
                  <th>Manage ROMs</th>
                  <th><br></th>
               </tr>
            </thead>
            <tbody>
               <?php
                  $quantity = 10; //number of items to display
                  $filelist = scandir('/home/pi/RetroPie/roms/' . $systemFolder . '/');
                  
                  //get subset of file array
                  $selectedFiles = array_slice($filelist, $offset-10, $quantity);
                  
                  //output appropriate items
                  foreach($selectedFiles as $file)
                  { 
                    if ($file != "." && $file != "..") {
                    echo "<tr><td>";
                    echo "$file\n";
                    echo "</td><td><a class='delete'><img src='delete.png' /></a></td></tr>";
                  }
                  }
                  ?>
            </tbody>
         </table>
         <table class="demo" style="margin-top: 22px;">
            <thead>
               <tr>
                  <th></th>
                  <th></th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <?php
                     echo "<td>";
                     if ($offset > 12){
                       $backOffset = ($offset - 10);
                             echo "<a class='pagelink' href='" . $currentPage . "?offset=" . $backOffset . "'><< Previous Page</a>";
                           }
                     echo "</td>";
                             echo "<td><a class='pagelink' href='" . $currentPage . "?offset=" . $newOffset . "'>Next Page >></a></td>";
                     ?>
               </tr>
            </tbody>
         </table>
         </div>
      <?php include_once("footer.php") ?>
      </div>
   </body>
</html>
<?PHP
   if(!empty($_FILES['uploaded_file']))
   {
     $path = "/home/pi/RetroPie/roms/" . $systemFolder . "/";
     $path = $path . basename( $_FILES['uploaded_file']['name']);
   
     if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
      header('Location: '.$_SERVER['REQUEST_URI']);
     } else{
         echo "There was an error uploading the file, please try again!";
     }
   }
   ?>