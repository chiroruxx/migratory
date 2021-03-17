<?php

declare(strict_types=1);

namespace Tests\Unit\Converters;

use App\Converters\EsaConverter;
use App\Entities\Esa\Post;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * Class EsaConverterTest
 * @package Tests\Unit\Converters
 */
class EsaConverterTest extends TestCase
{
    /**
     * @dataProvider dataProviderForConvertFromEsa_convertContent_indention
     * @param string $input
     * @param string $expected
     * @throws ReflectionException
     */
    public function testConvertFromEsa_convertContent_indention(string $input, string $expected): void
    {
        $esaPost = new Post(
            '',
            $input,
            '',
            true,
            1,
            ''
        );

        $converter = new EsaConverter();
        $post = $converter->convertFromEsa($esaPost);

        $reflection = new ReflectionClass($post);
        $property = $reflection->getProperty('content');
        $property->setAccessible(true);

        $this->assertSame($expected, $property->getValue($post));
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

    /**
     * @throws ReflectionException
     */
    public function testConvertFromEsa_convertTitle(): void
    {
        $title = 'test title';

        $esaPost = new Post(
            $title,
            '',
            '',
            true,
            1,
            ''
        );

        $converter = new EsaConverter();
        $post = $converter->convertFromEsa($esaPost);

        $reflection = new ReflectionClass($post);
        $property = $reflection->getProperty('title');
        $property->setAccessible(true);

        $this->assertSame($title, $property->getValue($post));
    }
}
