Usage
=====

The interface `Es\Container\Conversion\ConversionInterface` defines two methods:

- `toArray()`                     - returns a PHP array from the data container
- `fromArray(array $source = [])` - to import a PHP array to container

The trait `Es\Container\Conversion\ConversionTrait` realizes this methods.

class Example:
```
use Es\Container\AbstractContainer;
use Es\Container\Conversion\ConversionInterface;
use Es\Container\Conversion\ConversionTrait;

class Examle extends AbstractContainer implements ConversionInterface
{
    use ConversionTrait;
}
```

Example of use:
```
$data = [
    'foo' => 'bar',
    'bat' => 'baz'
];
$example = new Example();
$example->fromArray($data);
```
Now the instance contains the array data.
