# Gift register Wordpress plugin

My brother built a website for his wedding on Wordpress. He added some gifts, but wanted visitors to be able to reserve items, so as to avoid duplicate gifts. As this functionality is not included in Wordpress, I wrote him a custom PHP plugin that uses a MySQL database to keep track of reserved vs available gifts. It also allows the user to come back and 'unreserve' the gift if they change their mind.

## How it works
**Stack used**: Wordpress - PHP - MySQL - HTML - CSS - WAMP
- The site has a MySQL database which contains the id, url and image url of each gift on the page. Each database entry also gets an attribute "password" which is initially set to NULL.
- When the gift page url is requested with as query parameter a given gift id, the PHP plugin check the database to see if the password is still NULL. If it is, it displays a form allowing the user to enter a password and click 'reserve item'. Once the user enters this password, the plugin updates the database with this password for this item.
- If the database shows that the requested item does have a password set, then a message is desplayed that this item has already been reserved. A form is also displayed, in case the visitor is the one who originally reserved the item. This form allows the visitor to un-reserve the item by re-entering the password they originally used to reserve it. Upon doing so, the plugin checks if the password matches the one in the database. If it does, the database is updated to have NULL in the password field again. If it doesn't, the user is prompted to try again with the correct password.
Upon succesful completion of either form, a message is diplayed and the user is direction back to the home or gift page. 
- On the gifts page, the plugin also check which items are 'reserved', and changes the button text on that basis, so that visitors can easily see which items are reserved and which are available.

## My contribution
I implemented the back-end and my brother the front-end. 
To be able to build this functionality on my local machine, I had to download an instance of Wordpress. So 99% of the files and folders in this repositry are Wordpress-generated files. The code I wrote was exclusively for back-end functionality and can be found in:
- /wpcontent/register.php
- /wpcontent/lijst.php

## How to install this project
If you just want to see the live site in action, visit www.buggenburg.be. Please wait with testing the reserve feature until after September 12th 2021, so that my brother doesn't get his registry all bungled!
If you want to play around with the code yourself, follow these steps:
1. Download WAMP, XAMP or equivalent.
2. Clone this repository on Github into the C:\wamp\www\ folder, or equivalent.
2. Open phpMyAdmin on your local server (http://localhost/phpmyadmin/) and import the database file you downloaded when you cloned this repository. It is called 'wp_registry_ and is located in the root directory.
4. Update your local site’s wp-config.php file. It is located in the root directory of the project, and you'll need to replace the database username with your local MySQL username. If you have set a password for the MySQL user root on your localhost, then enter that password.
5. In your browser, navigate to your localhost to see the site in action. Type http://localhost/mylocalsite/, replacing 'mylocalsite' with the name of the folder you saved the project in.
6. Make sure that the plugins are activated. Go to the Wordpress dashboard by typing /wp-admin at the end of your localhost site url. Click 'Plugins' in the sidebar, and a list of installed plugins should show up. Activate the 'Register' and 'Lijst' plugins.
Note that although the Dutch version of the plugin works on the local site, you'll need to manually enter the corresponding slugs. This is because the plugin I used for the language-swithcing functionality didn't work, only in production.