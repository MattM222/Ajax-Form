# Sky Betting & Gaming Technical Test by Matthew Moore

## Languages used:
| Ajax | PHP | JavaScript | CSS | HTML |

## Files/folders included

Form.php 
  - This is the front end display where the form is sent to from submit.php

Submit.php
 - This is where all the input data is sent to be conformed and updated to the database, this is then sent back by ajax to update
  the form inputs
  
controller.php
 - This is added so the form can easily be edited by a web developer to change the default display. i.e more columns/rows

functions.php
 - This is where i put the functions for ajax and database updating
 
datastore.set
 - This is the file based datastore for input form data. It contains a serialized array of the user inputs
 
/css/style.css
 - Cascading Style Sheet containing the styling attributes
 
/img/
 - Folders containing images for the buttons used
 
/js/
 - Localized javascript library

## Description of the form

The form works by using an ajax GET request function. All the data is handled and displayed by the submit.php file which is then sent back to form.php
The reason i chose Ajax is because it provides a seamless transition of data transfer from the front-end to the datastore.ser and is still secure. This can be used with relational SQL tables.
I wanted to ensure the page didnt do a full refresh each time data was submitted as that adds extra server resource usage as the page would have to be fully reloaded each time an update was made.
I have stored all the data in a serialized array which is updated to the datastore.ser file. For security reasons if the file is not present it will create a new one, this means a new file would not need to be manually added.
As this data isn't being added to an SQL database i didnt put any SQL injection protection in place.


## How to use the form

I tried to keep the form as simple as possible but i also wanted to make it scalable so some features have been added. The form works the same as a normal update field form but i have added column and row adding/removing functions. To add/remove rows and columns there are two images (a green plus and a red minus) at the bottom of the form which can be clicked to update the form, i have labelled them accordingly. There is also a submit button to update the form. For testing purposes i added a display below the table which shows you an array of the data that has been updated so you don't have
to look in the datastore.ser

## Other features i wanted to add but i ran out of time

I wanted to add the function to allow a user to update the form headers rather than naming them generically Column{number}. My method for this would have been a drop down list for adding designated header titles rather than a plus/minus function.
I also wanted to add the function to remove specific rows and columns
