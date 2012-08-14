kohana-orm-polymorphic
======================

Polymorphic Associations for Kohana 3 ORM.  Code converted from Blake Lucchesi and upgraded to work with Kohana 3 (http://forum.kohanaframework.org/discussion/2495/orm-polymorphic-associations/p1)

Assume we have an application that:
* Allows for users to post links to websites.  
* Allows users to have profiles
* Allows users to comment on posted links
* Allows users to comment on other users profiles

If we wanted to keep all the comments for both posts and profiles in the same table we could create the following table:
```sql
CREATE TABLE `comments` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(5) unsigned NOT NULL,
  `object_type` varchar(28) NOT NULL,
  `user_id` int(5) DEFAULT NOT NULL,
  `body` varchar(512) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```


Models:
```php
class Post_Model extends ORM 
{
  protected $has_many_polymorphic = array('comments' => 'object');
}
```

```php
class Profile_Model extends ORM 
{
  protected $has_many_polymorphic = array('comments' => 'object');
}
```

Usage:
```php
$post = ORM::factory('post', $id);
foreach ($post->comments as $comment) 
{
  print $comment->body;
}
```
