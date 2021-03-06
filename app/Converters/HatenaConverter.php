<?php

declare(strict_types=1);

namespace App\Converters;

use App\Entities\Hatena\Post as HatenaPost;
use App\Entities\Migratory\Post;

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

        return new HatenaPost($title, $content, true, collect());
    }
}
