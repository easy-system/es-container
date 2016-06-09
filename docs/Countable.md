Usage
=====

The trait `Es\Container\Countable\CountableTrait` realize `count()` method
of the [Countable](http://php.net/manual/en/class.countable.php) interface.

class Example:
```
use Countable;
use Es\Container\AbstractContainer;
use Es\Container\Countable\CountableTrait;

class Examle extends AbstractContainer implements Countable
{
    use CountableTrait;
}
```

Example of use:
```
$example = new Example();
$count   = count($example);
```
