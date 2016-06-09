Usage
=====

The trait `Es\Container\Iterator\IteratorTrait` realize methods of the 
[Iterator](http://php.net/manual/en/class.iterator.php) interface. 

class Example:
```
use Es\Container\AbstractContainer;
use Es\Container\Iterator\IteratorTrait;
use Iterator;

class Example extends AbstractContainer implements Iterator
{
    use IteratorTrait;
}
```

Example of use:
```
$example = new Example();

foreach ($example as $key => $value) {
    // ...
}
```