<?php

namespace AssetsLoader\Services;

use AssetsLoader\Constants\ResourceLoadType;
use AssetsLoader\Models\PageTypeCondition;
use AssetsLoader\Models\PageType;

class ResourceRenderService
{
    public const PAGE_TYPE_CLASS_MAP = [
        PageType::UNDER_CONSTRUCTION => '\AssetsLoader\Models\ResourceConfig\UnderConstruction',
        PageType::PRIMARY => '\AssetsLoader\Models\ResourceConfig\Primary',
        PageType::SECONDARY => '\AssetsLoader\Models\ResourceConfig\Secondary',
        PageType::TERTIARY => '\AssetsLoader\Models\ResourceConfig\Tertiary',
        // Legacy is the fallback default
        PageType::LEGACY => '\AssetsLoader\Models\ResourceConfig\Legacy',
    ]; 
  
    protected ?string $pageType;
    protected array $resources;
    protected ?\WP_Post $post;
    protected array $config;

    public function __construct($payload = [])
    {
        $this->resources = empty($payload['resources']) ? [] : $payload['resources'];
        $this->post = empty($payload['post']) ? null : $payload['post'];
    }

    public function setup(array $payload): void
    {
        $this->setPost($payload['post']);
        
        $pageTypeData = $this->getPageTypeAndConfig($this->post);
        $this->setPageType($pageTypeData['type']);

        $resourceConfig = $this->resources[$this->pageType];
        $this->setConfig((new $resourceConfig)->get());
    }

    public function getPageType(): ?string
    {
        return $this->pageType;
    }

    public function setPageType(string $pageType): void
    {
        $this->pageType = $pageType;
    }

    public function setPost(?\WP_Post $post): void
    {
        $this->post = $post;
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function renderStyles(array $payload): void
    {
        foreach ($payload['styles'] as $handle => $resource) {
            $loadType = array_key_exists('load_type', $resource) ? $resource['load_type'] : '';

            wp_enqueue_style(
                $handle,
                $this->getURL([
                    'load_type' => $loadType,
                    'src' => $resource['src'],
                ]),
                $resource['deps'],
                @filemtime($this->getPath([
                    'load_type' => $loadType,
                    'src' => $resource['src'],
                ]))
            );
        }
    }

    public function renderScripts(array $payload): void
    {
        foreach ($payload['scripts'] as $handle => $resource) {
            $loadType = array_key_exists('load_type', $resource) ? $resource['load_type'] : '';

            wp_enqueue_script(
                $handle,
                $this->getURL([
                    'load_type' => $loadType,
                    'src' => $resource['src'],
                ]),
                $resource['deps'],
                @filemtime($this->getPath([
                    'load_type' => $loadType,
                    'src' => $resource['src'],
                ]))
            );
        }
    }

    protected function getConditionByPageType(string $pageType): PageTypeCondition
    {
        $classBaseName = str_replace('_', '', ucwords(strtolower($pageType), '_'));
        $class = "\\AssetsLoader\\Models\\PageTypeCondition\\{$classBaseName}";
    
        if (class_exists($class)) {
            return new $class();
        }
    
        return new \AssetsLoader\Models\ResourceConfig\Legacy(); // fallback
    }

    protected function getPageTypeAndConfig(?\WP_Post $post): array
    {
        $data = [
            'type' => PageType::Legacy,
            'config' => PageTypeResource::MAP[PageType::Legacy],
        ];

        foreach (PageTypeResource::MAP as $pageType => $config) {
            if (!($this->getConditionByPageType($pageType))->isPageType($post)) {
                continue;
            }

            $data = [
                'type' => $pageType,
                'config' => $config,
            ];

            break;
        }

        return $data;
    }

    protected function getURL(array $payload): string
    {
        switch ($payload['load_type']) {
            case ResourceLoadType::EXTERNAL:
                return $payload['src'];
            case ResourceLoadType::MU_PLUGINS:
                return content_url($payload['src']);
            // HINT: Theme is a default load type
            default:
                return asset($payload['src'])->uri();
        }
    }

    protected function getPath(array $payload): string
    {
        switch ($payload['load_type']) {
            case ResourceLoadType::EXTERNAL:
                return $payload['src'];
            case ResourceLoadType::MU_PLUGINS:
                return WP_CONTENT_DIR . '/' . $payload['src'];
            // HINT: Theme is a default load type
            default:
                return get_theme_file_path() . "/dist/{$payload['src']}";
        }
    }
}
