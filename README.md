# Task-manager-api

This is a simple RESTful API for managing tasks, built with Laravel 11 as part of a developer skills test.

## Features

-   Create, Read, Update, and Delete (CRUD) tasks.
-   Protected API endpoints using Bearer Token authentication.
-   Uses a lightweight SQLite database for portability.
-   Includes an optional, simple frontend to demonstrate API usage.

---

## Prerequisites

-   PHP >= 8.2
-   Composer
-   An API client like [Postman](https://www.postman.com/)

---

## How to Run the Project

1.  **Clone the Repository**

    ```bash
    # If using git, otherwise just download and unzip the project
    git clone [your-repo-url]
    cd task-manager-api
    ```

2.  **Install Dependencies**

    ```bash
    composer install
    ```

3.  **Setup Environment File**
    Copy the example environment file.

    ```bash
    cp .env.example .env
    ```

4.  **Generate Application Key**
    This is a crucial step for any Laravel project.

    ```bash
    php artisan key:generate
    ```

5.  **Setup Database**
    The project is configured to use SQLite. Simply create the database file:

    ```bash
    touch database/database.sqlite
    ```

6.  **Run Migrations**
    This will create the `tasks` table in your database.

    ```bash
    php artisan migrate
    ```

7.  **Start the Local Server**
    ```bash
    php artisan serve
    ```
    The API will be available at `http://127.0.0.1:8000`.

---

## Optional Frontend

This project includes a simple Blade/HTML/JS frontend to demonstrate the API in action.

Once you have the server running, simply navigate to the root URL in your web browser to use the interface:

-   **URL:** `http://127.0.0.1:8000`

You can view, add, and delete tasks from this page.

---

## API Usage & Endpoints

**Authentication:**

All API endpoints require Bearer Token authentication. Include the following header in your requests:

-   **Header:** `Authorization`
-   **Value:** `Bearer testtoken123`

**Endpoints:**

| Method   | Endpoint          | Description             |
| :------- | :---------------- | :---------------------- |
| `POST`   | `/api/tasks`      | Create a new task       |
| `GET`    | `/api/tasks`      | Get a list of all tasks |
| `PUT`    | `/api/tasks/{id}` | Update a task's status  |
| `DELETE` | `/api/tasks/{id}` | Delete a task           |

**Sample `POST` / `PUT` Body:**

For creating a task (`POST`):

````json
{
    "task_name": "My new task",
    "description": "A description for the task."
}

For updating a task (`PUT`):
```json
{
    "status": true
}
````

## AI Task - Auto-Categorization Improvements

The current project implements a simple, keyword-based function (`autoCategorizeTask`) to automatically categorize tasks. While functional for this test, this approach has limitations:

-   It is rigid and can only identify the exact keywords in its hardcoded lists.
-   It does not understand context (e.g., "book a flight" might be personal, while "read a book about programming" is learning).
-   The keyword lists would require constant manual maintenance to remain effective.

**Improvement with a Real AI API (e.g., OpenAI):**

Given an AI API like OpenAI's, this feature could be made significantly more powerful and intelligent. Instead of simple keyword matching, the process would be:

1.  When a task is created, its `task_name` and `description` would be sent to the OpenAI API endpoint.
2.  The request would include a carefully crafted prompt, such as: _"Based on the following task, classify it into one of these categories: Work, Personal, Learning, or Other. Task Name: [task_name], Description: [description]"_
3.  The AI model would analyze the _semantic meaning_ of the text and return the most appropriate category as a response.

This AI-powered approach would be far more accurate, flexible, and require no manual keyword updates, providing a vastly superior user experience.

---

## AI Knowledge Task Submission

This section provides the isolated function and test cases as required by the AI Knowledge Task.

### Function Code

The following PHP function takes a task array (containing `task_name` and `description`) and returns a category string based on keyword matching.

```php
function autoCategorizeTask($task)
{
    // Define keywords for each category
    $workKeywords = ['laravel', 'project', 'api', 'endpoints', 'authentication', 'meeting', 'work'];
    $personalKeywords = ['gym', 'buy', 'groceries', 'doctor', 'personal', 'book flight'];
    $learningKeywords = ['learn', 'book', 'tutorial', 'read', 'study'];

    // Combine task name and description into a single string for searching
    $textToSearch = strtolower($task['task_name'] . ' ' . $task['description']);

    // Check for keywords in order of priority
    foreach ($workKeywords as $keyword) {
        if (str_contains($textToSearch, $keyword)) {
            return 'Work';
        }
    }

    foreach ($personalKeywords as $keyword) {
        if (str_contains($textToSearch, $keyword)) {
            return 'Personal';
        }
    }

    foreach ($learningKeywords as $keyword) {
        if (str_contains($textToSearch, $keyword)) {
            return 'Learning';
        }
    }

    // If no keywords are found, default to 'Other'
    return 'Other';
}

// Test Case 1: Matches a 'Work' keyword
$task1 = ['task_name' => 'Finish Laravel project', 'description' => 'Complete API endpoints'];
echo autoCategorizeTask($task1); // Expected Output: 'Work'

// Test Case 2: Matches a 'Personal' keyword
$task2 = ['task_name' => 'Go to the gym', 'description' => 'Leg day workout'];
echo autoCategorizeTask($task2); // Expected Output: 'Personal'

// Test Case 3: Matches a 'Learning' keyword
$task3 = ['task_name' => 'Read a new book', 'description' => 'A book on software architecture'];
echo autoCategorizeTask($task3); // Expected Output: 'Learning'

// Test Case 4: No keywords match
$task4 = ['task_name' => 'Water the plants', 'description' => 'The ones on the balcony'];
echo autoCategorizeTask($task4); // Expected Output: 'Other'