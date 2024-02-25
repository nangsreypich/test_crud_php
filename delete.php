<?php 
//This code run after 
    //1-Create connection
    require("connection.php");
   if($_SERVER["REQUEST_METHOD"] == "POST"){
      //2-Prepare statement for delete
      $stRemove=$pdo->prepare("DELETE FROM product where id = :id");
      //3-bindvalue
      $id = $_REQUEST["id"];
      $stRemove->bindValue(':id',$id);
      //3-Execute
      $stRemove->execute();
      //Go to product list
      header("Location: index.php");
      exit();

   }

   //This code run first
   $id = $_REQUEST["id"];
   //2-Prepare statement
   $statement = $pdo->prepare("SELECT * FROM product where id = :id");

   //3-BindValue
   $statement->bindValue(':id',$id);
   
   //3-Execute
   $statement->execute();

   $proDoc = $statement->fetch(PDO::FETCH_ASSOC);
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<center>
      <h1>Delete Product</h1>
      Product Name : <?php echo $proDoc['name'] ?><br>
      Price : <?php echo $proDoc['price'] ?><br>
      Note : <?php echo $proDoc['note'] ?><br>
      Image : <?php echo $proDoc['image'] ?><br>
      <form action="" method="post">
         <input type="hidden" name="id" value="<?php echo $proDoc['id']; ?>"/>
         <input class="btn btn-danger" type="submit" name="" id="" value="Confirm Delete" />
   </form>
</center>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>