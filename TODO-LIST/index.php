<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
        <div class="sidebar">
            <h2 class="classy-title">Todo List</h2>
            <a href="#" class="new-task-link">Leslie Solomon's Task Manager</a>
            <div class="new-tasks-sidebar">
                <ul id="newTaskList"></ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- New Task Section -->
            <div class="new-task-container">
                <h3>New Task</h3>
                <div class="new-task">
                    <input type="text" id="taskInput" placeholder="Enter new task">
                    <button id="addTaskButton">Add Task</button>
                </div>
            </div>

            <!-- Task List -->
            <div class="task-list">
                <h3>Task Lists</h3>
                <ul id="taskList">
                    <?php include 'add_task.php'; ?>
                </ul>
            </div>

            <!-- Completed Tasks Section -->
            <div class="completed-container">
                <div class="completed-tasks">
                    <h3>Completed Tasks</h3>
                    <ul id="completedTaskList">
                        <?php include 'complete_task.php'; ?>
                    </ul>
                </div>
                <button id="clearCompletedButton">Clear Completed Tasks</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const taskInput = document.getElementById('taskInput');
            const addTaskButton = document.getElementById('addTaskButton');
            const taskList = document.getElementById('taskList');
            const completedTaskList = document.getElementById('completedTaskList');
            const clearCompletedButton = document.getElementById('clearCompletedButton');

            function loadTasks() {
                fetch('add_task.php')
                    .then(response => response.text())
                    .then(data => {
                        taskList.innerHTML = data;
                    });

                fetch('complete_task.php')
                    .then(response => response.text())
                    .then(data => {
                        completedTaskList.innerHTML = data;
                    });
            }

            function addTask() {
                const taskText = taskInput.value.trim();
                if (taskText === '') {
                    alert("Task cannot be empty!");
                    return;
                }
                fetch('add_task.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `task_name=${encodeURIComponent(taskText)}`
                })
                .then(response => response.text())
                .then(data => {
                    taskList.innerHTML = data;
                    taskInput.value = "";
                });
            }

            addTaskButton.addEventListener('click', addTask);
            taskInput.addEventListener('keypress', function (event) {
                if (event.key === 'Enter') {
                    addTask();
                }
            });

            taskList.addEventListener('click', function (event) {
                const li = event.target.closest('li');
                if (!li) return;
                const taskId = li.dataset.id;

                if (event.target.classList.contains('complete')) {
                    fetch('complete_task.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `task_id=${taskId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        completedTaskList.innerHTML = data;
                        loadTasks();
                    });
                } else if (event.target.classList.contains('delete')) {
                    fetch('delete_task.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `task_id=${taskId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        taskList.innerHTML = data;
                    });
                }
            });

            clearCompletedButton.addEventListener('click', function () {
                fetch('clear_task.php', { method: 'POST' })
                .then(() => {
                    completedTaskList.innerHTML = "";
                });
            });

            loadTasks();
        });
    </script>
</body>
</html>
