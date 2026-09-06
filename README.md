\# TechInsight by Joshua Brown-Campbell



TechInsight is a PHP and MySQL technology product comparison and price-tracking dashboard.



\## Features



\- Browse technology products

\- Compare products

\- View market trends

\- Update product prices

\- Store product information in a MySQL database



\## Requirements



\- XAMPP

\- Apache

\- MySQL

\- PHP

\- A modern web browser



\## Installation



1\. Download or clone this repository.

2\. Place the project folder in the XAMPP `htdocs` directory:



&#x20;  ```text

&#x20;  C:\\xampp\\htdocs\\techinsight

&#x20;  ```



3\. Start Apache and MySQL from the XAMPP Control Panel.

4\. Open phpMyAdmin:



&#x20;  ```text

&#x20;  http://localhost/phpmyadmin/

&#x20;  ```



5\. Create a database named:



&#x20;  ```text

&#x20;  YOUR\_DATABASE\_NAME

&#x20;  ```



6\. Import the included SQL file into that database.

7\. Copy the example configuration file:



&#x20;  ```text

&#x20;  includes/db.example.php

&#x20;  ```



&#x20;  and rename the copy to:



&#x20;  ```text

&#x20;  includes/db.php

&#x20;  ```



8\. Update `includes/db.php` with the database name and local connection settings.

9\. Open the project:



&#x20;  ```text

&#x20;  http://localhost/techinsight/

&#x20;  ```



\## Security note



The `includes/db.php` file is intentionally excluded from Git because it may contain personal local database credentials. Please use `includes/db.example.php` as the configuration template.

