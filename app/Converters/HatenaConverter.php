<?php

declare(strict_types=1);

namespace App\Converters;

use App\Entities\Hatena\Post as HatenaPost;
use App\Entities\Migratory\Post;
use RuntimeException;

/**
 * Class HatenaConverter
 * @package App\Converters
 */
class HatenaConverter
{
    /**
     * Convert migratory post to Hatena post.
     *
     * Support only draft and no categories.
     *
     * @param Post $post
     * @return HatenaPost
     */
    public function convertToHatena(Post $post): HatenaPost
    {
        $title = $post->getTitle();
        $content = $post->getContent();

        return new HatenaPost($title, $this->convertContent($content), true, collect());
    }

    /**
     * Convert general markdown to hatena markdown.
     *
     * @param string $content
     * @return string
     */
    private function convertContent(string $content): string
    {
        $content = str_replace(["\r\n", "\r", "\n"], PHP_EOL, $content);

        $lines = explode(PHP_EOL, $content);

        $convertedLines = [];
        foreach ($lines as $line) {
            $line = preg_replace('/^(#+) /', '##$1 ', $line);
            if ($line === null) {
                throw new RuntimeException("Cannot replace the line '{$line}'");
            }

            $convertedLines[] = $line;
        }

        return implode(PHP_EOL, $convertedLines);
    }
}
