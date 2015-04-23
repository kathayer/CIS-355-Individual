<?php
    require 'database.php';
	
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: inventory.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $brandError = null;
        $modelError = null;
        $errorError = null;
         
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
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE inventory  set brand = ?, model = ?, year =? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($brand,$model,$year,$id));
            Database::disconnect();
            header("Location: inventory.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM inventory where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $brand = $data['brand'];
        $model = $data['model'];
        $year = $data['year'];
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
                        <h3>Update an Inventory Item</h3>
                    </div>
             
                    <form class="form-horizontal" action="updateInventory.php?id=<?php echo $id?>" method="post">
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
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="inventory.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>