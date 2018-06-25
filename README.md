# TNA's Resource Rating Plugin

This is a plugin to enable users to rate TNA's resources on the website.


Using the tna theme
------

Insert the following within both a "col starts-at-full ends-at-one-third clr box" and a "col starts-at-full ends-at-two-thirds box clr":

```php
<?php if (function_exists("display_resource_ratings")) {
    display_resource_ratings();
}  ?>
```