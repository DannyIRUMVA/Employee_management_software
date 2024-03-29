**Employee_management_software README**

---

### Project Description

This project is a Backend API Server for Employee Management with Attendance Recording and Reporting. 
It is built using 
**Laravel 10**
**PHP Unit/Pest for tests**
**Laravel Sail**
**Laravel Sanctum for authentication**
**laravel-snappy(for pdf reports)**
**Laravel Excel(for excel reports)**
**Mailpit**. 
The project aims to:
Full authentication system using Sanctum(Register, Login, Logout, Forgot password, Password reset)
Employee CRUD, with minimum fields(names,email,employeeIdentifier,phoneNumber) all we care about is the thing to work
Attendance management, record when an employee arrives at the office and when they leave
Send email(using queues) to the employee when an attendance record is made
Generate attendance report(pdf & excel) with daily attendance data.

---

### Installation and Setup

Follow these steps to deploy and run the project in your local environment using Laravel Sail:

#### Prerequisites

Make sure you have the following installed on your machine:

- [Docker](https://www.docker.com/) and [Docker Compose](https://docs.docker.com/compose/)

#### Steps

1. **Clone the Repository:**

    ```bash
    https://github.com/DannyIRUMVA/Employee_management_software.git
    ```

2. **Start Laravel Sail:**

    Navigate to your project directory and run the following command to start Laravel Sail:

    ```bash
    cd Employee_management_software
    ./vendor/bin/sail up -d
    ```

3. **Install Dependencies:**

    Once Sail is up and running, install PHP and JavaScript dependencies:

    ```bash
    ./vendor/bin/sail composer install
    ```

4. **Setup Environment Variables:**

    Laravel Sail automatically generates a `.env` file. If you need to make any changes, you can edit this file directly.

5. **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

6. **Database Migration:**

    Run the database migrations to create the necessary tables:

    ```bash
    php artisan migrate
    ```

7. **Run the Application:**

    Laravel Sail provides a convenient way to access your application at `localhost`. You can access it in your browser:

    ```
    http://localhost
    ```

8. **Run Tests:**

    To run tests, use the following command:

    ```bash
    php artisan test
    ```

---

### Contributing

We welcome contributions from the community. If you'd like to contribute to this project, please follow these guidelines:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Make your changes.
4. Commit your changes (`git commit -am 'Add new feature'`).
5. Push to the branch (`git push origin feature/your-feature`).
6. Create a new Pull Request.

---

### License

This project is licensed under the [MIT License](LICENSE).

---

Feel free to customize this README based on your project's specific requirements and configurations.
