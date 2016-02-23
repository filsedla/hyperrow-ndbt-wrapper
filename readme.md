# Hyperrow
Custom row and selection classes for Nette Database

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

...