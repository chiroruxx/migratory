<?php

declare(strict_types=1);

namespace App\Entities\Esa;

use InvalidArgumentException;

/**
 * Class Post
 * @package App\Entities\Esa
 */
class Post
{
    // phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact

    /**
     * Post constructor.
     * @param string $name
     * @param string $bodyMd
     * @param string $bodyHtml
     * @param bool $wip
     * @param int $number
     * @param string $url
     */
    public function __construct(
        private string $name,
        private string $bodyMd,
        private string $bodyHtml,
        private bool $wip,
        private int $number,
        private string $url
    ) {
        // phpcs:enable
    }

    /**
     * Get last name of the name path.
     *
     * e.g. /blog/post/post_name => post_name
     *
     * @return string
     */
    public function getLastName(): string
    {
        $parsed = explode('/', $this->name);

        return end($parsed);
    }

    /**
     * @return string
     */
    public function getBodyAsMarkDown(): string
    {
        return $this->bodyMd;
    }

    /**
     * Create post from array.
     *
     * @param array $data
     * @return self
     */
    public static function createFrom(array $data): self
    {
        $keys = [
            'name',
            'body_md',
            'body_html',
            'wip',
            'number',
            'url'
        ];
        $sorted = [];

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                throw new InvalidArgumentException("Key {$key} is not set.");
            }
            $sorted[] = $data[$key];
        }

        return new self(...$sorted);
    }
}
