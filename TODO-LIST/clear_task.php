<?php
include 'db.php';

// Delete all completed tasks
$conn->query("DELETE FROM tasks WHERE is_completed = 1");

// Return success response
echo "success";
?>