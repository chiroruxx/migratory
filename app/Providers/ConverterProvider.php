<?php

declare(strict_types=1);

namespace App\Providers;

use App\Converters\EsaConverter;
use App\Converters\HatenaConverter;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class ConverterProvider
 * @package App\Providers
 */
class ConverterProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        EsaConverter::class => EsaConverter::class,
        HatenaConverter::class => HatenaConverter::class,
    ];

    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [EsaConverter::class, HatenaConverter::class];
    }
}
