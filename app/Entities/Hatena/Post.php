<?php

declare(strict_types=1);

namespace App\Entities\Hatena;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use LogicException;

/**
 * Class Post
 * @package App\Entities\Hatena
 */
class Post
{
    // phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact

    public function __construct(
        private string $title,
        private string $content,
        private bool $draft,
        private Collection $categories,
        private ?string $author = null,
        private ?Carbon $updated = null,
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

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function hasUpdated(): bool
    {
        return $this->updated !== null;
    }

    public function getUpdated(): Carbon
    {
        if ($this->updated === null) {
            throw new LogicException('No updated.');
        }

        return $this->updated;
    }

    public function hasAuthor(): bool
    {
        return $this->author !== null;
    }

    public function getAuthor(): ?string
    {
        if ($this->author === null) {
            throw new LogicException('No author.');
        }

        return $this->author;
    }

    public function isDraft(): bool
    {
        return $this->draft;
    }

    /**
     * Get post as XML.
     */
    public function toXml(): string
    {
        return view('api/hatena/create', ['post' => $this])->render();
    }
}
