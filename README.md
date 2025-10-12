# OpenSalesInventory

## Overview

Simple customizable website for organizing and managing products and inventory. 

The primary goal is to create something customizable so users can easily bring up a web site, customize it with basic themeing (logo, site name, colors, etc), and then create products, allow users to view and select them, manage inventory, and also orders. 

## WORK IN PROGRESS
This is currently very much a work in progress to serve as a teaching / learning platform to go alongside some tutorials about programming and developing a websiste with PHP and up-to-date coding practices using the PDO MySQL connector to access the database. 

Tutorials and reference information will be updated at the below blog and YouTube channel. 
https://opensourcetechtrn.blogspot.com/
https://www.youtube.com/@opensourcetechtraining64


## Goals / Tasks
- Create and manage users -- ready
- Handle logins and split out customers from admins -- ready
- Manage products and uploads -- ready
- Allow for images to be uploaded for the products  -- TBD
- Create a product view page -- TBD
- Allow for detailed product view -- TBD
- Manage orders -- TBD
- Manage inventory -- TBD
- Create some smart metrics to help analyze stock and planning -- TBD
- Allow for site admins to customize the look and branding of the website -- TBD

### Out-of-scope
Payment processing is currently not planned, but should be possible to include with 3rd party APIs, but to my knowledge all payment processing tools require some proof of an organization in order to help process biling and cash flow. Therefore, payment processing will be out-of-scope for this relatively small project until I have more core parts complete, and might be something that users will need to alway re-implement with their organization-specific API key from the payment processing provider.

## Bring up
To bring up the website there is a reference Docker compose and Dockerfile in the repo that should work simply by running the following command from the same directory as where the repo clone is located:

```
docker-compose up -d
```
If a different directory is desired for mapping to the DB root and the web server root, that can be adjusted in the docker-compose.yml file
