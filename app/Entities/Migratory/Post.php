<?php

declare(strict_types=1);

namespace App\Entities\Migratory;

/**
 * Class Post
 * @package App\Entities\Migratory
 */
class Post
{
    // phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact

    /**
     * Post constructor.
     * @param string $title
     * @param string $content
     */
    public function __construct(
        private string $title,
        private string $content
    ) {
        // phpcs:enable
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
