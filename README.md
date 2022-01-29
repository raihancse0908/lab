## Application Configuration

Change Base URL >
`App/Config/App.php` >
Line: 26

## Database Configuration

`App/Config/Database.php` >
Line: 35 to 38

Migrate Database >
Run this command from project root >
`php spark migrate`

Or import database from SQL file located in `/database/lab.sql`

## Test API

Add User 
`http://localhost/lab/public/register`

Login
`http://localhost/lab/public/login`

Post
`http://localhost/lab/public/post`

Page
`http://localhost/lab/public/page`

User Feed
`http://localhost/lab/public/feed`

Follow Person
`http://localhost/lab/public/follow_person`

Follow Page
`http://localhost/lab/public/follow_page`

## Server Requirements
PHP version 7.3 or higher is required, with the following extensions installed:
- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
