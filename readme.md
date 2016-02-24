# Hyperrow
Custom row and selection classes for [Nette Database](https://github.com/nette/database) (NDBT)

This library intends to have the same interface as NDBT, but wraps `Selection` and `ActiveRow` objects. This allows
you to add custom methods (or even other services) into those objects. Query to each table results in a table-specific 
"Selection" and "ActiveRow" objects. This is not an ORM.


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

3) (Optionally) provide configuration parameters for the extension. None of them is mandatory, they have the following default values:

```
hyperrow:
    dir: %appDir%/model/database/generated
    namespace: Model\Database
    classes:
        row:
            base: BaseHyperRow
            table: *HyperRow
        selection:
            base: BaseHyperSelection
            table: *HyperSelection
```

## Basic usage

The base interface for NDBT is `Context`. Hyperrow wraps it in `Hyperrow\Database` class. For start, 
you can use it directly:
```
    - Filsedla\Hyperrow\Database(@database.context, ...)
```

Then you can make a query as usual:
```
$userRow = $this->database->table('user')->where('email', $email)->fetch();
```

For this to work, it is necessary to create two more classes. They can be empty:

```
class UserHyperSelection extends Hyperrow\HyperSelection
{
}
```

```
class UserHyperRow extends Hyperrow\HyperRow
{
}
```

Now, `$userRow` is of type `UserHyperRow`, which allows us to write, for example:

```
if ($row->isValid()) ...
```

provided that we have added a method:

```
class UserHyperRow extends Hyperrow\HyperRow
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

Note that the following **is possible**:
 * an IDE can auto-complete both the `deleted` property and the new method `isValid()` (without a type hind at 
 the `fetch()` line)
 * The table-specific classes do not have to be created manually, they can be generated

For it to work, proper PHP-doc comments must be present and the class hierarchy must be more complicated.
See the `/example` subdirectory for a complete setup with the class generator.