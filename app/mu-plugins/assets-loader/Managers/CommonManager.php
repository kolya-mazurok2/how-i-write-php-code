<?php

namespace AssetsLoader\Managers;

use AssetsLoader\Models\PageTypeResource;
use AssetsLoader\Models\Resource;
use AssetsLoader\Services\ResourceRenderService;

class CommonManager
{
    protected ResourceRenderService $resourceRenderService;

    public function __construct(?ResourceRenderService $resourceRenderService = null)
    {
        $this->resourceRenderService = empty($resourceRenderService)
            ? new ResourceRenderService(['resources' => PageTypeResource::MAP])
            : null;
    }

    public function initialize(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'wpEnqueueScriptsHandler'], 100);
        add_filter('script_loader_tag', [$this, 'scriptLoaderTagHandler'], 10, 2);
    }

    public function wpEnqueueScriptsHandler(): void
    {
        global $post;

        $this->resourceRenderService->setup([
            'post' => $post,
        ]);
      
        $config = $this->resourceRenderService->getConfig();
        $this->resourceRenderService->renderStyles([
            'styles' => $config['styles'],
        ]);
        $this->resourceRenderService->renderScripts([
            'scripts' => $config['scripts'],
        ]);
    }

    public function scriptLoaderTagHandler(string $tag, string $handle): string
    {
        $resources = Resource::getAll();
        $resourcesFiltered = array_filter($resources, fn($resource) => !empty($resource['script']));

        $resourcesMapped = [];
        foreach ($resourcesFiltered as $resourceFiltered) {
            $resourcesMapped[$resourceFiltered['handle']] = [
                'async' => array_key_exists('async', $resourceFiltered['script']) ? $resourceFiltered['script']['async'] : null,
                'defer' => array_key_exists('defer', $resourceFiltered['script']) ? $resourceFiltered['script']['defer'] : null,
            ];
        }

        if (!in_array($handle, array_keys($resourcesMapped))) {
            return $tag;
        }

        $attributes = $resourcesMapped[$handle];

        if (!empty($attributes['async'])) {
            $tag = $this->addAsync($tag);
        }

        if (!empty($attributes['defer'])) {
            $tag = $this->addDefer($tag);
        }

        return $tag;
    }

    private function addDefer(string $tag): string
    {
        return str_replace(' src', ' defer="defer" src', $tag);
    }

    private function addAsync(string $tag): string
    {
        return str_replace(' src', ' async="async" src', $tag);
    }
}
