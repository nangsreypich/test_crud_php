<?php 
   $error = [];
   $name = "";
   $price= "";
   $note = "";
   if($_SERVER["REQUEST_METHOD"] == "POST"){
      // echo var_dump($_FILES['image']);
   //1-Create Connection
   require("connection.php");

   //2-Get data from form
   $name = $_REQUEST["name"];
   $price = $_REQUEST["price"];
   $note = $_REQUEST["note"];

   //3-Valiation
   $error=[];
   if(!$name){
      $error[]= "Name is required";
   }
   if(!$price){
      $error[]= "Price is required";
   }
   // if(!$note){
   //    $error[]= "Note is required";
   // }
   if(empty($error)){
      require_once("globalFunction.php");
   //Upload Picture
   $image = $_FILES['image'] ?? null;
   $imagePath = "";
   if($image){
      //with random
      // $imagePath = "image/" .randomString(8) . $image['name'];
      //with date
      $imagePath = "image/" .date("YYMMDDhhmm") . $image['name'];
      move_uploaded_file($image['tmp_name'], $imagePath);
   }

   //4-Prepare Statement
   $statement = $pdo->prepare("INSERT INTO product(name,price,note,image) VALUES(:name,:price,:note, :image)");


   //5-BindValue
   $statement->bindValue(':name',$name);
   $statement->bindValue(':price',$price);
   $statement->bindValue(':note',$note);
   $statement->bindValue(':image',$imagePath);
   
   //3-Execute
   $statement->execute();

   header("Location: index.php");
   //4-Fetch Data
   // $productList = $statement->fetchAll(PDO::FETCH_ASSOC);
   }
}
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
   <div class="container">
      <h1>Add New Product</h1>
      <button class="btn btn-success" style="float:right;">Back</button>
      <!-- Show error -->
      <?php require('alert.php') ?>

      <form action="" method="post" enctype="multipart/form-data">
         <div class="mb-3 row">
            <label for="proName" class="form-label col-md-3">Product Name </label>
            <div class="col-md-9">
               <input type="text" id="proName" class="form-control" name="name" value="<?php echo $name ?>"/>
            </div>
         </div>
         <div class="mb-3 row">
            <label for="proPrice" class="form-label col-md-3">Price </label>
            <div class="col-md-9">
               <input type="number" id="proPrice" class="form-control" name="price" value="<?php  echo $price?>"/>
            </div>
         </div>
         <div class="mb-3 row">
            <label for="proNote" class="form-label col-md-3">Note </label>
            <div class="col-md-9">
               <input type="text" id="proNote" class="form-control" name="note" <?php  echo $note ?>/>
            </div>
         </div>
         <div class="mb-3 row">
            <label for="proImage" class="form-label col-md-3">Photo </label>
            <div class="col-md-9">
               <input type="file" id="proImage" class="form-control" name="image" />
            </div>
         </div>
         <button class="btn btn-success" style="float:right;">Save</button>
      </form>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>