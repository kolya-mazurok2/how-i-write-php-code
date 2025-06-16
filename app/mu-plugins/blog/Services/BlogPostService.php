<?php

namespace Blog\Services;

use Blog\Models\BlogPost;
use Blog\Repositories\BlogPostQueryRepository;
use MyLibrary\Interfaces\CommonPostService;
use MyLibrary\Traits\Modelable;

class BlogPostService implements CommonPostService
{
    use Modelable;

    public const RESPONSE_FIND_ALL_DEFAULT = [
        'posts' => [],
        'posts_per_page' => 8,
        'max_num_pages' => 0,
    ];

    protected ?CommonPostRepository $repository;

    public function __construct(?CommonPostRepository $repository = null)
    {
        $this->modelName = '\Blog\Models\BlogPost';
        $this->repository = empty($repository) ? new BlogPostQueryRepository() : $repository;
    }

    public function findAll(array $payload): array
    {
        $postsData = $this->repository->findAll($payload);
        if (empty($postsData['posts'])) {
            return static::RESPONSE_FIND_ALL_DEFAULT;
        }

        $postsPayload = array_map(fn($post) => ['post' => $post], $postsData['posts']);

        return [
            'posts' => $this->createObjects($postsPayload),
            'posts_per_page' => $postsData['posts_per_page'],
            'max_num_pages' => $postsData['max_num_pages'],
        ];
    }

    public function findById(int $id): ?BlogPost
    {
        $postRaw = $this->repository->findById($id);
        if (empty($postRaw)) {
            return null;
        }

        return $this->createObject(['post' => $postRaw]);
    }

    public function find(array $payload): mixed
    {
        return null;
    }
}
