# Project Tasks Management System

A web application built with **Laravel 10**, **Livewire 3**, and **TailwindCSS** to manage projects and tasks. Users can create projects, add tasks with priorities, reorder tasks using drag-and-drop, and filter tasks by project.

---

## Features

* Create, edit, and delete projects.
* Create, edit, and delete tasks under projects.
* Drag-and-drop sorting of tasks within a project.
* Task priority auto-adjustment when tasks are deleted or reordered.
* Project filtering with search.
* Dark and light theme support.
* Responsive design using TailwindCSS.
* Persistent flash messages for user feedback.

---

## Requirements

* PHP >= 8.1
* Composer
* MySQL or MariaDB
* Node.js & npm (for compiling assets)
* Git (optional, for cloning repo)

---

## Setup Instructions (For Beginners)

### 1. Clone the Project

```bash
git clone https://github.com//project-tasks.git
cd project-tasks
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Copy `.env` File

```bash
cp .env.example .env
```

### 4. Configure Environment Variables

Open `.env` and set the database details:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Migrations & Seeders

This will create the tables and add some dummy projects and tasks.

```bash
php artisan migrate --seed
```

### 7. Install Frontend Dependencies

```bash
npm install
```

### 8. Compile Assets

```bash
npm run dev
```

Or for production:

```bash
npm run build
```
also if you want to add dummy data, i have created a seeder run it by using this command 
```bash
php artisan db:seed
```
### 9. Start the Local Server

```bash
php artisan serve
```

Open your browser at `http://127.0.0.1:8000`.

---
### 10. default email and password for the user
```bash
user@example.com
```
```bash
password
```
## Usage

1. Select a project from the dropdown to see its tasks.
2. Add a new task to the selected project using the modal.
3. Reorder tasks by dragging them. Priority is auto-updated.
4. Edit or delete tasks using the buttons.
5. Create new projects using the "Add Project" button.
6. Search for tasks by name using the search input.

---

## Deployment (Basic Instructions)

1. Upload your project to a PHP-compatible hosting provider.
2. Configure the `.env` file with your production database.
3. Run the migrations on the production server:

```bash
php artisan migrate --seed
```

4. Compile frontend assets for production:

```bash
npm run build
```

5. Make sure the `storage` and `bootstrap/cache` folders are writable.
6. Point your web server (Apache/Nginx) to the `public` folder of the project.

---

## Notes

* The project uses **Livewire** for dynamic frontend updates without page reloads.
* Task sorting is handled using **SortableJS**.
* The dark mode can be toggled by adding the `dark` class to the `<html>` tag.

---

## Author

**Muhammad Ali** – [GitHub Profile](https://github.com/pheonix55)

---

## License

This project is open-source and available under the MIT License.
