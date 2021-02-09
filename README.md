## Camagru

Social media site project for WeThinkCode_ in PHP without the use of PHP frameworks.

- MVC pattern implemented without frameworks
- PHP PDO database connection

Bulma CSS framework used for frontend

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