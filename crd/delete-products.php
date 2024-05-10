<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    if (!empty($_POST['delete'])) {
        $placeholders = implode(',', array_fill(0, count($_POST['delete']), '?'));
        $sql = "DELETE FROM products WHERE sku IN ({$placeholders})";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($_POST['delete']);
    }
}

header("Location: ../index.php");
exit();
?>
