<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Project Skripsi - Web Portal

A web application designed for **lecturers** and **administrators** to manage thesis projects and academic administrative tasks. This web portal serves as the backend and management interface for the MyCademy ecosystem.

## Live Demo

🚀 **[Access the Live Website](https://web-production-290a5.up.railway.app/)**

### Login Credentials (Default Password: `12345`)

| Role                   | Email                       | Password | Note                              |
| :--------------------- | :-------------------------- | :------- | :-------------------------------- |
| **Super Admin**        | `superadmin@gmail.com`      | `12345`  | Full access                       |
| **Admin Matakuliah**   | `adminmatakuliah@gmail.com` | `12345`  | Manage courses                    |
| **Lecturer (IoT)**     | `budisantoso@dosen.com`     | `12345`  | Assigned to 'Teknologi IoT'       |
| **Lecturer (Android)** | `sitirahayu@dosen.com`      | `12345`  | Assigned to 'Pemrograman Android' |

## Key Features

This platform supports student learning through comprehensive management and analytical tools:

- **Material & Assignment Management**: Organize and distribute learning materials and assignments effectively.
- **Discussion Forums**: dedicated discussion spaces for each material to foster student engagement.
- **Analytical Reports (Laporan Metode)**:
  Comprehensive reports are generated to monitor student performance.
  Key metrics include:
    - **Material Understanding Scale**: Tracks how well students grasp the course content.
    - **Quiz Scores**: Monitors academic performance through quiz results.
    - **On-time Completion Rates**: Tracks punctuality in submitting assignments and completing materials.
    - **Forum Participation**: Measures student engagement in class discussions.
    - **Contextual Performance (CP)**: A composite score analyzing overall student performance based on the above metrics.

## Mobile Application (Student Access)

For students, there is a dedicated mobile application built with Expo. You can access the source code for the mobile app here:

📱 **[MyCademy Mobile App (Expo) - GitHub Repository](https://github.com/Alyyy07/mycademy-mobile-expo)**

## Tech Stack

This project is built using:

- **Framework:** [Laravel 11](https://laravel.com)
- **Database:** MySQL
- **Authentication & Permissions:**
    - [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
    - [Laravel Sanctum](https://laravel.com/docs/sanctum) (for API)
- **Frontend:** Bootstrap / Tailwind (as configured)
- **Other Key Packages:**
    - `yajra/laravel-datatables` - DataTables integration
    - `maatwebsite/excel` - Excel exports/imports
    - `barryvdh/laravel-dompdf` - PDF generation

## Getting Started

1.  **Clone the repository**

    ```bash
    git clone https://github.com/Alyyy07/project-skripsi.git
    cd project-skripsi
    ```

2.  **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    Copy the `.env.example` file to `.env` and configure your database credentials.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Migration & Seeding**

    ```bash
    php artisan migrate --seed
    ```

5.  **Run the Application**
    ```bash
    npm run dev
    php artisan serve
    ```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
