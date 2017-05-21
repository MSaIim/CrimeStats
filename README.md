# ![](http://i.imgur.com/Mn7sttC.png) Crime Statistics
Rutgers University database project website using HTML, CSS, PHP, and SQL to query for information.

The website gives you statistics about crime from the year 2015. It aims to be as dynamic as possible so the user can pick out the information they want to know about without any forced queries.

+ Database stored using MySQL.
+ PHP PDO used for database connection and queries.
+ Bootstrap used for the frontend.

## ![](http://i.imgur.com/7tiJlv5.png) Usage
You must have php install on your server. Recommendation: Use Apache or Nginx to run the web server and then install php7.0. If going the Apache route, put the website folder inside `/var/www/html/` (under Linux). The website URL will be `localhost` where you should see the uploaded folder.

Next, install MySQL on your machine and create a database called `CrimeStats`:

```sql
CREATE DATABASE IF NOT EXISTS CrimeStats;
```

Download the `.sql` files provided inside the `tables` folder and import the tables. The scripts include create table queries so you should only have to run them. If using MySQL Workbench, go to `Server > Data Import` and navigate to the folder with the `.sql` files.

Finally, inside `assets/php/Connection.php`, edit the `$username`, `$password`, and `$hostname`. The `$database` value will most likely not change.
