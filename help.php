<!DOCTYPE html>
<html>
<head>
    <title>Chatbot</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .chat-container {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
        }
        .m1{
            margin:3%;
        }
        .m1 button{
            background-color:white;
        }
        .m1 button a{
            text-decoration:none;
            color:black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chatbot Example</h1>

        <div class="chat-container">
            <?php
            // Establish a connection to the database
            $host = 'localhost'; // Replace with your MySQL host
            $username = 'root'; // Replace with your MySQL username
            $password = ''; // Replace with your MySQL password
            $database = 'provothon'; // Replace with your MySQL database name
            
            // Create a connection
            $conn = new mysqli($host, $username, $password, $database);
            
            // Check the connection
            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $userQuery = $_POST["user_query"];

                // Prepare the SQL statement to fetch the answer from the database
                $sql = "SELECT answer FROM chat WHERE question LIKE '%$userQuery%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Match found, display the answer
                    $row = $result->fetch_assoc();
                    $answer = $row["answer"];
                    echo '<div class="alert alert-primary" role="alert">' . $answer . '</div>';
                } else {
                    // No match found
                    echo '<div class="alert alert-warning" role="alert">Sorry, I don\'t understand. Can you please rephrase your question?</div>';
                }
            }
            ?>
        </div>

        <form method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="user_query" placeholder="Ask me a question">
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
        <div class = "m1">
            <button type="submit" class="btn btn-primary"><a href="index.php">Home</a></button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
