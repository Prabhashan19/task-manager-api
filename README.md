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
