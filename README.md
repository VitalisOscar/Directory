## DirectoryX

DirectoryX is a places directory where:

- Business owners can add their businesses
- Users can discover added businesses
- Users can rate and review businesses
- Users can acknowledge businesses
- Users can chat with businesses
- Users can view chats started with businesses any time

## Database Setup
- Open the database setup sql file [core/config/db.sql](https://github.com/VitalisOscar/Directory/blob/master/core/config/db.sql)
- Copy the contents and execute them in your mysql client e.g phpmyadmin
- Ensure the database connection settings (host, username and password) in [core/config/db.php](https://github.com/VitalisOscar/Directory/blob/master/core/config/db.php) are ok

## Routing
- Open [core/config/routing.php](https://github.com/VitalisOscar/Directory/blob/master/core/config/routing.php) and set the BASE_URL value to the full root url you will be using to access the project e.g http://localhost/projects/directoryx/ (Ensure the url ends in a '/' for routing to properly work)

## Uploads setup
- Open [core/config/misc.php](https://github.com/VitalisOscar/Directory/blob/master/core/config/misc.php)
- Set the **[FILE_UPLOADS_DIRECTORY] value to the full directory path of the uploads sub-folder in the project e.g **[C:/xampp/htdocs/projects/directoryx/uploads] in windows or **[/opt/lampp/htdocs/projects/directoryx/uploads] in linux where C:/xampp/htdocs/projects/directoryx is the project path

## Other setup
Still under the [core/config/misc.php](https://github.com/VitalisOscar/Directory/blob/master/core/config/misc.php) file:
- Set the **[GOOGLE_MAPS_API_KEY] value to a key your google maps project api key
- The project uses [TalkJs](https://talkjs.com) to facilitate chats. Sign up and get a talk js app id then set it to the **[TALKJS_APP_ID] constant