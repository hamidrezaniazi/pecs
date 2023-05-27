# PECS
PHP ECS (Elastic Common Schema)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hamidrezaniazi/pecs.svg?style=flat-square)](https://packagist.org/packages/hamidrezaniazi/pecs)
[![License](https://poser.pugx.org/hamidrezaniazi/pecs/license)](https://packagist.org/packages/hamidrezaniazi/pecs)

PECS is a PHP package that facilitates the usage of [ECS (Elastic Common Schema)](https://www.elastic.co/guide/en/ecs/current/ecs-reference.html) within PHP applications. ECS is a specification that helps structure and standardize log events.

PECS offers a practical approach for integrating ECS into PHP applications. By utilizing type-hinted classes, you can enhance your data layers with ECS fields. PECS simplifies the transformation of these data layers into the standard ECS schema.

1. [Installation](#installation)
1. [Usage](#usage)
1. [Custom Fields](#custom-fields)
    1. [Wrapper](#wrapper)
    1. [Empty Values](#empty-values)
1. [Monolog Integration](#monolog-integration)
1. [Laravel Integration](#laravel-integration)
1. [Helpers](#helpers)
1. [Testing](#testing)
1. [Security](#security)
1. [License](#license)
1. [Changelog](#changelog)
1. [Contributing](#contributing)

## Installation

You can install the package via composer:

```bash
composer require hamidrezaniazi/pecs
```


## Usage

Here's an example showcasing the usage of the EcsFieldsCollection to render an array of ECS fields:

```php
use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Hamidrezaniazi\Pecs\Fields\Base;
use Hamidrezaniazi\Pecs\Fields\Log;

(new EcsFieldsCollection([
    new Base(message: 'Hello World'),
    new Log(level: 'info'),
]))->render()->toArray();
```

The above code will output:

```php
[
    'message' => 'Hello World',
    'log' => [
        'level' => 'info',
    ],
]
```

It is completely possible to have multiple fields of the same type. In case of a conflict, the most recent properties will take priority.

```php
use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Hamidrezaniazi\Pecs\Fields\Base;
use Hamidrezaniazi\Pecs\Properties\ValueList;

(new EcsFieldsCollection([
    new Base(message: 'Hello World'),
    new Base(message: 'test', tags: (new ValueList())->push('staging')),
]))->render()->toArray();
```

```php
[
    'message' => 'test',
    'tags' => [
        'staging',
    ],
]
```

You can find the available classes for defining ECS fields in the [this](./src/Fields) directory.

> It's important to note that empty values such as `null`, `[]`, etc., in the data layers are eliminated automatically. You don't need to handle them explicitly as strings like `N/A`. However, these values `0`, `0.0`, `'0'`, `'0.0'`, `false`, `'false'` are whitelisted and will appear in the logs.

## Custom Fields

You can also create your own custom fields by extending the `AbstractEcsField` class.

```php
use Hamidrezaniazi\Pecs\Fields\AbstractEcsField;

class FooField extends AbstractEcsField
{
    public function __construct(
        private string $input
    ) {
        parent::__construct();
    }

    protected function getKey(): ?string
    {
        return 'Foo';
    }

    protected function generateBody(): Collection
    {
        return collect([
            'Input' => $this->input
        ]);
    }
}
```

> Check the [ECS custom fields documentation](https://www.elastic.co/guide/en/ecs/master/ecs-custom-fields-in-ecs.html) for naming conventions and use cases.It is important to note that custom field key and property names must be in PascalCase not to conflict with the ECS fields.

### Wrapper

You may need to combine your custom fields with one the exited ECS field classes. It's feasible by overwriting the `wrapper` in your class:

```php
use Hamidrezaniazi\Pecs\Fields\AbstractEcsField;
use Hamidrezaniazi\Pecs\Fields\Event;
use Hamidrezaniazi\Pecs\Properties\EventKind;

class BarField extends AbstractEcsField
{
    protected function getKey(): ?string
    {
        return 'Bar';
    }

    protected function generateBody(): Collection
    {
        return collect([
            'Bleep' => 'bloop'
        ]);
    }
    
    public function wrapper(): EcsFieldsCollection
    {
        return parent::wrapper()->push(new Event(kind: EventKind::METRIC));
    }
```

All the fields in the wrapper will be rendered at the same level as the custom field. In the given example, the rendered array will be:

```php
[
    'Bar' => [
        'Bleep' => 'bloop',
    ],
    'event' => [
        'kind' => 'metric',
    ],
]
```

### Empty Values

It's also possible to customize the empty value behavior by overriding the whitelisted array:

```php
class FooFields extends AbstractEcsField
{
    protected array $validEmpty = [0, 0.0];
````
Now only `0` and `0.0` are whitelisted and will appear in the logs. The rest of the empty values such as `null`, `[]`, `false`, `'0'`, etc., will be eliminated.

## Monolog Integration
PECS can be used with the popular PHP logging library, [Monolog](https://github.com/Seldaek/monolog) to apply the formatter to handlers.

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Hamidrezaniazi\Pecs\Monolog\EcsFormatter;
use Hamidrezaniazi\Pecs\Fields\Event;

$log = new Logger('logger name');
$handler = new StreamHandler('ecs.logs', Logger::DEBUG);

$log->pushHandler($handler->setFormatter(new EcsFormatter()));

$log->info('message', [
    new Event(action: 'test event'),
]);
```
The `EcsFormatter` ensures that the default records generated by Monolog are correctly mapped to the corresponding ECS fields. Additionally, it takes care of rendering the remaining fields in the context array to align with the ECS schema. Here is the output of the above example:

```php
[
    '@timestamp' => '2023-05-27T00:13:16Z',
    'message' => 'message',
    'log' => [
        'level' => 'INFO',
        'logger' => 'logger name',
    ],
    'event' => [
        'action' => 'test event',
    ],
]
```

## Laravel Integration

In Laravel applications, you can apply the `EcsFormatter` to a logging driver. First, you need to create a class that implements the `__invoke` method like bellow:

```php
use Illuminate\Log\Logger;
use Monolog\Handler\FormattableHandlerInterface;
use Hamidrezaniazi\Pecs\Monolog\EcsFormatter;

class LaravelEcsFormatter
{
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            /** @var FormattableHandlerInterface $handler */
            $handler->setFormatter(app(EcsFormatter::class));
        }
    }
}
```

Then to apply this formatter to the logging driver, you need to add the `tap` key to the desired logging configuration in `config/logging.php`:

```php
'ecs' => [
    'driver' => 'single',
    'tap' => [LaravelEcsFormatter::class],
    'path' => storage_path('logs/ecs.log'),
    'level' => 'debug',
],
```

> See [Laravel's documentation](https://laravel.com/docs/10.x/logging#customizing-monolog-for-channels) for more information about this method.

Now, you can use the 'ecs' driver in your Laravel application's logging configuration to apply the ECS formatter to the logs.

```php
Log::channel('ecs')->info('sample message', [
    new Event(kind: EventKind::METRIC),
    new Http(method: request()->getMethod()),
]);
```

Since Laravel utilizes Monolog as its underlying logging system, the same behavior is applicable here regarding the automatic configuration of the `@timestamp`, `message`, `level`, and `logger` fields.

## Helpers
The syntax can get a little bit verbose when you want to log with several fields. To make it more concise, you can implement helper classes:

```php
use Hamidrezaniazi\Pecs\Fields\Error;
use Hamidrezaniazi\Pecs\Fields\Log;

class ThrowableHelper
{
    public static function from(Throwable $throwable): array
    {
        return [
            new Error(
                code: $throwable->getCode(),
                message: $throwable->getMessage(),
                stackTrace: $throwable->getTraceAsString(),
                type: get_class($throwable),
            ),
            new Log(
                originFileLine: $throwable->getLine(),
                originFileName: $throwable->getFile(),
            )
        ];
    }
}
```

Then the usage would be shortened to:

```php
try {
    // ...
} catch (Throwable $throwable) {
    Log::error('helpers example', ThrowableHelper::from($throwable));
}
```

### Testing

``` bash
composer test
```

### PHPStan

``` bash
composer phpstan
```

### PHP CS Fixer

``` bash
composer phpcs
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Hamidreza Niazi](https://github.com/hamidrezaniazi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
