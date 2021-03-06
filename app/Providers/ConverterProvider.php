<?php

namespace App\Providers;

use App\Converters\EsaConverter;
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
    ];

    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [EsaConverter::class];
    }
}
