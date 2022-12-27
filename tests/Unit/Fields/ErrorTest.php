<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Exception;
use Hamidrezaniazi\Pecs\Fields\Error;
use Hamidrezaniazi\Pecs\Fields\Log;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use PHPUnit\Framework\TestCase;

class ErrorTest extends TestCase
{
    use ReflectionHelpers;

    public function testItShouldHaveItsKey(): void
    {
        $error = new Error();

        $this->assertEquals('error', $this->privateCall($error, 'key'));
        $this->assertEmpty($error->toArray());
    }

    public function testItShouldGenerateItsBody(): void
    {
        $code = '100';
        $id = 'error-id-key';
        $message = 'this is just a message';
        $stackTrace = '#0 /example/dir/class.php(1): test()';
        $type = 'error-type';

        $error = new Error(
            code: $code,
            id: $id,
            message: $message,
            stackTrace: $stackTrace,
            type: $type,
        );

        $this->assertEquals(
            [
                'error' => [
                    'code' => $code,
                    'id' => $id,
                    'message' => $message,
                    'stack_trace' => $stackTrace,
                    'type' => $type,
                ],
            ],
            $error->toArray()
        );

        $this->assertEmpty($error->wrapper());
    }

    public function testItCanGenerateItsBodyFromThrowable(): void
    {
        $message = 'this is just a message';
        $code = 100;
        $exception = new Exception($message, $code);
        $error = Error::fromThrowable($exception);

        $this->assertEquals(
            [
                'error' => [
                    'type' => get_class($exception),
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'stack_trace' => $exception->getTraceAsString(),
                ],
            ],
            $error->toArray(),
        );

        $this->assertCount(1, $error->wrapper());
        $log = $error->wrapper()->first();
        $this->assertInstanceOf(Log::class, $log);
        $this->assertEquals($exception->getLine(), $log->originFileLine);
        $this->assertEquals($exception->getFile(), $log->originFileName);
    }
}
