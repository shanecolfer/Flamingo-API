Flamingo API
===
General
---
The flamingo API is made up of 6 functionalities that can be performed by the user.
The 6 functionalities are in 6 files in the flamingo/api/dockerfiles folder,
these are: `create.php` , `read.php` , `read_single.php`, `upload.php`, `upload_rating`, `get_rating`.

The class Database.php inside the config folder contains variables which define
important things relating to your Database, you can change the values of these
variables to suit your running DB. These values are host, db_name, username,
and password.

You can run the API for testing using XAMPP.

1. Download xampp and run an apache and an sql server.

2. Navigate to localhost/phpmyadmin.

3. Create a database called flamingo.

4. Import the dockerfiles.sql table provided in the gitlab into the flamingo DB. (You'll have to populate it with some data for testing).

5. Create a folder in xampp/htdocs called uploads1, this will store uploaded files.

6. Extract FlamingoAPI within xampp/htdocs.

7. Change the name of the folder from 'flamingoapi-master' to 'flamingo', this needs
   to be done as the files reference each other in the code using this folder name.

8. You can then make requests to each file of the API. The file locations should
   look something like this: http://localhost/flamingo/api/dockerfiles/read.php (or whatever file you want to request).

---

## 1. Create.php

Create.php accepts post requests with a raw entry body. This function is for
manually inserting into the database. The id field in the DB is set to auto-
increment so no need to include that. The raw body input looks like this:

```
{
            "title": "Hello There",
            "description": "Hello There",
            "author": "Hello There",
            "size": "12312",
            "path": "localhost/mysecondapp.rar"
}
```
---

## 2. Read.php

Read.php accepts GET requests with no body or input. A GET request will return
a .json with an array called data, within that array is each item on the database.

The output of read.php should look like this (depending on what's in the DB): 

```
{
    "data": [
        {
            "id": "32",
            "title": "hello-flamingo",
            "description": "This is a Hello World Flamingo app for testing purposes.",
            "author": "Dennis Schüßler",
            "size": "2416",
            "path": "localhost/uploads1/hello-flamingo-master"
        },
        {
            "id": "33",
            "title": "hello-flamingo",
            "description": "This is a Hello World Flamingo app for testing purposes.",
            "author": "Dennis Schüßler",
            "size": "2416",
            "path": "localhost/uploads1/hello-flamingo-master"
        },
        {
            "id": "34",
            "title": "Test_Json",
            "description": "",
            "author": "Shane Colfer",
            "size": "366",
            "path": "localhost/uploads1/dockertest1"
        }
    ]
}
```
---

## 3. Read_single.php

Read.single.php accepts GET requests where key=id. For the value of id you put the id number
of the app you want to be returned, read_single.php will then return you a .jsonified array
with information about the app with that ID.

If you entered 33 for the value of id you would get this: 

```
{
    "id": "33",
    "title": "hello-flamingo",
    "description": "This is a Hello World Flamingo app for testing purposes.",
    "author": "Dennis Schüßler",
    "size": "2416",
    "path": "localhost/uploads1/hello-flamingo-master"
}
```
---

## 4. Upload.php

Upload.php accepts a POST request using form-data, use file for the key and whatever
.zip file you want to upload as your value.

The file will be uploaded to the htdocs/uploads1 folder and unzipped. An entry
will then be made into the database using the app.json file contained in your upload.

If the .zip you uploaded is the correct structure, was uploaded correctly, and entered
into the database you will get a return message like this: {"MESSAGE":"UPLOAD SUCCESS","STATUS":200}.

If the .zip is an invalid structure you will get a return message like this: {"MESSAGE":"UPLOAD FAILED","STATUS":404}

If the title of the app is a duplicate, you will get a message like this: {"MESSAGE":"UPLOAD FAILED DUPLICATE APP","STATUS":404}

---

## 5. Upload_rating.php

Upload rating can be used to upload a rating from 1 to 5 for an app.

Upload_rating accepts a POST request where key = id. For the value id use the id of the app you want to rate.

If input is correct you will receive get a return message like this :
```
{
    "MESSAGE": "UPDATE SUCCESS",
    "STATUS": 200
}
```

If your rating is below 0 or greater than 5 you will receive a message like this:
```
{
    "MESSAGE": "UPDATE FAILED RATING OUT OF BOUND",
    "STATUS": 404
}
```

---

## 6. Get_rating.php

Get rating is used to get just the average rating of an app on the DB. The rating system rounds average ratings to the nearest integer so any rating
you get will just be an int.

Get rating accepts a GET request where key = id. Send the GET request with the id of the app you 
want the average rating of.

If the id exists you will get a return array with the average rating like this: 

```
{
    "a_rating": 4
}
```