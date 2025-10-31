# MenuQR Pro

A lightweight SaaS platform for restaurants to create, manage, and display dynamic digital QR code menus. This project is built using the TALL stack (Tailwind, Alpine.js, Laravel, Livewire) [o TALL si es el caso, si no, solo Laravel].

---

## 🚀 Key Features (Owner MVP)

* **Menu Management:** Create and manage multiple menus (e.g., "Lunch", "Dinner").
* **Category Management:** Organize menus with categories (e.g., "Appetizers", "Main Courses").
* **Item Management:** Create, edit, and delete menu items with descriptions, prices, and images.
* **Real-time Availability:** Toggle item availability (`is_available`) on or off, instantly updating the public menu.
* **Image Control:** Upload item images and toggle their visibility (`show_image`) on the menu.
* **Public Menu View:** A clean, mobile-first, public-facing menu generated from the admin panel.
* **Image Lightbox:** An integrated lightbox for viewing item images without leaving the menu.
* **QR Code Generation:** Dynamically generates and manages QR codes that link directly to the public menu.

---

## 🛠️ Tech Stack

* **Backend:** PHP / Laravel
* **Frontend:** Blade / Tailwind CSS / Alpine.js
* **Database:** MySQL (MariaDB)
* **QR Generation:** `simplesoftwareio/simple-qrcode`

---

## 🏁 Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

* PHP (>= 8.2)
* Composer
* Node.js (npm or yarn)
* A web server (e.g., Nginx, Apache) or Laravel Valet
* MySQL Database

### Installation

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/your-username/your-repo-name.git](https://github.com/your-username/your-repo-name.git)
    cd your-repo-name
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install NPM dependencies:**
    ```bash
    npm install
    npm run dev
    ```

4.  **Set up the environment:**
    * Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    * Generate a new application key:
        ```bash
        php artisan key:generate
        ```

5.  **Configure your `.env` file:**
    * Update the `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` variables to match your local database setup.
    * Update `APP_URL` to your local development URL (e.g., `http://menuqr.test`).

6.  **Run the database migrations:**
    ```bash
    php artisan migrate
    ```

7.  **Create the storage symlink:**
    * This is crucial for making uploaded images (like item photos) publicly accessible.
    ```bash
    php artisan storage:link
    ```

8.  **Run seeders (if available):**
    * (Optional: if you have a `DatabaseSeeder`)
    ```bash
    php artisan db:seed
    ```

9.  **Serve the application:**
    * You can use Laravel's built-in server for quick testing:
        ```bash
        php artisan serve
        ```

---

## 📜 License

This project is licensed under the MIT License - see the `LICENSE` file for details.
