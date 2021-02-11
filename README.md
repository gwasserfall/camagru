## Camagru

Social media site project for WeThinkCode_ in PHP without the use of frameworks.

- MVC pattern implemented without frameworks
- PHP PDO database connection

Bulma CSS framework used for frontend

## Project Brief

### Instructions

This web project is challenging you to create a small web application allowing you to
make basic photo and video editing using your webcam and some predefined images.

App’s users should be able to select an image in a list of superposable images (for
instance a picture frame, or other “we don’t wanna know what you are using this for”
objects), take a picture with his/her webcam and admire the result that should be mixing
both pictures.
All captured images should be public, likeables and commentable.

### Restraints

- Must use PHP programming language, no frameworks allowed. Only the standard library
- Web application must produce no errors, no warning or log line in any console, server side and client side
- Client-side, your pages must use HTML, CSS and JavaScript.
- No javascript frameworks are allowed. CSS frameworks are allowed, only those that don't include javascript
- PHP PDO abstraction driver must be used to connect to the database. PDO::ERRMODE_EXCEPTION must be set
- MVC should be used where possible, although this is not a requirement
- Web application must be secure, account for XSS and SQL injection

## Setup

### Requirements

- PHP v.7 +
- MySQL v8

### Development

To initialise the application database and load stickers into the database run the setup.php script from the base directory. This assumes that you have a MySQL server running and ready to accept connection.

``` php setup.php ```

Example:

```
Camagru initial setup.
Please complete the following.

MySQL username [root] : 
MySQL password [] : password
MySQL host     [127.0.0.1] : 

Connection to database successfull, setting values in ./app/Config/Config.php

Create camagru database? [Y/n] : 

Database camagru created

Create database tables? [Y/n] : 

Created table [users]
Created table [posts]
Created table [comments]
Created table [likes]
Created table [stickers]

Load stickers? [Y/n] : 

Cleaned [stickers] table
Added 46 stickers.


Setup complete, to launch webserver use : 'php -S 0.0.0.0:8000 -t public/'
```

The built in PHP webserver is used to run the app.


## Testing

See tests/ directory