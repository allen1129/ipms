IP Management System (IPMS)
Overview
The IP Management System (IPMS) is a web application designed to manage IP addresses efficiently. It provides features for listing, creating, editing, and showing IP entities, along with user authentication for secure access.

Commits and Codes Descriptions
Frontend (FE)
[FE-001]: List Changes
[FE-002]: Create
[FE-003]: Edit
[FE-004]: Show
[FE-005]: Login
Backend (BE)
[BE-001]: List
[BE-002]: Create
[BE-003]: Edit
[BE-004]: Show
[BE-005]: Authentication
Installation Guide
Frontend (ipms-fe)
The frontend application (ipms-fe) is built using the latest version of Vue.js.

Dependencies
Bootstrap: npm i bootstrap
Vue Router: npm i vue-router
SweetAlert2: npm i sweetalert2
Axios: npm i axios
Backend (ipms-BE)
The backend application (ipms-BE) uses the latest version of Vue.js with PHP 8+.

Dependencies
Symfony ORM Pack: composer require symfony/orm-pack
Symfony Maker Bundle (development): composer require --dev symfony/maker-bundle
Nelmio API Doc Bundle: composer require nelmio/api-doc-bundle
Nelmio CORS Bundle: composer require nelmio/cors-bundle
Symfony Security Bundle: composer require symfony/security-bundle
Doctrine Fixtures Bundle (development): composer require --dev doctrine/doctrine-fixtures-bundle
API Platform Core: composer require api-platform/core
Symfony Validator: composer require symfony/validator
JWT Authentication
For JWT authentication, use:

bash
Copy code
composer require lexik/jwt-authentication-bundle
Setup Instructions
Backend
Create tables with initial data:

sql
Copy code
migrate create tabledata
Run migrations:

bash
Copy code
php bin/console make:migration
php bin/console doctrine:migrations:migrate
Load sample data:

bash
Copy code
php bin/console doctrine:fixtures:load
Frontend
No additional setup steps required.

Example Credentials
Email: test@example.com
Password: test123
Note
Due to difficulties in setting up PHPUNIT tests and issues with OAuth2 configuration, JWT authentication was used instead. This decision was made due to time constraints and the familiarity of using JWT authentication compared to OAuth2 in Laravel.
