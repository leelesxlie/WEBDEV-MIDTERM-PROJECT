<?php
include 'db.php';

if (isset($_POST['task_name']) && !empty(trim($_POST['task_name']))) {
    $task_name = $conn->real_escape_string($_POST['task_name']);
    $conn->query("INSERT INTO tasks (task_name, is_completed) VALUES ('$task_name', 0)");
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