<?php

namespace Blog\Controllers\Ajax;

use MyLibrary\Controllers\Ajax\CommomAjaxController;
use MyLibrary\Interfaces\CommonPostService;
use Blog\Controllers\BlogPostController;
use Blog\Services\BlogPostService;

class BlogPostAjaxController extends CommomAjaxController
{
    public const POSTS_PER_PAGE_MOBILE = 6;
    public const POSTS_PER_PAGE_DESKTOP = 9;
    
    protected ?CommonPostService $blogPostService;

    public function __construct(?CommonPostService $blogPostService = null)
    {
        parent::__construct();
      
        $this->blogPostService = empty($blogPostService) ? new BlogPostService() : $blogPostService;
    }

    public function index(): array
    {
        $postsPerPage = \MyLibrary\Helpers\UserAgentHelper::isMobile()
                ? static::POSTS_PER_PAGE_MOBILE
                : static::POSTS_PER_PAGE_DESKTOP;
        $findAllPayload = array_merge($this->preparePayload($this->request), [
            'posts_per_page' => $postsPerPage,
        ]);
        $blogPostsData = $this->blogPostService->findAll($findAllPayload);

        return [
            'markup' => \MyLibrary\Helpers\CommonHelper::view('mu-plugins.blog.archive.grid', [
                'blog_posts' => $blogPostsData['posts'],
            ]),
            'max_num_pages' => $blogPostsData['max_num_pages'],
        ];
    }

    private function preparePayload(array $payload): array
    {
        $payloadPrepared = [];

        if (array_key_exists('blog_categories', $payload)) {
            $payloadPrepared['taxonomies']['blog_category'] = empty($payload['blog_categories']) ? 0 : (int)$payload['blog_categories'];
        }

        if (array_key_exists('page', $payload)) {
            $payloadPrepared['page'] = empty($payload['page']) ? 1 : (int)$payload['page'];
        }

        return $payloadPrepared;
    }
}
