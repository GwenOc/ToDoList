ToDoList
==============
Projet 4 du parcours Oc Dev Application

How to install
--------------
* Clone the project : 

`git clone https://github.com/GwenOc/ToDoList.git`

* Install dependencies :

`composer install`

* Configure the .env by switching db_user, db_password and db_name(line n°28) : 

`DATABASE_URL=mysql: //db_user:db_password@127.0.0.1:3306/db_name`

* Create the database : 

`php bin/console doctrine:database:create`

* UpDate schema : 

`php bin/console doctrine:schema:update --force`

* Load the dataFixtures : 

`php bin/console doctrine:fixtures:load`

Here we go !
