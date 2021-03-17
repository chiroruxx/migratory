<?php

declare(strict_types=1);

namespace Tests\Unit\Converters;

use App\Converters\EsaConverter;
use App\Entities\Esa\Post;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * Class EsaConverterTest
 * @package Tests\Unit\Converters
 */
class EsaConverterTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @dataProvider dataProviderForConvertFromEsa_convertContent_indention
     * @param string $input
     * @param string $expected
     */
    public function testConvertFromEsa_convertContent_indention(string $input, string $expected): void
    {
        $esaPost = Mockery::mock(Post::class);
        $esaPost->shouldReceive('getLastName')->andReturn('');
        $esaPost->shouldReceive('getBodyAsMarkDown')->andReturn($input);

        $converter = new EsaConverter();
        $post = $converter->convertFromEsa($esaPost);

        $this->assertSame($expected, $post->getContent());
    }

    public function dataProviderForConvertFromEsa_convertContent_indention(): array
    {
        return [
            'should indent' => ['input' => 'test body', 'expected' => 'test body  '],
            'already indention' => ['input' => 'test body  ', 'expected' => 'test body  '],
            'heading' => ['input' => '# test body', 'expected' => '# test body'],
            'list -' => ['input' => '- test body', 'expected' => '- test body'],
            'list *' => ['input' => '* test body', 'expected' => '* test body'],
            'ordered list' => ['input' => '1. test body', 'expected' => '1. test body'],
            'ordered list 2 digit' => ['input' => '10. test body', 'expected' => '10. test body'],
            'nested list' => ['input' => '  - test body', 'expected' => '  - test body'],
            'empty line' => ['input' => '', 'expected' => ''],
        ];
    }

    public function testConvertFromEsa_convertTitle(): void
    {
        $title = 'test title';

        $esaPost = Mockery::mock(Post::class);
        $esaPost->shouldReceive('getLastName')->andReturn($title);
        $esaPost->shouldReceive('getBodyAsMarkDown')->andReturn('');

        $converter = new EsaConverter();
        $post = $converter->convertFromEsa($esaPost);

        $this->assertSame($title, $post->getTitle());
    }
}
