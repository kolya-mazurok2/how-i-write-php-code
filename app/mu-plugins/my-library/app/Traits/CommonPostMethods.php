<?php

namespace MyLibrary\Traits;

use MyLibrary\Helpers\ThumbnailHelper;
use MyLibrary\Models\PostTypes\BlogCpt;
use MyLibrary\Models\Taxonomies\TypeTaxonomy;

trait CommonPostMethods
{
    protected ?\WP_Post $post;
    protected array $thumbnail = [];

    public function getId(): int
    {
        return $this->post->ID;
    }

    public function getTitle(): string
    {
        return $this->post->post_title;
    }

    public function getContent(): string
    {
        return $this->post->post_content;
    }

    public function getExcerpt(): string
    {
        return $this->post->post_excerpt;
    }

    public function getPublishedAt(string $format = 'M d, Y'): string
    {
        $date = get_the_date($format, $this->post);
      
        return empty($date) ? '' : $date;
    }

    public function getPermalink(): string
    {
        $permalink = get_permalink($this->post);
      
        return empty($permalink) ? '' : $permalink;
    }

    public function getThumbnail($size = 'full'): array
    {
        if (!empty($this->thumbnail)) {
            return $this->thumbnail;
        }

        $this->thumbnail = ThumbnailHelper::getThumbnail($this->post->ID, $size);

        return $this->thumbnail;
    }

    public function getType(): string
    {
        if (!empty($this->type)) {
            return $this->type;
        }

        if ($this->post->post_type === BlogCpt::TYPE || $this->post->post_type === PostCpt::TYPE) {
            $this->type = $this->post->post_type;
          
            return $this->type;
        }

        $terms = wp_get_post_terms($this->post->ID, TypeTaxonomy::TYPE);
        $this->type = empty($terms) || is_wp_error($terms)
            ? 'unknown'
            : $terms[0]->slug;

        return $this->type;
    }

    public function setTitle(string $title): void
    {
        $this->post->post_title = $title;
    }

    public function setContent(string $content): void
    {
        $this->post->post_content = $content;
    }

    public function setExcerpt(string $excerpt): void
    {
        $this->post->post_excerpt = $excerpt;
    }

    public function setThumbnail(array $thumbnail): void
    {
        $this->thumbnail = [
            'src' => $thumbnail['url'],
            'alt' => $thumbnail['alt'],
            'width' => $thumbnail['width'],
            'height' => $thumbnail['height'],
        ];
    }
}
