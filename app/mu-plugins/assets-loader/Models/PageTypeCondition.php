<?php

namespace AssetsLoader\Models;

interface PageTypeCondition
{
    public function isPageType(?\WP_Post $post): bool;
}
