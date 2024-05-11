<?php
$servername = "db";
$username = "root";
$password = "example";
$database = "test_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// SQL to insert data
$sql = "INSERT INTO users (name, email) VALUES ('John Doe', 'john@example.com')";

if ($conn->query($sql) === TRUE) {
    echo "New record inserted successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// SQL to select data
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["email"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();


// Redis connection
// Connect to Redis
$redis = new Redis();
$redis->connect('redis', 6379); // Use the hostname 'redis' and default Redis port 6379

// Set a key-value pair
$redis->set('test_key', 'Hello, Redis!');

// Get the value for a key
$value = $redis->get('test_key');

// Output the value
echo "Value from Redis: $value";
