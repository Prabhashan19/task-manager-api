<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; background-color: #f4f7f9; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; }
        form { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
        input[type="text"] { padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s; }
        button:hover { background-color: #2980b9; }
        ul { list-style: none; padding: 0; }
        li { display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #eee; }
        li:last-child { border-bottom: none; }
        li span { flex-grow: 1; }
        li .delete-btn { background-color: #e74c3c; font-size: 12px; padding: 5px 10px; }
        li .delete-btn:hover { background-color: #c0392b; }
    </style>
</head>
<body>

<div class="container">
    <h1>My Tasks</h1>

    <form id="create-task-form">
        <input type="text" id="task-name" placeholder="Task Name (e.g., Learn Laravel)" required>
        <input type="text" id="task-description" placeholder="Description (Optional)">
        <button type="submit">Add Task</button>
    </form>

    <ul id="task-list">
        <!-- Tasks will be loaded here by JavaScript -->
    </ul>
</div>

<script>
    const apiBaseUrl = '/api/tasks';
    const authToken = 'testtoken123'; // The hardcoded token

    const taskList = document.getElementById('task-list');
    const createTaskForm = document.getElementById('create-task-form');

    // Function to fetch and display tasks
    async function getTasks() {
        const response = await fetch(apiBaseUrl, {
            headers: {
                'Authorization': `Bearer ${authToken}`,
                'Accept': 'application/json'
            }
        });
        const tasks = await response.json();

        taskList.innerHTML = ''; // Clear the list before repopulating
        tasks.forEach(task => {
            const li = document.createElement('li');
            li.innerHTML = `<span>${task.task_name}</span> <button class="delete-btn" onclick="deleteTask(${task.id})">Delete</button>`;
            taskList.appendChild(li);
        });
    }

    // Function to create a new task
    createTaskForm.addEventListener('submit', async function (event) {
        event.preventDefault(); // Prevent page reload

        const taskName = document.getElementById('task-name').value;
        const description = document.getElementById('task-description').value;

        await fetch(apiBaseUrl, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${authToken}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ task_name: taskName, description: description })
        });

        // Clear form fields and refresh the list
        document.getElementById('task-name').value = '';
        document.getElementById('task-description').value = '';
        getTasks();
    });

    // Function to delete a task
    async function deleteTask(id) {
        if (confirm('Are you sure you want to delete this task?')) {
            await fetch(`${apiBaseUrl}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Accept': 'application/json'
                }
            });
            getTasks(); // Refresh the list
        }
    }

    // Initial load of tasks when the page is ready
    document.addEventListener('DOMContentLoaded', getTasks);
</script>

</body>
</html>