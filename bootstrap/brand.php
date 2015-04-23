<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
			<p>
			<a href="index.php"> <img src="ThayerMarineLogo.PNG" class="companylogo"></a>
            </p>
			</div>
			<div class="row">
			<p>
			<a href="index.php" class="btn btn-primary" color="Blue">Customers</a>
			<a href="inventory.php" class="btn btn-primary" color="Blue">Inventory</a>
			<a href="brand.php" class="btn btn-primary" color="Blue">Brands</a>
			<a href="login.php" class="btn btn-primary offset7" color="Blue">Logout</a>
			</p>
			</div>
			
            <div class="row">

                 
                <table class="table table-striped table-bordered"><h3> Brands </h3>
                      <thead>
                        <tr>
                          <th>Brand Name</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
					  session_start();
					  $sess_id = "loggedin";
					  if ($_SESSION["id"]!=$sess_id)
						  header("location: login.php");
					  
                       include 'database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM brand ORDER BY id DESC';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['brand_name'] . '</td>';
                                echo '<td width=250>';
                                echo '<a class="btn" href="readBrand.php?id='.$row['id'].'">Read</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="updateBrand.php?id='.$row['id'].'">Update</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="deleteBrand.php?id='.$row['id'].'">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>
                <p>
                    <a href="createBrand.php" class="btn btn-success">Create</a>
                </p>				
        </div>
    </div> <!-- /container -->
  </body>
</html>