<?php

namespace Hamidrezaniazi\Pecs\Tests\Feature;

use Carbon\Carbon;
use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Hamidrezaniazi\Pecs\Fields\AbstractEcsField;
use Hamidrezaniazi\Pecs\Fields\Base;
use Hamidrezaniazi\Pecs\Fields\Log;
use Hamidrezaniazi\Pecs\Monolog\LogRecord;
use Hamidrezaniazi\Pecs\Tests\EcsFieldFactory;
use Hamidrezaniazi\Pecs\Tests\TestCase;
use Illuminate\Support\Collection;
use stdClass;

class EcsFieldsCollectionTest extends TestCase
{
    /** @dataProvider nonEcsDataProvider */
    public function testItCanRejectNotEcsFields(mixed $nonEcsValue): void
    {
        $collection = new EcsFieldsCollection([$nonEcsValue]);

        $this->assertEmpty($collection->toArray());
    }

    public function testItCanLoadInitialFields(): void
    {
        $message = $this->faker->sentence();
        $level = $this->faker->word();
        $channel = $this->faker->word();
        $datetime = $this->faker->dateTime();

        $collection = (new EcsFieldsCollection())
            ->loadInitialFields(new LogRecord(Carbon::parse($datetime), $channel, $level, $message));

        $this->assertNotEmpty($collection->filter(fn (AbstractEcsField $field) => $field instanceof Base));
        $this->assertNotEmpty($collection->filter(fn (AbstractEcsField $field) => $field instanceof Log));
        $collection->each(function (AbstractEcsField $field) use ($message, $level, $channel, $datetime) {
            if ($field instanceof Base) {
                $this->assertEquals($message, $field->message);
                $this->assertEquals($datetime, $field->timestamp);
            }

            if ($field instanceof Log) {
                $this->assertEquals($level, $field->level);
                $this->assertEquals($channel, $field->logger);
            }
        });
    }

    public function testItCanLoadWrappers(): void
    {
        $data = ['foo' => 'bar'];
        $wrapper = EcsFieldFactory::create($this->faker->unique()->word(), $data);

        $field = new class ($this->faker->unique()->word(), $wrapper) extends AbstractEcsField {
            public function __construct(
                public readonly ?string $key,
                public readonly AbstractEcsField $wrapper,
            ) {
                parent::__construct();
            }

            protected function key(): ?string
            {
                return $this->key;
            }

            protected function body(): Collection
            {
                return new Collection();
            }

            public function wrapper(): EcsFieldsCollection
            {
                return new EcsFieldsCollection([$this->wrapper]);
            }
        };

        $collection = new EcsFieldsCollection([$field]);

        $this->assertCount(1, $collection);
        $this->assertContains($field, $collection);

        $collection->loadWrappers();

        $this->assertCount(2, $collection);
        $this->assertContains($field, $collection);
        $this->assertContains($wrapper, $collection);

    }

    /** @dataProvider formatterDataProvider */
    public function testItCanRenderFields(
        ?string $firstKey,
        array $firstBody,
        array $firstCustom,
        array $firstWrapper,
        ?string $secondKey,
        array $secondBody,
        array $secondCustom,
        array $secondWrapper,
        array $result,
    ): void {
        $collection = new EcsFieldsCollection([
            EcsFieldFactory::create($firstKey, $firstBody, $firstCustom, $firstWrapper),
            EcsFieldFactory::create($secondKey, $secondBody, $secondCustom, $secondWrapper),
        ]);
        $rendered = $collection->loadWrappers()->render()->toArray();

        $this->assertEqualsMultidimensionalCanonicalizing($result, $rendered);
    }

    public function nonEcsDataProvider(): array
    {
        return [
            [''],
            [1],
            [[]],
            [new stdClass()],
            [EcsFieldFactory::create(null, [], [], [new stdClass()], false)],
        ];
    }

    public function formatterDataProvider(): array
    {
        return [
            'base_data_initialization' => [
                null,
                [],
                [],
                [],
                null,
                [],
                [],
                [],
                [],
            ],
            'normal' => [
                'a',
                ['bam', 'foo' => 'bar'],
                ['baz' => 'qux'],
                [],
                'b',
                ['qux' => 'quz'],
                ['bleep' => 'bloop'],
                [],
                [
                    'a' => [
                        'bam',
                        'foo' => 'bar',
                        'baz' => 'qux',
                    ],
                    'b' => [
                        'qux' => 'quz',
                        'bleep' => 'bloop',
                    ],
                ],
            ],
            'null_key' => [
                null,
                ['foo' => 'bar'],
                ['baz' => 'qux'],
                [],
                'b',
                ['qux' => 'quz'],
                ['bleep' => 'bloop'],
                [],
                [
                    'foo' => 'bar',
                    'baz' => 'qux',
                    'b' => [
                        'qux' => 'quz',
                        'bleep' => 'bloop',
                    ],
                ],
            ],
            'flat_conflict' => [
                'a',
                ['foo' => 'bar'],
                ['baz' => 'qux'],
                [],
                'a',
                ['foo' => 'quz'],
                ['bleep' => 'bloop'],
                [],
                [
                    'a' => [
                        'foo' => 'quz',
                        'baz' => 'qux',
                        'bleep' => 'bloop',
                    ],
                ],
            ],
            'tree_conflict' => [
                'a',
                ['foo' => ['bam', 'bar' => 'buz']],
                ['baz' => 'qux'],
                [],
                'a',
                ['foo' => ['bar' => 'quz']],
                ['foo' => ['bleep' => 'bloop']],
                [],
                [
                    'a' => [
                        'foo' => ['bam', 'bar' => 'quz', 'bleep' => 'bloop'],
                        'baz' => 'qux',
                    ],
                ],
            ],
            'wrapper' => [
                'a',
                ['foo' => 'bar'],
                ['baz' => 'qux'],
                [],
                'b',
                [],
                [],
                [EcsFieldFactory::create('c', ['qux' => 'quz'], ['bleep' => 'bloop'])],
                [
                    'a' => [
                        'foo' => 'bar',
                        'baz' => 'qux',
                    ],
                    'c' => [
                        'qux' => 'quz',
                        'bleep' => 'bloop',
                    ],
                ],
            ],
        ];
    }
}
