<?php
//connections with database

$host="localhost";
$username="root";
$password='';
$dbname="company";
$con= mysqli_connect($host,$username,$password,$dbname);

//delete data

if(isset($_GET['delete'])){
$id=$_GET['delete'];
$deletequery="DELETE FROM`employees` WHERE id=$id ";
$delete=mysqli_query($con,$deletequery);
header("location: index.php"); 
}  

//update data
$name='';
$email='';
$phone='';
$gender='';
$department='';
$empid='';
$mode='create';

if(isset($_GET['edit'])){
$id=$_GET['edit'];
$select="SELECT * FROM `employees` WHERE id=$id";
$result=mysqli_query($con,$select);
$row=mysqli_fetch_assoc($result);
$name=$row['name'];
$email=$row['email'];
$phone=$row['phone'];
$gender=$row['gender'];
$department=$row['department'];
$empid=$id;
$mode='update';
}

if(isset($_POST['update'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $gender=$_POST['gender'];
    $department=$_POST['department'];
    $updatequery="UPDATE `employees` SET `name`='$name',`email`='$email',`phone`='$phone',`gender`='$gender',`department`='$department' WHERE id=$empid";
    $update=mysqli_query($con,$updatequery);
    header("Location: index.php");
}

//create data
if(isset($_POST['submit'])){
$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$gender=$_POST['gender'];
$department=$_POST['department'];
$insertquery="INSERT INTO `employees` VALUES(NULL,'$name','$email','$phone','$gender','$department')";
$insert=mysqli_query($con,$insertquery);
header("Location: index.php");
}


//read data

$selectquery="SELECT * FROM `employees`"; 
$search='';
$message='';

//search
if(isset($_GET['search'])){
    $value=$_GET['search'];
    $search=$value;
    $selectquery="SELECT * FROM `employees` WHERE `name` like '%$value%' or email like '%$value%' or department like '%$value%'";
    $select=mysqli_query($con,$selectquery);
}
//order by

if(isset($_GET['asc'])){
    if(!isset($_GET['orderBy'])){
        $message="please select a column to order by";
    }
    else{
        $order=$_GET['orderBy'];
        $selectquery="SELECT * FROM `employees` ORDER BY $order ASC";

    }

}

if(isset($_GET['desc'])){
    if(!isset($_GET['orderBy'])){
        $message="please select a column to order by";
    }
    else{
        $order=$_GET['orderBy'];
        $selectquery="SELECT * FROM `employees` ORDER BY $order DESC";

    }

}

$select=mysqli_query($con,$selectquery);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body{
            background-color: #333;
            color:white;
        }
    </style>

</head>
<body>
        <div class="container py-5">
            <div class="card bg-dark text-light">
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" value="<?= $name ?>" name="name" id="name" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text"  value="<?= $phone ?>"  name="phone" id="phone" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">email</label>
                                <input type="email"   name="email"  value="<?= $email ?>" id="email" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">gender</label>
                                <select id="gender"  name="gender" class="form-select">
                                    <?php if($gender=='male'): ?>
                                        <option disabled>choose.... </option>
                                        <option value="male" selected>male</option>
                                        <option value="female" >female</option>
                                    <?php elseif($gender=='female'): ?>
                                        <option disabled>choose.... </option>
                                        <option value="male">male</option>
                                        <option value="female" selected>female</option>
    
                                    <?php else: ?>
                                        <option disabled selected>choose.... </option>
                                        <option value="male">male</option>
                                        <option value="female">female</option>

                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label" >department</label>
                                <input type="text" value="<?= $department ?>"  name="department" id="department" class="form-control">
                            </div>
                            <div class="col-12 text-center">
                                <?php if($mode=='update'): ?>
                                <button class="btn btn-danger" name="update">Update</button>
                                <a href="index.php" class="btn btn-secondary">Cancel</a>
                                <?php else:?>
                                <button class="btn btn-primary" name="submit">Submit</button>
                                <?php endif; ?>
                            </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
                
    <div class="container py-2">
      <div class="card bg-dark text-light">
        <div class="card-body">
          <h2 class="text-center">filters</h2>
          <form>
            <div class="mb-3">
              <label for="search" class="form-label">Search</label>
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  value=""
                  name="search"
                  id="search"
                />
                <button class="btn btn-primary" value="<?= $search ?>">Search</button>
              </div>
            </div>
          </form>
          <form>
            <h5 class="text-danger"><?=$message?></h5>
            <div class="row align-items-center">
              <div class="col-md-8 mb-3">
                <label for="orderBy">Order By</label>
                <select name="orderBy" id="orderBy" class="form-select">
                  <option disabled selected>Choose...</option>
                  <option value="id">Id</option>
                  <option value="name">Name</option>
                  <option value="gender">Gender</option>
                  <option value="email">Email</option>
                  <option value="phone">Phone</option>
                  <option value="department">Department</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <button class="btn btn-info" name="asc">Ascending</button>
                <button class="btn btn-info" name="desc">Descending</button>
              </div>
            </div>
          </form>
          <a href="./index.php" class="btn btn-secondary">Cancel</a>
        </div>
      </div>
    </div>
<div class="container">
    <div class="card bg-dark">
    <table class="table table-dark">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>phone</th>
            <th>gender</th>
            <th>department</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($select as $num => $emp): ?>
        <tr>
            <td><?= $num +1?></td>
            <td><?= $emp['name']?></td>
            <td><?= $emp['email']?></td>
            <td><?= $emp['phone']?></td>
            <td><?= $emp['gender']?></td>
            <td><?= $emp['department']?></td>
            <td>
                <a href="?edit=<?= $emp['id']?>" class="btn btn-warning">Edit</a>
                <a href="?delete=<?= $emp['id']?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
    </table>
    </div>
    </div>
</body>
</html>