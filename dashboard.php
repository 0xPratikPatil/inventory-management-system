<!DOCTYPE html>
<html>
<head>
    <title>Database Query Results</title>
    <style>
        body {
            background-color: #f4f4f4;
            background-image: linear-gradient(45deg, #eee 25%, transparent 25%, transparent 75%, #eee 75%, #eee 100%), 
                            linear-gradient(45deg, #eee 25%, white 25%, white 75%, #eee 75%, #eee 100%);
            background-size: 20px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-bottom: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        thead {
            background-color: #6a5acd; /* slateblue */
            color: #fff;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<h2>Product Results</h2>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>TAG ID</th>
            <th>NAME</th>
            <th>CATEGORY</th>
	    <th>LOCATION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Step 1: Establish a database connection
        session_start();
        require_once("db_config.php");
     
        $conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Step 2: Execute the SQL query
        $sql = "SELECT id,tagid,p_name,p_cat,location FROM products ORDER BY id DESC LIMIT 10";
        $result = $conn->query($sql);

        // Step 3: Fetch and display the results in an HTML table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["tagid"] . "</td>";
                echo "<td>" . $row["p_name"] . "</td>";
                echo "<td>" . $row["p_cat"] . "</td>";
		echo "<td>" . $row["location"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }

        
        ?>
    </tbody>

</table>
<br>
<br>    
<h2>Product Status</h2>
<table border="1">
    <thead>
        <tr>
        <th>DATE</th>
        <th>TIME</th>
        <th>HUMIDITY</th>
        <th>TEMPERATURE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Step 2: Execute the SQL query
        $sql = "SELECT * FROM status ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);

        // Step 3: Fetch and display the results in an HTML table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["cdate"] . "</td>";
                echo "<td>" . $row["ctime"] . "</td>";
                echo "<td>" . $row["humidity"] . "</td>";
                echo "<td>" . $row["temperature"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }

        
        ?>
    </tbody>
</table>
<br>
<br>    
<h2>Product Stock</h2>
<table border="1">
    <thead>
        <tr>
        <th>CATEGORY</th>
        <th>STOCK</th>
        <th>LOCATION</th>
        </tr>
    
    </thead>
    <tbody>
        <?php
        // Step 2: Execute the SQL query
        $sql = "SELECT p_cat,location , COUNT(*) AS stock from products group by p_cat";
        $result = $conn->query($sql);

        // Step 3: Fetch and display the results in an HTML table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["p_cat"] . "</td>";
                echo "<td>" . $row["stock"] . "</td>";
                echo "<td>" . $row["location"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </tbody>
</table>


</body>
</html>
