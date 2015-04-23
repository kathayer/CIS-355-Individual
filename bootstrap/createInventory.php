<?php 
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $brandError = null;
        $modelError = null;
        $yearError = null;
         
        // keep track post values
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
         
        // validate input
        $valid = true;
        if (empty($brand)) {
            $brandError = 'Please enter Brand';
            $valid = false;
        }
         
        if (empty($model)) {
            $modelError = 'Please enter Model';
            $valid = false;
        } 
         
        if (empty($year)) {
            $yearError = 'Please enter Year';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO inventory (brand,model,year) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($brand,$model,$year));
            Database::disconnect();
            header("Location: inventory.php");
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
                        <h3>Create an Inventory Item</h3>
                    </div>
             
                    <form class="form-horizontal" action="createInventory.php" method="post">
					  	<div class="control-group <?php echo !empty($brandError)?'error':'';?>">
                        <label class="control-label">Brand</label>
                        <div class="controls">
                            <select name="brand_name"> 
							<?php
							$pdo = Database::connect();
							$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$sql = "SELECT * FROM brand";
							foreach($pdo->query($sql) as $row)
							{
								echo "<option value=$row[0]>$row[1]</option>";
								
							}
							Database::disconnect();
							?>
							</select>
							
                            <?php if (!empty($brandError)): ?>
                                <span class="help-inline"><?php echo $brandError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($modelError)?'error':'';?>">
                        <label class="control-label">Model</label>
                        <div class="controls">
                            <input name="model" type="text" placeholder="Model" value="<?php echo !empty($model)?$model:'';?>">
                            <?php if (!empty($modelError)): ?>
                                <span class="help-inline"><?php echo $modelError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($yearError)?'error':'';?>">
                        <label class="control-label">Year</label>
                        <div class="controls">
                            <input name="year" type="text"  placeholder="Year" value="<?php echo !empty($year)?$year:'';?>">
                            <?php if (!empty($yearError)): ?>
                                <span class="help-inline"><?php echo $yearError;?></span>
                            <?php endif;?>
                        </div>
						</div> 
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="inventory.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
