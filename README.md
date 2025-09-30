# Assessment Templates

A mini-project to demonstrate the creation of dynamic assessment templates using Laravel, Livewire, and Tailwind CSS.

## About The Project

This application allows users to create, manage, and view assessment templates. These templates are hierarchical and can be composed of:

-   **Sections:** The main categories of the template.
-   **Subsections:** Sub-categories within a section.
-   **Items:** Individual points to be assessed within a subsection.

Ratings can be configured at the section level, and assessments can be performed on sections, subsections, and items.

### Built With

*   [Laravel](https://laravel.com/)
*   [Livewire](https://livewire.laravel.com/)
*   [Tailwind CSS](https://tailwindcss.com/)
*   [SQLite](https://www.sqlite.org/)

## Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

Make sure you have the following installed on your local development machine:

*   PHP (>= 8.2)
*   [Composer](https://getcomposer.org/)
*   Node.js & npm

### Installation

1.  **Clone the repository:**
    ```sh
    git clone https://github.com/your_username/assessment-templates.git
    cd assessment-templates
    ```

2.  **Install PHP dependencies:**
    ```sh
    composer install
    ```

3.  **Install JavaScript dependencies:**
    ```sh
    npm install
    ```

4.  **Create your environment file:**
    ```sh
    cp .env.example .env
    ```

5.  **Generate an application key:**
    ```sh
    php artisan key:generate
    ```

6.  **Set up the database:**
    This project uses SQLite by default. Create the database file:
    ```sh
    touch database/database.sqlite
    ```

7.  **Run database migrations:**
    This will create the necessary tables in your database.
    ```sh
    php artisan migrate
    ```

8.  **Build frontend assets:**
    ```sh
    npm run dev
    ```
    Or, for production:
    ```sh
    npm run build
    ```

9.  **Serve the application:**
    ```sh
    php artisan serve
    ```
    The application will be available at `http://127.0.0.1:8000`.

## Usage

Once the application is running, you can navigate to the home page to see a list of existing templates.

-   **Create a Template:** Click the "Create Template" button to go to the template creation page. Here you can define the template name, description, and build its structure by adding sections, subsections, and items.
-   **Dynamic Structure:** Use the "Add Section", "Add Subsection", and "Add Item" buttons to build your template dynamically.
-   **Ratings:** For each section, you can define a set of rating columns (e.g., "Score", "Importance"). You can also specify the maximum rating value.
-   **Enable/Disable Ratings:** Ratings can be enabled or disabled at the section, subsection, or item level using the corresponding checkboxes.
-   **View a Template:** Click on a template's name from the index page to see the rendered assessment view.
-   **Edit a Template:** Click the "Edit" button on the template view page to modify an existing template.