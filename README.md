Avatar
======

A Symfony project created on December 17, 2016, 3:10 pm.

This project was created for admin Avatar to users. The user can create avatars,
delete avatars and relate avatars with any email.

MINIMUM REQUIREMENTS

In the server, must be intall apache, php 5.6, mysql, composer and git.


INSTRUCTIONS FOR INSTALATION:

1. The project repository is in:

https://github.com/deividaguilar/intra.git

2. Clone the project in documentRoot of your server with the next command:

git clone https://github.com/deividaguilar/intra.git

3. Enter to directory "intra" and updates the vendor with the next command:

composer update

4. Enter the parameter for the aplication when the procces ask for it:

database_host (127.0.0.1):
database_port (null):
database_name (symfony): avatar_db
database_user (root): avatar_usr
database_password (null): 1V1t1r_5sr
mailer_transport (smtp):
mailer_host (127.0.0.1):
mailer_user (null):
mailer_password (null):
secret (ThisTokenIsNotSoSecretChangeIt)

5. Create the database and relate an user. Must be the same database name and 
username that entered in parameters. The user must have all privileges with the 
avatar_db database.

6. Test the aplication in your browser ..intra/web/app.php/ , and if shows a similiar error with 
this "Fatal error: Uncaught exception 'RuntimeException' with message 'Unable to 
create the cache directory", correct the permissions for the directories "var 
and web" with next command. These only work in linux. (if doesn't work, review 
the documentation in symfony. http://symfony.com/doc/current/setup/file_permissions.html)

HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`

sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var

sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX web
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX web

7. Update the database schema whit the next command:

php bin/console doctrine:schema:update --force

8. Create the Default avatar, upload the first image. This image would be the 
default avatar and can't be deleted. Images can only weigh 1MB for upload.

PARTICULARITIES OF USE:

1. It can't delete an Avatar if this is relate with some email.
2. It can't delete the default avatar.

THIRD PARTY VENDORS:

To create the API Rest was installed FOS\RestBundle\FOSRestBundle(). This API
response by routin /avatars/.




