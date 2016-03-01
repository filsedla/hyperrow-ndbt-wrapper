# Hyperrow
Custom row and selection classes for [Nette Database](https://github.com/nette/database) (NDBT)

This library intends to have the same interface as NDBT, but wraps `Selection` and `ActiveRow` objects.
This allows you to add custom methods (or even other services) into those objects. Query to each table
results in a table-specific "Selection" and "ActiveRow" objects. This is not an ORM.


## Installation
1) Install using [Composer](http://getcomposer.org/):
```
$ composer require filsedla/hyperrow
```

2) Register an extension in your config file
```
extensions: 
    hyperrow: Filsedla\Hyperrow\Extension
```


## Basic usage

The base interface for NDBT is `Context`. Hyperrow wraps it in `Hyperrow\Database` class. For start, 
you can use it directly:
```
    - Filsedla\Hyperrow\Database(@database.context, ...)
```

Then you can make a query as usual:
```php
$userRow = $database->table('user')->where('email', $email)->fetch();
```

For this to work, it is necessary to create two classes. They can be empty:
```php
class UserSelection extends Hyperrow\HyperSelection
{
}
```
```php
class UserRow extends Hyperrow\HyperRow
{
}
```

Next, tell Hyperrow to _use_ those classes providing their FQNs: 
```
hyperrow:
    classes:
        selection:
            mapping: Model\*Selection
        row:
            mapping: Model\*Row
```

The asterix will be automatically substituted for a table name.

Note: all configuration options have default values, so the last step may not be necessary if you match
them.

Now, `$userRow` is of type `UserRow`, which allows us to write, for example:

```php
if ($userRow->isValid()) ...
```

provided that we have added a method:
```php
class UserRow extends Hyperrow\HyperRow
{
    /**
     * @return bool
     */
    public function isValid()
    {
        return !$this->deleted;
    }
}
```


## Advanced usage

In the basic example, you manually created custom selection and row classes. You could have subclassed
the `Hyperrow\Database` class and add custom methods there as well.

However, Hyperrow can also **generate** methods and classes based on your database tables and columns. 
Hyperrow then expects you to use the following hierarchy to separate generated and manually created 
methods.

* `Hyperrow\Database` - library class
  * `Project\GeneratedDatabase` - contains generated methods for accessing tables
    * `Project\Database` - created once manually, contains all other custom methods
    
* `Hyperrow\HyperRow` - library class
  * `Project\BaseRow` - created manually, a project base class for row classes from all tables
    * `Project\*GeneratedRow` - generated class with methods for accessing columns, related and 
    referenced rows
      * `Project\*Row` - generated once, a row class for specific table with manually added methods
      
The same hierarchy applies for `HyperSelection`. All 'Generated' classes are fully re-generated each
time the generator is run. You can specify their FQNs in config (wildcards will be substituted for 
the table name they correspond to).


### Setup
1) See the [default config](src/Filsedla/Hyperrow/defaults.neon) file and add 
configuration options to your project config into the Hyperrow extension section for fields whose 
default value does not fit you. The `dir` property and the whole `classes` subtree is necessary.

2) Create the two 'base' classes (make sure you match the configured FQNs from the 1st step):
```php
class BaseSelection extends Hyperrow\HyperSelection
{
}
```
```php
class BaseRow extends Hyperrow\HyperRow
{
}
```
You can later add methods shared between all table selection/row classes.

3) Set up and run the generator. See [bootstrap.php](example/app/bootstrap.php) or 
[generate.php](example/tools/generate.php) for two different methods.
For a real project it is probably better to use a separate php file to start the generator.

4) Create your own `Database` class and register it as a service in your config file.
```php
class Database extends GeneratedDatabase
{
}
```

Note: If you already have your row/selection classes from the basic example, make sure to change their 
`extends` to the 'generated' class, e.g. `class UserRow extends UserGeneratedRow`.

5) Test it by making a query using the new methods:
```php
$database->tableUser()->withEmail('example@gmail.com')->fetch()
```

Your IDE should autocomplete and the call should succeed and return an `UserRow`.

See the [example](example/) subdirectory for a complete setup with the generator.
