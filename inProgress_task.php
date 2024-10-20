<?php
include 'db.php';

$id = $_GET['id'];
if ($id) {
    $stmt = $conn->prepare(query: "UPDATE tasks SET is_completed = 2 WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

header(header: "Location: index.php");
exit;
