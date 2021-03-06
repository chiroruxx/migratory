<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MigrationControllerTest extends TestCase
{
    use WithFaker;

    private const ROUTE_MIGRATE = 'api_migrate';

    public function testMigration_abortWithInvalidName(): void
    {
        $cache = env('ESA_USER');

        env('ESA_USER', 'some user');

        $this->postJson(
            route(
                self::ROUTE_MIGRATE,
                [
                    'user' => ['screen_name' => 'not expected user']
                ]
            )
        )
            ->assertForbidden();

        env('ESA_USER', $cache);
    }

    public function testMigration(): void
    {
        $cache = env('ESA_USER');

        env('ESA_USER', 'user');

        $parameter = $this->createRequestData();
        $parameter['user']['screen_name'] = env('ESA_USER');

        $this->postJson(route(self::ROUTE_MIGRATE), $parameter);
        $this->assertSame(1, 1);

        env('ESA_USER', $cache);
    }

    /**
     * Create request data such as Esa Webhook request.
     *
     * @see https://docs.esa.io/posts/37
     * @param array $override
     * @return array
     */
    private function createRequestData(array $override = []): array
    {
        $default = [
            'kind' => 'post_create',
            'team' => [
                'name' => $this->faker->firstName
            ],
            'post' => [
                'name' => $this->faker->sentence(3),
                'body_md' => $this->faker->randomHtml(),
                'body_html' => $this->faker->randomHtml(),
                'wip' => true,
                'number' => $this->faker->randomDigit,
                'url' => $this->faker->url
            ],
            'user' => [
                'icon' => [
                    'url' => $this->faker->url,
                    'thumb_s' => [
                        'url' => $this->faker->url,
                    ],
                    'thumb_ms' => [
                        'url' => $this->faker->url,
                    ],
                    'thumb_m' => [
                        'url' => $this->faker->url,
                    ],
                    'thumb_l' => [
                        'url' => $this->faker->url,
                    ],
                ],
                'name' => "{$this->faker->lastName} {$this->faker->firstName}",
                'screen_name' => $this->faker->firstName,
            ],
        ];

        return array_merge($default, $override);
    }
}
