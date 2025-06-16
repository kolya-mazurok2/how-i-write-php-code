<?php

namespace MyLibrary\Controllers;

abstract class CommonPostController
{
    protected ?\WP_Query $wpQuery;
    protected array $request = [];

    public function __construct()
    {
        global $wp_query;
      
        $this->wpQuery = &$wp_query;
        $this->setDefaultRequest();
    }

    public function getWpQuery(): ?\WP_Query
    {
        return $this->wpQuery;
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    protected function setDefaultRequest(): void
    {
        $paged = get_query_var('paged', 1);
      
        $this->request['current_page'] = max($paged, 1);
    }
}
