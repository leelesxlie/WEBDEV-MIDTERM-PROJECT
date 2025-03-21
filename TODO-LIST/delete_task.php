<?php
include 'db.php';

if (isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);
    $conn->query("DELETE FROM tasks WHERE id = $task_id");
}

// Return updated task list
$result = $conn->query("SELECT * FROM tasks WHERE is_completed = 0 ORDER BY id DESC");

while ($task = $result->fetch_assoc()) {
    echo '<li data-id="' . $task['id'] . '">'
        . htmlspecialchars($task['task_name']) . 
        '<div class="button-group">
            <button class="complete">Complete</button>
            <button class="delete">Delete</button>
        </div>
    </li>';
}
?>
