# phpDatabaseOperationClass
A very handy and useful and smaller class to make your project rid of writing queries on each page. A pure PHP projects can use this to enhance their workflow


Hello there,

I have just crated a very simple PHP class for doing database operations. It is very useful for small projects and can suitable for larger projects if used wisely.

In yhis class you will get more than CRUD.
You get Insert, Insert with Where, Update, Delete, Select all, Select with where, Login with session and without session, Login will redirect to last page where user came from.

# Its a Plug-n-Play Class

Just create an object and you will able to call any function.

example:-
        <?php
          include 'path/to/file/db.php
          $object = new PratikDbClass("hostname","mysqlUser","mysqlPassword","DBname");
        ?>
        You can also change class name in db.php
        
For Insert:->>
    example:-(posts table is there with post_id(auto_increment), post_name, post_title)
              <?php 
                $data['post_name']= 'Post name gone here';
                $data['post_title']= 'Post titlr gone here';
                $con->insertion('posts',$data);
              ?>
              
    This will insert data into that table.
    If you want to add title only or name only
              <?php 
                $fields = 'post_title';
                $data['post_title']= 'Post titlr gone here';
                $con->insert_selection('posts',$fields, $data);
              ?>


