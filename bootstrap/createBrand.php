<?php 
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $brandError = null;
         
        // keep track post values
        $brand = $_POST['brand'];
         
        // validate input
        $valid = true;
        if (empty($brand)) {
            $brandError = 'Please enter Brand';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO brand (brand_name) values(?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($brand));
            Database::disconnect();
            header("Location: brand.php");
        }
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
                        <h3>Create an Brand</h3>
                    </div>
             
                    <form class="form-horizontal" action="createBrand.php" method="post">
                      <div class="control-group <?php echo !empty($brandError)?'error':'';?>">
                        <label class="control-label">Brand Name</label>
                        <div class="controls">
                            <input name="brand" type="text"  placeholder="Brand" value="<?php echo !empty($brand)?$brand:'';?>">
                            <?php if (!empty($brandError)): ?>
                                <span class="help-inline"><?php echo $brandError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>

                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="brand.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
