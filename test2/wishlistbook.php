
<?php
session_start();

if (isset($_SESSION['userId'])) {
    $dbObject = EnterDatabase();
    $userId = $_SESSION['userId'];

    
    $sth = $dbObject->prepare('
        SELECT b.title, b.author, b.ISBN 
        FROM wishlist w
        JOIN book2 b ON w.isbn = b.ISBN
        WHERE w.user_id = :userId
    ');
    $sth->bindParam(':userId', $userId);
    $sth->execute();
    $wishlist = $sth->fetchAll(PDO::FETCH_ASSOC);

    if ($wishlist) {
        echo "<h3>Your Wishlist</h3>";
        echo "<table border='1'>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                </tr>";
        foreach ($wishlist as $book) {
            echo "<tr>
                    <td>" . htmlspecialchars($book['title']) . "</td>
                    <td>" . htmlspecialchars($book['author']) . "</td>
                    <td>" . htmlspecialchars($book['ISBN']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Your wishlist is empty.</p>";
    }
} else {
    header("Location: index.php");
    exit();
}

function EnterDatabase() {
    try {
        $dbObject = new PDO("mysql:host=localhost;dbname=test2db", "root", "");
        $dbObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbObject;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
