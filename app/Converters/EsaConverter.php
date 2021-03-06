<?php

declare(strict_types=1);

namespace App\Converters;

use App\Entities\Esa\Post as EsaPost;
use App\Entities\Migratory\Post;

/**
 * Class EsaConverter
 * @package App\Converters
 */
class EsaConverter
{
    /**
     * Convert esa post to migratory post.
     * @param EsaPost $esa
     * @return Post
     */
    public function convertFromEsa(EsaPost $esa): Post
    {
        $title = $esa->getLastName();
        $content = $esa->getBodyAsMarkDown();

        return new Post($title, $this->convertContent($content));
    }

    /**
     * Convert esa content to general markdown.
     *
     * @param string $content
     * @return string
     */
    private function convertContent(string $content): string
    {
        $lines = explode(PHP_EOL, $content);

        $convertedLines = [];
        foreach ($lines as $line) {
            // phpcs:ignore PSR2.Methods.FunctionCallSignature.SpaceBeforeOpenBracket
            $line = match (true) {
                /*
                 * Convert skip when matches these case.
                 * - Already indention line
                 * - Heading line
                 * - List line
                 */
                str_ends_with($line, '  '),
                    preg_match('/^# /', $line) === 1,
                    preg_match('/^ *(-|\*|\d+\.) /', $line) === 1 => $line,
                // Esa automatically changes "\n" to "  "(indention)
                // phpcs:ignore Generic.WhiteSpace.ScopeIndent.IncorrectExact
                default => "{$line}  ",
            };

            // phpcs:ignore Generic.WhiteSpace.ScopeIndent.Incorrect
            $convertedLines[] = $line;
        }

        return implode(PHP_EOL, $convertedLines);
    }
}
