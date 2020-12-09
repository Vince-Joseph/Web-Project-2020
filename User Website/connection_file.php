    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database_name="lodgebooking";
        
        // Create connection
        $db_connection = new mysqli($servername, $username, $password,$database_name);
        
        // Check connection
        if ($db_connection->connect_error) {
          die("Connection failed: " . $db_connection->connect_error);
        }
        // echo "Connected successfully";
    ?>
