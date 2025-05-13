# Personal Portfolio App

## Overview

This is a personal portfolio web application built with the Symfony framework. The purpose of the app is to serve as a comprehensive showcase of my skills, experience, and projects as a backend developer. Recruiters can access my certificates, resume, and view a collection of works spanning various PHP technologies, APIs, Symfony, Laravel, and pure PHP.

## Features

- **Certificates:** Showcase your academic and professional certifications.

- **Resume:** Provide a detailed overview of your skills, experience, and achievements.

- **Projects:** Highlight your notable works and projects, categorizing them based on the technologies used (Symfony, Laravel, pure PHP, etc.).

- **Blog Page:** Share your insights, experiences, and updates related to technology and development.

- **Resume Page:** A dedicated page with a summary of your skills, experience, and downloadable resume.

- **Contact Page:** Allow visitors, including recruiters, to get in touch with you easily.

- **Admin Panel:** Manage the content of your portfolio, including certificates, resume, projects, and blog posts.

## Getting Started

### Prerequisites

- Ensure you have [Composer](https://getcomposer.org/) installed.
- Configure your web server to host Symfony applications.

### Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/your-username/your-portfolio-app.git
    ```

2. Install dependencies:

    ```bash
    cd your-portfolio-app
    composer install
    ```

3. Set up the database:

    ```bash
    symfony console doctrine:database:create
    symfony console doctrine:migrations:migrate
    ```

4. Start the Symfony server:

    ```bash
    symfony server:start
    ```

5. Access the app at [http://localhost:8000](http://localhost:8000) in your web browser.

## Usage

1. Populate your certificates, resume, projects, and blog posts by updating the relevant sections in the app.
2. Customize the project details to reflect your skills and experiences.
3. Recruiters can navigate through the app to gain insights into your profile.
4. Access the admin panel at [http://localhost:8000/alex-login](http://localhost:8000/alex-login) to manage the content.

## Contributing

If you'd like to contribute to this project, feel free to submit pull requests. Bug reports, feature requests, and feedback are also welcome.

## Acknowledgments

- Symfony framework: [https://symfony.com/](https://symfony.com/)
- Laravel framework: [https://laravel.com/](https://laravel.com/)

## Contact

For inquiries and feedback, please contact [nwokoriealex20@gmail.com](mailto:nwokoriealex20@gmail.com).

