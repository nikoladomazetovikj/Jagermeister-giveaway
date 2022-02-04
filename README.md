# Jagermeister-giveaway

## Project Setup
 ### Configuration
  - To set up this project you need to set the values of the constants in config/confing.php
   1) You need to set values of web url, image url (images should be stored in images folder or you can create a new one)
   2) Also you need to specify the email address from which mails will be sent

  ### Database
   - Please follow this instructrions:
   1) Import sql file from "database/jagermeister.sql" to your database
   2) Now set the db values in config.php
   3) Now set the db values in config.php
  
  ### Index page
  1) User has only 3 attempts to upload and send a correct image, otherwise the user will be blocked for 24h.
  2) Valid image data : png, jpg, jpeg
  3) Valid email address : checked by regex
  
  ### Login
  - The admins are stored in database(table: admins)
  - You can change manually the values in the database
  
  ### Dashboard
  - On the left side there is an admin panel for navigation and filtering
  - If you want to get a report you should click on "Get report" button to download an excel file.

### Admin page
 - To access admin page go to: "on route web_link/admin/login.php"
  
