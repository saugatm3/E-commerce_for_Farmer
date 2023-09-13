<?php
// Start a session
session_start();

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit();
}

// Include the database connection file
require 'conection.php';

// Fetch the customer details from the database using session variable
$customer_id = $_SESSION['customer_id'];

// Prepare and execute the SQL query to fetch the customer's details
$sql = "SELECT * FROM customer_details WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the customer's details
if ($result->num_rows == 1) {
    $customer = $result->fetch_assoc();
    $customer_name = $customer['first_name'] . ' ' . $customer['last_name'];
    $contact = $customer['contact_number'];
    $email = $customer['email_id'];
    $district = $customer['district'];
    $pin = $customer['pin'];
    $area = $customer['area_name'];
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Consumer Login</title>
    <style>
        body{
            background-color: blanchedalmond;
        }
  
        .n{
            margin-top: 5%;
        }
        .crop-table {
            max-width: 800px;
            margin: 5% auto;
        }
    </style>
  </head>
  <body>
    <div class="a">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="index.html"><img src="Photo_navbar.jpeg" height="60px", width="80px"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="notification.html">NOTIFICATION</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Grivence.html">GRIVENCE</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="help.html">HELP </a>
              </li>
            
              <li class="nav-item">
                <a class="nav-link" href="contact.html">contact us</a>
              </li>
            </ul>
          </div>
        </nav>
          
      </div>
        <div class="n">
            <div class="container">
                <div class="row">
                    <div class="col">
  
                    </div>
                </div>
            </div>
            </div>
            <div>
              <br>
            </div>
            <div class="container">
              <div class="row">
                <div class="col">
                  <a href="my_orders.php"><button type="button" class="btn btn-primary">my orders </button></a>
                  <a href="../for_farmer/logout.php"><button type="button" class="btn btn-danger">log out  </button></a>
                </div>
              </div>
            </div>
            <div>
                <br>
            </div>
            <div>
                <br>

            </div>
            <div>
              <br>
         </div>
         <div>
          <h2>
            Personal Details 
          </h2>
          
         </div>
         <div>
           <table class="table" id="myTable">
             <thead>
               <tr>
                 <th scope="col"></th>
                 <th scope="col"></th>
               </tr>
             </thead>
             <tbody>
               <tr>
                 <td>Customer ID :<?php echo $customer_id?></td>
                 <td></td>
               </tr>
               <tr>
                 <td>Customer Name :<?php echo $customer_name ?></td>
                 <td></td>
               </tr>
               <tr>
                 <td>Contact Number:<?php echo $contact ?></td>
                 <td></td>
               </tr>
               <tr>
                 <td>Email Id:<?php echo $email ?></td>
                 <td></td>
               </tr>
               <tr>
                 <td>pin:<?php echo $pin ?></td>
                 <td></td>
               </tr>
               <tr>
                 <td>district:<?php echo $district ?> </td>
                 <td></td>
               </tr>
               <tr>
                 <td>area:<?php echo $area ?></td>
                 <td></td>
               </tr>
             </tbody>
           </table>
         </div> 
    </div>
  </div>

  <div class="container">
        <div class="crop-table">
            <h2>Crop List</h2>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Crop Name</th>
                        <th>Crop Type</th>
                        <th>Price per kg</th>
                        <th>Crop Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the database connection file
                    require 'conection.php';

                    // Fetch crop details from the database
                    $sql = "SELECT * FROM crop_details";
                    $result = $conn->query($sql);

                    // Check if there are any crops
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $cropName = $row['crop_name'];
                            $cropType = $row['crop_type'];
                            $cropImage = $row['crop_image'];
                            $cropId = $row['crop_id'];
                            $cropprice = $row['price_per_kg'];
                    ?>
                            <tr>
                                <td><?php echo $cropName; ?></td>
                                <td><?php echo $cropType; ?></td>
                                <td><?php echo $cropprice; ?></td>
                                <td><img src="../for_farmer/<?php echo $cropImage; ?>" alt="<?php echo $cropName; ?>" width="100"></td>
                                <td><a href="view_crop.php?crop_id=<?php echo $cropId; ?>" class="btn btn-primary">View</a></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="4">No crops found.</td></tr>';
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>


 
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        $("#d").click(function(){
          $("#myTable").toggle()
        });
      });
      $(document).ready(function(){
        $("#d1").click(function(){
          $("#myTable1").toggle()
        });
      });
    </script>
  </body>
</html>