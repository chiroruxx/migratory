<?php

declare(strict_types=1);

namespace App\Entities\Hatena;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class Post
 * @package App\Entities\Hatena
 */
class Post
{
    public function __construct(
        private string $title,
        private string $content,
        private bool $draft,
        private Collection $categories,
        private ?string $author = null,
        private ?Carbon $updated = null,
    )
    {
    }
}
