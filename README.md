<h1>Smiling Geckos</h1>

Welcome to the Smiling Geckos. This Symfony 5.4 application allows to manage and operate an husbandry site with reservation system.

<h2>Getting Started</h2>

These instructions will help you set up and run the Smiling Geckos app on your local machine for development and testing purposes.

<h4>Prerequisites</h4>

Before you begin, make sure you have the following software installed on your system:

    PHP (>=7.4)
    Composer (https://getcomposer.org/download/)
    Symfony CLI (https://symfony.com/download)
    SQLite or any database system compatile with Doctrine DBAL

<h4>Installation</h4>

Follow these steps to set up the Gekota Shop App:

1. Clone the repository to your local machine:
   
       git clone https://github.com/OskarLukaszewicz/smilinggeckos.com.git
   
2. Navigate to the project directory:

        smilinggeckos.com

3. Install the project dependencies using Composer:

        composer install

4. Create database (SQLite needed), migration, migrate and load data fixtures:

       php bin/console app:setup --create-database --make-migration --run-migration --load-fixtures

5. Start the Symfony development server:

       symfony server:start

6. Access the app in your web browser:

        http://127.0.0.1:8000

<h2>Usage</h2>

<h3>Frontend</h3>

Most of the frontend is a Single-page App created with React.js.

Visit the homepage to explore the Blog, About, Contact, Terms and Offer sections.

Offer section gives an access to a reserviation system.

The frontend communicates with the backend through a RESTful API (check '/api' path for details).

<h3>Backend</h3>

Use the admin panel (accessible at '/admin', created with EasyAdminBundle) to manage reservations, products, users, posts, comments and images.

CRUD controllers provide the CRUD operations for Doctrine ORM entities. Each of these controllers is associated to one entity and one dashboard.

The backend provides endpoints in the form of a RESTful API (created with Api Platform).

<h4>Features</h4>

The reservation system lets the client to reserve products. The Mailer service handles the logic of automated email delivery both to the client and the admin. To make it work, certain variables in .env file are needed.

Recaptcha in this release is turned off. Certain variables in .env file are needed to make it work.
 
There are many minor features working inside of controllers.

<h4>Thanks for Reading!<h4>
