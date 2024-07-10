README
Backend Assignment v1.0: CRUD Blog Web Application

This document provides instructions on how to set up and run the code for the CRUD Blog Web Application built using Yii v1.1 for the backend and MySQL for the database. The frontend is developed using native HTML, CSS, JavaScript, and Bootstrap/Tailwind.
Table of Contents

    Requirements
    Setup
    Configuration
    Running the Application
    Features
    Bonus Feature

1. Requirements

    PHP 5.1.0 or higher
    Yii Framework v1.1
    MySQL
    Web Server (e.g., Apache, Nginx)
    Composer
    Node.js (for frontend if using frameworks like React.js)
    Git

2. Setup

1. Clone the Repository

sh

git clone https://github.com/yourusername/your-repo.git
cd your-repo

2. Install Composer Dependencies

sh

composer install

3. Install Frontend Dependencies (if using a framework like React.js)

sh

npm install

4. Configure the Database
Create a MySQL database and update the database configuration in protected/config/main.php:

php

'db'=>array(
    'connectionString' => 'mysql:host=localhost;dbname=your_database_name',
    'emulatePrepare' => true,
    'username' => 'your_db_username',
    'password' => 'your_db_password',
    'charset' => 'utf8',
),

5. Run Database Migrations
Ensure your database is set up with the necessary tables by running the migrations.

sh

php protected/yiic migrate

3. Configuration

1. Email Verification
Update the email verification token generation logic in the User model:

php

public function generateVerificationToken() {
    $this->verification_token = Yii::app()->securityManager->generateRandomString() . '_' . time();
}

4. Running the Application

1. Start the Web Server
You can use built-in PHP server for testing purposes:

sh

php -S localhost:8000

Or configure your Apache/Nginx server to point to the public directory of your project.

2. Access the Application
Open your web browser and navigate to:

arduino

http://localhost:8000

5. Features

Authentication

    Signup: Users can register by providing a username, email, and password.
    Signin: Registered users can log in using their email and password.
    Email Verification: After signup, users receive a token to verify their email (no real email sending, just token generation and verification logic).

CRUD Operations

    Create: Verified users can create new blog posts.
    Read: Users can view public blog posts.
    Update: Verified users can edit their blog posts.
    Delete: Verified users can delete their blog posts.

Form Validation

    Implemented multiple validation rules for fields such as email, password, and blog post content.

Blog Post Visibility

    Users can mark their posts as public or private.

Likes

    Users can like blog posts.

Search and Filter

    Users can search for blog posts by title or description.
    Users can filter blog posts by date and author.

6. Bonus Feature


Conclusion

You have successfully set up and run the CRUD Blog Web Application using Yii v1.1 and MySQL. Follow the instructions to explore the features and the bonus real-time public webpage. For any issues or contributions, please refer to the repository's issue tracker and contribution guidelines.