<?php
include 'db.php';

if (isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);
    $conn->query("UPDATE tasks SET is_completed = 1 WHERE id = $task_id");
}

// Return updated completed tasks list
$result = $conn->query("SELECT * FROM tasks WHERE is_completed = 1 ORDER BY id DESC");

while ($task = $result->fetch_assoc()) {
    echo '<li data-id="' . $task['id'] . '" class="completed">'
        . '<s>' . htmlspecialchars($task['task_name']) . '</s>'
        . '</li>';
}
?>
