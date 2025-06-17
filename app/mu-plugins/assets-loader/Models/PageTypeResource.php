<?php

namespace AssetsLoader\Models;

class PageTypeResource
{
    public const array MAP = [
        // HINT: Special pages go first, example: under construction, search
        PageType::UNDER_CONSTRUCTION => '\App\Models\ResourceConfig\UnderConstruction',
        PageType::PRIMARY => '\App\Models\ResourceConfig\Primary',
        PageType::SECONDARY => '\App\Models\ResourceConfig\Secondary',
        PageType::TERTIARY => '\App\Models\ResourceConfig\Tertiary',
        // HINT: Always the last element, it's a default value
        PageType::LEGACY => '\App\Models\ResourceConfig\Legacy',
    ];
}
