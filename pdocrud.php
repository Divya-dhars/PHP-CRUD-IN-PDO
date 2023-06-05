<?php
$host = "localhost";
$dbname = "bio";
$username = "root";
$password = "Divya29*";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'];
    switch ($action) {
        case 'create':
            $name = $_POST['name'];
            $email = $_POST['email'];
            $stmt = $pdo->prepare("INSERT INTO user (name, email) VALUES (?, ?)");
            $stmt->execute([$name, $email]);
            break;
        case 'read':
            $stmt = $pdo->prepare("SELECT * FROM user");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<h2>Users:</h2>";
            echo "<ul>";
            foreach ($users as $user) {
                echo "<li>{$user['name']} ({$user['email']})</li>";
            }
            echo "</ul>";
            break;
        case 'update':
            $name = $_POST['name'];
            $email = $_POST['email'];
            $stmt = $pdo->prepare("UPDATE user SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$name, $email, $id]);
            break;
        case 'delete':
            $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
            $stmt->execute([$id]);
            break;
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <form method="POST">
        <select name="action">
            <option value="create">Create</option>
            <option value="read">Read</option>
            <option value="update">Update</option>
            <option value="delete">Delete</option>
        </select>
        <input type="number" name="id" placeholder="ID">
        <input type="text" name="name" placeholder="Name">
        <input type="email" name="email" placeholder="Email">
        <input type="submit" value="Submit">
    </form>
</body>
</html>