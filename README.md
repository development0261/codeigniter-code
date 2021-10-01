# RestaurantCart

Make sure
⁨- /system⁩/spotneat⁩/session folder exists with write permission

Import the RestaurantCart.sql file and

Configure the database here
- /system/spotneat/config/database.php
- api_v1/config/databae.php

Provide write permissions for
- assets/images

Add the firebase.json in 
- root path
- api_v1

Add Google map api key in 
admin panel -> settings -> restaurant ->Google Maps API Key


# test
Always use model for writing queries.
	https://prnt.sc/1ud18h9

Use routing as more we can use.

Use phpmailer for sending mails to user.
	https://www.codexworld.com/codeigniter-send-email-using-phpmailer-gmail-smtp/
	https://github.com/ivantcholakov/codeigniter-phpmailer
	https://www.geeksforgeeks.org/how-to-send-an-email-using-phpmailer/

Use tabular coding standards for proper function calling. We can use Visual code for best coding structure.

If we are using one variable at some places with same name make sure that variables values are not going to be changed.
Use unique name for variable at same page.
Use minimal join queries for fetching data if more than 3 tables join needs specifically in pagination.
Use helpers for using more than one time function use is happening.
Use migrations for creating tables in database. 
Do not use any live CDN in projects. Download and use where it needs.
Use comments for defining any function and before we modify any existing code.