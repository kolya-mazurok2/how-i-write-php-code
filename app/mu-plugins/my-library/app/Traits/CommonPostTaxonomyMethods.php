<?php

namespace MyLibrary\Traits;

use MyLibrary\Models\PostTypes\PostCpt;
use MyLibrary\Models\Taxonomies\CategoryTaxonomy;
use MyLibrary\Models\PostTypes\UseCaseCpt;
use MyLibrary\Models\Taxonomies\TypeTaxonomy;

trait CommonPostTaxonomyMethods
{
    public const POST_TYPE_TAXONOMY_MAP = [
        PostCpt::TYPE => CategoryTaxonomy::TYPE,
        UseCaseCpt::TYPE => ResourceTypeTaxonomy::TYPE,
    ];

    protected ?\WP_Post $post;
    protected array $post_primary_taxonomy_terms = [];

    public function getPostPrimaryTaxonomyTerms(array $payload): array
    {
        if (!empty($this->post_primary_taxonomy_terms)) {
            return $this->post_primary_taxonomy_terms;
        }

        $taxonomy = array_key_exists($payload['type'], static::POST_TYPE_TAXONOMY_MAP)
            ? static::POST_TYPE_TAXONOMY_MAP[$payload['type']]
            : static::POST_TYPE_TAXONOMY_MAP[CategoryTaxonomy::TYPE];
        $terms = wp_get_post_terms($this->post->ID, $taxonomy);
      
        $this->post_primary_taxonomy_terms = empty($terms) || is_wp_error($terms) ? [] : $terms;

        return $this->post_primary_taxonomy_terms;
    }
}
