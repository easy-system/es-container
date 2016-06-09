Usage
=====

The interface `Es\Container\Property\PropertyInterface` defines following 
[magic methods](http://php.net/manual/en/language.oop5.magic.php): 

- `__set()`   - sets data to the dynamic properties of the container
- `__get()`   - gets data from the dynamic properties of the container
- `__isset`   - whether the dynamic properties exists
- `__unset()` - unsets the dynamic properties of the container

The trait `Es\Container\Property\PropertyTrait` realizes this methods.

class Example:
```
use Es\Container\AbstractContainer;
use Es\Container\Property\PropertyInterface;
use Es\Container\Property\PropertyTrait;

class Example extends AbstractContainer implements PropertyInterface
{
    use PropertyTrait;
}
```

Example of use:
```
$example = new Example();

$example->foo = 2;
$example->bar = $exampe->foo + 2;
if (isset($example->baz) {
    unset($example->baz);
}
```
