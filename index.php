<?php 
   require("connection.php");

   $statement = $pdo->prepare("SELECT * FROM product ORDER BY id desc");

   $statement->execute();

   $productList = $statement->fetchAll(PDO::FETCH_ASSOC);
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
   <div class="container">
      <h1>Product</h1>
      <a href="add.php"><button style="float:right;" class="btn btn-primary">+Add Product</button></a>
      <table class="table table-striped">
         <thead>
            <tr>
               <th scope="col">#</th>
               <th scope="col">Name</th>
               <th scope="col">Price</th>
               <th scope="col">Note</th>
               <th scope="col">Image</th>
               <th scope="col">Image</th>
               <th scope="col">Action</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach($productList as $key => $pro){?>
               <tr>
                  <th scope="row"><?php echo $key + 1 ?></th>
                  <td><?php echo $pro['name']; ?></td>
                  <td><?php echo $pro['price']; ?></td>
                  <td><?php echo $pro['note']; ?></td>
                  <td><img src="<?php echo $pro['image'] ?? "https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg" ?>" alt="" width="30px" height="30px"></td>
                  <td>
                       <div class="d-grid gap-2 d-md-block">
                          <a class="btn btn-danger" type="button" href="edit.php?id=<?php echo $pro["id"]?>"><i class="fas fa-user-edit"></i></a>
                          <a class="btn btn-primary" type="button" href="delete.php?id=<?php echo $pro["id"]?>"><i class="fas fa-trash-alt"></i></a>
                       </div>
                  </td>
                  
               </tr>
            <?php }?>
         </tbody>
      </table>
   </div>
</body>
</html>
