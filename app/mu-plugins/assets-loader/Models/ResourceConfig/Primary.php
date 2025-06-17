<?php

namespace AssetsLoader\Models\ResourceConfig;

use AssestLoader\Models\Resource;

class Primary extends CommonResourceConfig
{
    public function getLocal(): array
    {
        return [
            'styles' => [
                Resource::PRIMARY['handle'] => [
                    'src' => Resource::PRIMARY['styles']['src'],
                    'deps' => [],
                ],
            ],
            'scripts' => [
                Resource::PRIMARY['handle'] => [
                    'src' => Resource::PRIMARY['script']['src'],
                    'deps' => [],
                ],
                Resource::FACEBOOK_TRACKER['handle'] => [
                    'src' => Resource::FACEBOOK_TRACKER['script']['src'],
                    'deps' => [],
                ],
                Resource::YT_PLAYER['handle'] => [
                    'src' => Resource::YT_PLAYER['script']['src'],
                    'deps' => [],
                ],
            ],
        ];
    }
}
