<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Hamidrezaniazi\Pecs\Fields\Base;
use Hamidrezaniazi\Pecs\Properties\PairList;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    use ReflectionHelpers;

    public function testItShouldHaveItsKey(): void
    {
        $base = new Base();

        $this->assertNull($this->privateCall($base, 'key'));
        $this->assertEmpty($base->toArray());
    }

    public function testItShouldGenerateItsBody(): void
    {
        Carbon::setTestNow('02-02-2022 22:22:22 UTC');
        $datetime = Carbon::now();
        $labels = $this->createMock(PairList::class);
        $message = 'this is just a message';
        $tags = $this->createMock(ValueList::class);

        $labelsList = ['foo' => 'bar'];
        $labels->expects($this->once())->method('toArray')->willReturn($labelsList);

        $tagsList = ['buz'];
        $tags->expects($this->once())->method('toArray')->willReturn($tagsList);

        $this->assertEquals(
            [
                '@timestamp' => '2022-02-02T22:22:22Z',
                'labels' => $labelsList,
                'message' => $message,
                'tags' => $tagsList,
            ],
            (new Base(
                timestamp: $datetime,
                labels: $labels,
                message: $message,
                tags: $tags,
            ))->toArray(),
        );
    }
}
