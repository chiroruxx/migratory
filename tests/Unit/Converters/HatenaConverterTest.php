<?php

declare(strict_types=1);

namespace Tests\Unit\Converters;

use App\Converters\HatenaConverter;
use App\Entities\Migratory\Post;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * Class HatenaConverterTest
 * @package Tests\Unit\Converters
 */
class HatenaConverterTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @dataProvider dataProviderForConvertToHatena
     * @param string $input
     * @param string $expected
     */
    public function testConvertToHatena(string $input, string $expected): void
    {
        $post = Mockery::mock(Post::class);
        $post->shouldReceive('getTitle')->andReturn('');
        $post->shouldReceive('getContent')->andReturn($input);

        $converter = new HatenaConverter();
        $hatena = $converter->convertToHatena($post);

        $this->assertSame($expected, $hatena->getContent());
    }

    public function dataProviderForConvertToHatena(): array
    {
        return [
            'no changes' => ['input' => 'test body', 'expected' => 'test body'],
            'h1' => ['input' => '# heading', 'expected' => '### heading'],
            'h2' => ['input' => '## heading', 'expected' => '#### heading'],
            'start with #' => ['input' => '#not heading', 'expected' => '#not heading'],
        ];
    }
}
