    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database_name="lodgebooking";

        // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        //   set_exception_handler(function($e) {
        //     error_log($e->getMessage());
        //     exit('Error connecting to database'); //Should be a message a typical user could understand
        //   });
        
        // Create connection
        $db_connection = new mysqli($servername, $username, $password,$database_name);
        
        $db_connection->set_charset("utf8mb4");
       // Check connection
        if ($db_connection->connect_error) {
          die("Connection failed: " . $db_connection->connect_error);
        }
        // echo "Connected successfully";
    ?>
