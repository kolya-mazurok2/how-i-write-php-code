<?php

namespace Blog\Managers;

use MyLibrary\Models\Taxonomies\BlogCategoryTaxonomy;
use MyLibrary\Models\PostTypes\BlogCpt;

final class CptManager
{
    public function initialize()
    {
        add_action('init', [$this, 'initHandler']);
    }

    public function initHandler(): void
    {
        register_post_type(BlogCpt::TYPE, BlogCpt::ARGS);
        register_taxonomy(BlogCategoryTaxonomy::TYPE, BlogCpt::TYPE, BlogCategoryTaxonomy::ARGS);
    }
}
