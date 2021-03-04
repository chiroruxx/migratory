<?php

namespace Tests\Unit\Entities\Esa;

use App\Entities\Esa\Post;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class PostTest
 * @package Tests\Unit\Entities\Esa
 */
class PostTest extends TestCase
{
    public function testCreateFrom(): void
    {
        $this->expectNotToPerformAssertions();
        Post::createFrom($this->createDefaultData());
    }

    /**
     * @dataProvider dataProviderForCreateFrom_throwExceptionWithInvalidType
     * @param array $data
     */
    public function testCreateFrom_throwExceptionWithInvalidType(array $data): void
    {
        $this->expectException(InvalidArgumentException::class);
        Post::createFrom($data);
    }

    public function dataProviderForCreateFrom_throwExceptionWithInvalidType(): array
    {
        return [
            'empty' => ['data' => []],
            'lost first key' => ['data' => $this->createDroppedData(['name'])],
            'lost middle key' => ['data' => $this->createDroppedData(['wip'])],
            'lost last key' => ['data' => $this->createDroppedData(['url'])],
            'lost multiple key' => ['data' => $this->createDroppedData(['body_md', 'body_html'])],
        ];
    }

    private function createDefaultData(): array
    {
        return [
            'name' => 'test',
            'body_md' => 'test',
            'body_html' => 'test',
            'wip' => true,
            'number' => 1,
            'url' => 'test',
        ];
    }

    private function createDroppedData(array $dropKeys): array
    {
        $data = $this->createDefaultData();

        foreach ($dropKeys as $key) {
            unset($data[$key]);
        }

        return $data;
    }
}
