<?php

namespace MyLibrary\Models;

use MyLibrary\Traits\CommonPostMethods;
use MyLibrary\Traits\CommonPostTaxonomyMethods;

abstract class Post
{
    use CommonPostMethods;
    use CommonPostTaxonomyMethods;

    /**
     * @param array $payload
     * [
     *  'post' => ?\WP_Post,
     * ]
     */
    public function __construct(array $payload)
    {
        $this->post = $payload['post'];
    }
}
