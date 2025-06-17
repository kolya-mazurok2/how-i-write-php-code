<?php

namespace AssetsLoader\Models\ResourceConfig;

use AssetsLoader\Models\Resource;
use AssetsLoader\Models\ResourceConfig;

abstract class CommonResourceConfig implements ResourceConfig
{
    public function get(): array
    {
        $localConfig = $this->getLocal();

        $configMerged = [];
        foreach ($this->getGlobal() as $key => $value) {
            $configMerged[$key] = array_key_exists($key, $localConfig)
                ? array_merge($value, $localConfig[$key])
                : $value;
        }

        return $configMerged;
    }

    // HINT: Adjust whenever new resource type added, for example fonts;
    protected function getGlobal(): array
    {
        return [
            'styles' => [],
            'scripts' => [
                Resource::CORE_LIBRARIES['handle'] => [
                    'src' => Resource::CORE_LIBRARIES['script']['src'],
                    'deps' => [],
                ],
            ],
        ];
    }

    abstract protected function getLocal(): array;
}
