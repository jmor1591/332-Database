<?php
$host = 'mariadb';
$user = 'cs332s24';
$pass = '8MPYK4jK';
$dbname = 'cs332s24';

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Students Table</h2>";

$result = $conn->query("SELECT * FROM students");

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Name</th><th>Major</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['major']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "No data found.";
}

// Optional: user query form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = $_POST['query'];
    echo "<h3>Custom Query Results:</h3>";
    $res = $conn->query($query);

    if ($res && $res->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        $fields = $res->fetch_fields();
        echo "<tr>";
        foreach ($fields as $field) echo "<th>{$field->name}</th>";
        echo "</tr>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $val) echo "<td>$val</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No results or error in query.";
    }
}
?>

<h3>Run a Custom Query</h3>
<form method="POST">
    <input type="text" name="query" size="50" placeholder="SELECT * FROM students;" required>
    <input type="submit" value="Run">
</form>
