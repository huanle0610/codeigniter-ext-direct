# codeigniter-ext-direct
## View
To use this direct adapter you have to understand Ext Direct (see Ext Direct examples).

In the head of your html page add:

<script type="text/javascript" src="<?php echo site_url('direct/api'); ?>"></script>

## Controller classes
Ext controller classes are placed in the new application/ext/direct/ folder.
Because it's not a CI controller nor a CI library.
If you want to use CI object, use (like you are use to within libraries):
```php
$CI =& get_instance();
```
NOTE
* The functions in the classes should have al least the comment **@remotable** to work.

```php
class Time {
    /**
     * @remotable
     */
    public function get(){
        return date('m-d-Y H:i:s');
    }
}
```
NOTE
* The functions must be public to be used for Ext Direct.
* When using a form submit, the comment should also contain **FormHandler** to read the _POST variables.

```php
/**
 * @remotable
 * @formHandler
 */
The Ext controller classes should be made available in the CI direct controller.
$api->add(
    array(
        'MyClass1',
        'MyClass2',
        ...
    )
);
```
You can add Class prefix if you want.

```php
$api->add(
    array(
        'MyClass1' => array('prefix' => 'Class_'),
        'MyClass2' => array('prefix' => 'Class_'),
        ...
    )
);
```
NOTE
* The names must be exactly as the are used within your Ext javascript.
* The prefix used as param is only for the classname, not the filename.
