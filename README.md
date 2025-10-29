# OpenSalesInventory

## Overview

Simple customizable website for organizing and managing products and inventory. 

The primary goal is to create something customizable so users can easily bring up a web site, customize it with basic themeing (logo, site name, colors, etc), and then create products, allow users to view and select them, manage inventory, and also orders. 

## WORK IN PROGRESS
This is currently ***very much a work in progress*** to serve as a teaching / learning platform to go alongside some tutorials about programming and developing a websiste with PHP and up-to-date coding practices using the PDO MySQL connector to access the database. 

Tutorials and reference information will be updated at the below blog and YouTube channel. 

https://opensourcetechtrn.blogspot.com/

https://www.youtube.com/@opensourcetechtraining64

## Goals / Tasks
- Create and manage users -- ready
- Handle logins and split out customers from admins -- ready
- Manage products and uploads -- ready
- Allow for images to be uploaded for the products  -- ready
- Create a product view page -- ready, but the design may be adjusted later
- Allow for detailed product view -- Basic version ready
- Manage inventory -- TBD
- Manage orders -- TBD
- Create a search bar for finding products and filtering types
- Create some smart metrics to help analyze stock and planning -- TBD
- Allow for site admins to customize the look and branding of the website -- TBD

### Out-of-scope
Payment processing is currently not planned, but should be possible to include with 3rd party APIs, but to my knowledge all payment processing tools require some proof of an organization in order to help process biling and cash flow. Therefore, payment processing will be out-of-scope for this relatively small project until I have more core parts complete, and might be something that users will need to alway re-implement with their organization-specific API key from the payment processing provider.

## Bring up
To bring up the website there is a reference Docker compose and Dockerfile in the repo that should work simply by running the following command from the same directory as where the repo clone is located:

```
docker-compose up -d
```
If a different directory is desired for mapping to the DB root and the web server root, that can be adjusted in the docker-compose.yml file. 

On first login there is a default admin user provisioned with the below credentials:
```
User: admin
PWD: admin123456
```

This should be changed and can be after first login.

### Adjust the defaults

All of the database names and passwords are defined both in the docker-compose.yml file and under Work/MySQLlogin.ini. For security it is recommended to move the MySQLlogin.ini file to outside of the webserver root container to somewhere else - such as var/www before html - on the websvr-lamp container. Doing so also requires that line 3 in the header.php file also be adjusted to reflect the corect file path. 

```
	$login = parse_ini_file('/var/www/html/MySQLlogin.ini');
```

## Troubleshooting

If the images have issues being uploaded, please ensure the image directory has the correct permissions - it should be owned by the Apache user of the web server container, or can be opened as 777 on the host system assuming the system is otherwise well protected. The max post size in the Dockerfile is set to 20 MB in max size, which could be increased, but the page isn't really meant to be a file management system so if it is adjusted too large there will likely be some lag or other consequences. 
