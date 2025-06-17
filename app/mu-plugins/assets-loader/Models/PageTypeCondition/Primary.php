<?php

namespace AssetsLoader\Models\PageTypeCondition;

use AssetsLoader\Models\PageTemplate;
use AssetsLoader\Models\PageTypeCondition;
use MyLibrary\Models\PostTypes\BlogCpt;
use MyLibrary\Models\Taxonomies\TypeTaxonomy;

class Primary implements PageTypeCondition
{
    public function isPageType(?\WP_Post $post): bool
    {
        if (is_search() || is_404()) {
            return true;
        }

        if (empty($post)) {
            return false;
        }

        return is_page_template([
                PageTemplate::PRIMARY,
            ])
            || is_author()
            || is_tax([
                TypeTaxonomy::TYPE,
            ])
            || is_singular([
                BlogCpt::TYPE,
            ]);
    }
}
