Usage
=====

The trait `Es\Container\ArrayAccess\ArrayAccessTrait` realize methods of the 
[ArrayAccess](http://php.net/manual/en/class.arrayaccess.php) interface:

class Example:
```
use ArrayAccess;
use Es\Container\AbstractContainer;
use Es\Container\ArrayAccess\ArrayAccessTrait;

class Example extends AbstractContainer implements ArrayAccess
{
    use ArrayAccessTrait;
}
```

Example of use:
```
$example = new Example();

$example['foo'] = 'bar';
$example['bar']['con']['com'] = 100;
```
