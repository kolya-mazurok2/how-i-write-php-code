<?php

namespace Blog\Managers;

use Blog\Controllers\Ajax\BlogPostAjaxController;

class AjaxManager
{
    public const ACTION_BLOG_POST_FILTER = 'blog_post_filter';
    public const STATUS_CODE_SUCCESS = 200;

    public function initialize(): void
    {
        add_action('wp_ajax_' . static::ACTION_BLOG_POST_FILTER, [$this, 'wpAjaxBlogPostFilterHandler']);
        add_action('wp_ajax_nopriv_' . static::ACTION_BLOG_POST_FILTER, [$this, 'wpAjaxBlogPostFilterHandler']);
    }

    public function wpAjaxBlogPostFilterHandler(): void
    {
        $response = [];
      
        try {
            $response = (new BlogPostAjaxController())->index();
        } catch (\Throwable $throwable) {
            $response['error_message'] = $throwable->getMessage();
            $statusCode = $throwable->getCode();
        } finally {
            wp_send_json($response, static::STATUS_CODE_SUCCESS);
        }
    }
}
