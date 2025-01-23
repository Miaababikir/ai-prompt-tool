# AI Prompt tool

AI prompt tool that will allow users to generate AI-powered prompts for various use cases. And also having the ability to see reports on the generated prompts.

## Requirements

- PHP 8.0+
- Composer
- Node.js (with npm)
- MySQL (or any other compatible database)

## Setup and Installation

### 1. Clone the Repository

Clone this repository to your local machine:

```bash
https://github.com/Miaababikir/ai-prompt-tool
```

### 2. Install Backend Dependencies

Navigate to the backend folder and install PHP dependencies using Composer:

```bash
cd ai-prompt-tool/backend
composer install
```

### 3. Set Up Environment Variables

Create a .env file in the root of the backend folder and configure your environment variables. You can copy the contents of the .env.example file and update the database, app key, and other required settings.

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Migrate and Seed the Database

Run the database migrations to create the required tables in the database:

```bash
php artisan migrate
php artisan db:seed
```

### 5. Install Frontend Dependencies

Navigate to the root folder and install JavaScript dependencies using npm:

```bash
npm install
```

### 6. Start the Development Server

Start the Laravel development server:

```bash
php artisan serve
```

Start the frontend development server:

```bash
npm run dev
```

### 7. Access the Application

You can now access the application by visiting http://localhost:8000 in your web browser.


