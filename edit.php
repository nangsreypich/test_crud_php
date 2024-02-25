<?php
$error = [];

//1-Create Connection
require_once("connection.php");

//====Update====
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
   //2-Get data from form
   $name = $_REQUEST["name"];
   $price = $_REQUEST["price"];
   $note = $_REQUEST["note"];

   //3-Valiation
   $error = [];
   if (!$name) {
      $error[] = "Name is required";
   }
   if (!$price) {
      $error[] = "Price is required";
   }
   // if (!$note) {
   //    $error[] = "Note is required";
   // }
   // // Check if an image is uploaded
   // $imagePath = "";
   // if(isset($_FILES['image'])){
   //    $image = $_FILES['image'];
   //    if($image['error'] === 0){
   //       $imagePath = "image/" . $image['name'];
   //       move_uploaded_file($image['tmp_name'], $imagePath);
   //    }
   // }

   // echo $_REQUEST['name'];
   // echo $_REQUEST['id'];
   // echo $_REQUEST['price'];
   // echo $_REQUEST['note'];
   // echo $_REQUEST['image'];

   if(empty($error)){
      require_once("globalFunction.php");
   //Upload Picture
   $image = $_FILES['image'] ?? null;
   $imagePath = "";
   if($image["name"]){
      //with random
      // $imagePath = "image/" .randomString(8) . $image['name'];
      //with date
      $imagePath = "image/" .date("YYMMDDhhmm") . $image['name'];
      move_uploaded_file($image['tmp_name'], $imagePath);
   }else{
      $imagePath = $_REQUEST["oldImage"];
   }
      // Prepare
      $upSt = $pdo->prepare("UPDATE product SET name=:name, price=:price, note=:note, image=:image WHERE id=:id");

      // BindValue
      $upSt->bindValue(':name', $_REQUEST['name']);
      $upSt->bindValue(':price', $_REQUEST['price']);
      $upSt->bindValue(':note', $_REQUEST['note']);
      $upSt->bindValue(':id', $_REQUEST['id']);
      $upSt->bindValue(':image', $imagePath);

      $upSt->execute();

      header("Location: index.php");
      return false;
   }
}

   $id = $_REQUEST['id'];

   //2-Prepare Statement   
   $statement = $pdo->prepare("SELECT * FROM product WHERE id = :id");

   //3-BindValue
   $statement->bindValue(':id', $id);

   //4-Execute
   $statement->execute();

   //5-Fetch Data
   $pro = $statement->fetch(PDO::FETCH_ASSOC);
   if (!empty($error)) {
      $pro['name'] = $name;
      $pro['price'] = $price;
      $pro['note'] = $note;
   }
?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Product</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
   <div class="container">
      <h1>Edit Product</h1>
      <!-- Show error -->
      <?php require('alert.php') ?>

      <form action="" method="post" enctype="multipart/form-data">
         <div class="mb-3 row">
            <label for="proName" class="form-label col-md-3">Product Name </label>
            <div class="col-md-9">
               <input type="text" id="proName" class="form-control" name="name" value="<?php echo $pro['name']; ?>" />
            </div>
         </div>
         <div class="mb-3 row">
            <label for="proPrice" class="form-label col-md-3">Price </label>
            <div class="col-md-9">
               <input type="number" id="proPrice" class="form-control" name="price"
                  value="<?php echo $pro['price']; ?>" />
            </div>
         </div>
         <div class="mb-3 row">
            <label for="proNote" class="form-label col-md-3">Note </label>
            <div class="col-md-9">
               <textarea type="text" id="proNote" class="form-control"
                  name="note"><?php echo $pro['note']; ?></textarea>
            </div>
         </div>
         <div class="mb-3 row">
            <label for="proImage" class="form-label col-md-3">Photo </label>
            <div class="col-md-9">
               <input type="file" id="proImage" class="form-control" name="image"/>
               <input type="hidden" id="oldImage" class="form-control" name="oldImage" value="<?php  echo $pro["image"]?>"/>
            </div>
         </div>
         <!-- <div class="mb-3 row">
            <label for="proImage" class="form-label col-md-3">Image </label>
            <div class="col-md-6">
               <input type="text" id="proImagePath" class="form-control" name="image" readonly />
            </div>
            <div class="col-md-3">
               <input type="file" id="proImage" class="form-control" name="image" />
            </div>
         </div> -->
         <input type="hidden" name="id" value="<?php echo $pro['id']; ?>" />
         <button class="btn btn-success" style="float:right;">Save</button>
      </form>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script>
</body>

</html>