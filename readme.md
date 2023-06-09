# EasyBreezyBlog Installation Guide

This guide provides step-by-step instructions to help you set up an existing Vue.js and Laravel project on your local machine. Follow the instructions below to get started with these frameworks.

## Prerequisites

Before you begin, make sure you have the following software installed on your machine:

- Node.js: [Download and Install Node.js](https://nodejs.org/en/download/)
- Composer: [Download and Install Composer](https://getcomposer.org/download/)

## Vue.js Setup

1. Open your terminal or command prompt.

2. Navigate to the root directory of your Vue.js project (frontend directory).

3. Run the following command to install the project dependencies:

   ```
   npm install
   ```
4. After the installation is complete, copy the `.env.example` file and rename it to `.env`. You can use the following command:

   ```
   cp .env.example .env
   ```
   
5. After the installation is complete, you can build the Vue.js project by running the following command:

   ```
   npm run dev
   ```
   This will start local server on http://localhost:5173.



## Laravel Setup

1. Open your terminal or command prompt.

2. Navigate to the root directory of your Laravel project (backend directory).

3. Run the following command to install the project dependencies:

   ```
   composer install
   ```

4. After the installation is complete, copy the `.env.example` file and rename it to `.env`. You can use the following command:

   ```
   cp .env.example .env
   ```

5. Generate a unique application key by running the following command:

   ```
   php artisan key:generate
   ```

6. Run the database migrations using the following command:

   ```
   php artisan migrate
   ```

   This will create the necessary database tables for your Laravel project.

## Running the Project

1. After completing the Vue.js and Laravel setup steps, you can start the development server.

2. Open a new terminal or command prompt window and navigate to the root directory of your Vue.js project.

3. Run the following command to start the development server:

   ```
   npm run dev
   ```

   This will start the Vue.js development server, and you can access your Vue.js application at [http://localhost:5173](http://localhost:5173).

4. To run the Laravel backend, open another terminal or command prompt window and navigate to the root directory of your Laravel project.

5. Run the following command to start the Laravel development server:

   ```
   php artisan serve
   ```

   This will start the Laravel server, and you can access your Laravel application at [http://localhost:8000](http://localhost:8000).

Congratulations! You have successfully set up your existing Vue.js and Laravel project. You can now make changes to your code, run the development server, and access your application in the browser. Happy coding!