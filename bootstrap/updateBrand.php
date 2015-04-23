<?php
    require 'database.php';
	
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: brand.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $brandError = null;

         
        // keep track post values
        $brand = $_POST['brand_name'];
		 
        // validate input
        $valid = true;
        if (empty($brand)) {
            $brandError = 'Please enter Brand Name';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE brand set brand_name = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($brand,$id));
            Database::disconnect();
            header("Location: brand.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM brand where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $brand = $data['brand'];

        Database::disconnect();
    }
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
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update a Brand</h3>
                    </div>
             
                    <form class="form-horizontal" action="updateBrand.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($brandError)?'error':'';?>">
                        <label class="control-label">Brand Name</label>
                        <div class="controls">
                            <input name="brand_name" type="text"  placeholder="Name" value="<?php echo !empty($brand)?$brand:'';?>">
                            <?php if (!empty($brandError)): ?>
                                <span class="help-inline"><?php echo $brandError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>

                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="brand.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>