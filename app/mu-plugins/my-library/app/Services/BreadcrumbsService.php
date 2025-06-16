<?php

namespace MyLibrary\Services;

use MyLibrary\Interfaces\BreadcrumbService;

class BreadcrumbService implements CommonBreadcrumbService
{
    public const array ITEM_BASE_BLOG = [
        'title' => 'Blog',
        'url' => '/blog',
    ];
    public const array ITEM_BASE_USE_CASES = [
        'title' => 'Use Cases',
        'url' => '/use-cases',
    ];
    public const string BASE_TYPE_BLOG = 'blog';
    public const string BASE_TYPE_USE_CASES = 'use_cases';

    /**
     * @param array $payload [
     *   'base_type' => (optional) string ('blog' or 'use_cases'),
     *   'terms' => (optional) array,
     *   'items' => (optional) array,
     * ]
     * @return array [['name'=>string, 'url'=>string], ...]
     */
    public function generate(array $payload): array
    {
        $base = array_key_exists('base_type', $payload)
            ? $this->getBaseFromType($payload['base_type'])
            : [];

        $items = $payload['items'] ?? [];
        $terms = $payload['terms'] ?? [];

        if ($items) {
            return array_merge($base, $items);
        }

        if ($terms) {
            return array_merge($base, $this->mapTerms($terms));
        }

        return $base;
    }

    /**
     * Returns the base breadcrumb array for a given type.
     */
    private function getBaseFromType(string $type): array
    {
        return match ($type) {
            static::BASE_TYPE_BLOG => [static::ITEM_BASE_BLOG],
            static::BASE_TYPE_USE_CASES => [static::ITEM_BASE_USE_CASES],
            default => [],
        };
    }

    /**
     * Maps ordered WP_Term-like objects to breadcrumb items (name/url).
     */
    private function mapTerms(array $terms): array
    {
        $items = [];
        foreach ($terms as $term) {
            $items[] = [
                'title' => $term->name ?? '',
                'url' => get_term_link($term) ?? '#',
            ];
        }
        return $items;
    }
}
