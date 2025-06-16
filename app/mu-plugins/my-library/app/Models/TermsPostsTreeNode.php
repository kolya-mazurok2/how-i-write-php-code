<?php

namespace MyLibrary\Models;

class TermsPostsTreeNode
{
    public const string TYPE_TERM = 'term';
    public const string TYPE_POST = 'post';
    public const string TYPE_WP_POST = 'wp_post';

    public int $id;
    public string $type;
    public object $data;
    /** @var TermsPostsTreeNode[] */
    public array $children = [];

    public function __construct(int $id, string $type, object $data)
    {
        $this->id = $id;
        $this->type = $type;
        $this->data = $data;
        $this->children = [];
    }
}
