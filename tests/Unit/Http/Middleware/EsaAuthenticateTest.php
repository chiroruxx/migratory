<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\EsaAuthenticate;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class EsaAuthenticateTest
 * @package Tests\Unit\Http\Middleware
 */
class EsaAuthenticateTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private string $payload = 'abc';
    private string $secret = 'test';
    private string $hash = 'sha256=d796579aed123e7b743ccaf5b150affa1223e31ecba8b88c9da9ccf7ad5e0594';

    private ?EsaAuthenticate $middleware;
    private Request | MockInterface | null $request;
    private Closure $closure;

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = new EsaAuthenticate();

        $this->request = Mockery::mock(Request::class);
        $this->request->shouldReceive('getContent')->andReturn($this->payload);

        $this->closure = fn(): bool => true;
    }

    protected function tearDown(): void
    {
        $this->middleware = null;
        $this->request = null;
        parent::tearDown();
    }

    public function testHandle(): void
    {
        $this->overwriteEnv(
            'ESA_SECRET',
            $this->secret,
            function (): void {
                $this->request->shouldReceive('header')->andReturn($this->hash);

                $this->assertTrue($this->middleware->handle($this->request, $this->closure));
            }
        );
    }

    /**
     * @dataProvider dataProviderForHandle_invalid
     * @param string $secret
     * @param string $header
     */
    public function testHandle_invalid(string $secret, string $header): void
    {
        $this->fakeLogger();

        $this->overwriteEnv(
            'ESA_SECRET',
            $secret,
            function () use ($header): void {
                $this->request->shouldReceive('header')->andReturn($header);

                $this->expectException(HttpException::class);
                $this->middleware->handle($this->request, $this->closure);
            }
        );
    }

    public function dataProviderForHandle_invalid(): array
    {
        return [
            'invalid secret' => ['secret' => 'invalid', 'header' => $this->hash],
            'invalid header' => ['secret' => $this->secret, 'header' => 'invalid'],
            'invalid both' => ['secret' => 'invalid', 'header' => 'invalid'],
        ];
    }

    private function overwriteEnv(string $key, string $value, Closure $closure): void
    {
        $cache = env($key, '');

        putenv("{$key}={$value}");

        $closure();

        putenv("{$key}={$cache}");
    }

    private function fakeLogger(): void
    {
        $logger = Mockery::mock(LogManager::class);
        $logger->shouldReceive('info')->once();
        app()->bind('log', fn(): LogManager => $logger);
    }
}
