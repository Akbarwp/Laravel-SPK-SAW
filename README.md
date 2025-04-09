# Laravel SPK SAW

Laravel SPK SAW is a website designed to provide a decision support system using the SAW (Simple Additive Weighting) method. This site enables users to analyze various decision alternatives based on defined criteria, assisting in determining the best choice in a systematic and transparent way. With a user-friendly interface, users can easily input data and obtain in-depth analysis results to support more accurate decision-making.

## Tech Stack

- **Laravel 11** --> **Laravel 12**
- **Laravel Breeze**
- **MySQL Database**
- **TailwindCSS**
- **daisyUI**
- **[maatwebsite/excel](https://laravel-excel.com/)**
- **[barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)**

## Features

- Main features available in this application:
  - Implementation SAW method
  - Import data --> example [Kriteria](https://github.com/user-attachments/files/19659807/Import.Kriteria.xlsx), [Sub kriteria](https://github.com/user-attachments/files/19659809/Import.Sub.Kriteria.xlsx), [Alternatif](https://github.com/user-attachments/files/19659806/Import.Alternatif.xlsx), [Penilaian](https://github.com/user-attachments/files/19659808/Import.Penilaian.xlsx)

## Installation

Follow the steps below to clone and run the project in your local environment:

1. Clone repository:

    ```bash
    git clone https://github.com/Akbarwp/Laravel-SPK-SAW.git
    ```

2. Install dependencies use Composer and NPM:

    ```bash
    composer install
    npm install
    ```

3. Copy file `.env.example` to `.env`:

    ```bash
    cp .env.example .env
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Setup database in the `.env` file:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_saw
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. Run migration database:

    ```bash
    php artisan migrate
    ```

7. Run seeder database:

    ```bash
    php artisan db:seed
    ```

8. Run website:

    ```bash
    npm run dev
    php artisan serve
    ```

## Screenshot

- ### **Dashboard**

<img src="https://github.com/user-attachments/assets/177f897e-600a-4d15-a565-4e7a0a8c2b66" alt="Halaman Dashboard" width="" />
<br><br>

- ### **Criteria page**

<img src="https://github.com/user-attachments/assets/2469c1c7-e0c0-45c3-9e9f-d19ed0c90219" alt="Halaman Kriteria" width="" />
<br><br>

- ### **Penilaian page**

<img src="https://github.com/user-attachments/assets/bd5048b9-ee13-4836-abef-f9f137e9ed5e" alt="Halaman Penilaian" width="" />
<br><br>

- ### **Result page**

<img src="https://github.com/user-attachments/assets/265df2e9-8f8e-4f81-95b6-776d28c6c98c" alt="Halaman Penilaian" width="" />
<br><br>
