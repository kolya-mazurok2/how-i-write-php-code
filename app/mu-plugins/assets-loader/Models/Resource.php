<?php

namespace AssetsLoader\Models;

class Resource
{
    public const array CORE_LIBRARIES = [
        'handle' => 'core-libraries',
        'styles' => [
            'src' => 'styles/core-libraries.css',
            'async' => true,
        ],
        'script' => [
            'src' => 'scripts/core-libraries.js',
        ],
    ];

    public const array PRIMARY = [
        'handle' => 'primary',
        'styles' => [
            'src' => 'styles/primary.css'
        ],
        'script' => [
            'src' => 'scripts/primary.js',
            'async' => true,
            'defer' => true,
        ],
    ];

    public const array SECONDARY = [
        'handle' => 'secondary',
        'styles' => [
            'src' => 'styles/secondary.css'
        ],
        'script' => [
            'src' => 'scripts/secondary.js',
            'async' => true,
            'defer' => true,
        ],
    ];

    public const array TERTIARY = [
        'handle' => 'tertiary',
        'styles' => [
            'src' => 'styles/tertiary.css'
        ],
        'script' => [
            'src' => 'scripts/tertiary.js',
            'async' => true,
            'defer' => true,
        ],
    ];

    public const array FACEBOOK_TRACKER = [
        'handle' => 'facebook-tracker',
        'styles' => [],
        'script' => [
            'src' => 'scripts/fb-tracker.js',
            'async' => true,
        ],
    ];

    public const array YT_PLAYER = [
        'handle' => 'yt-player',
        'styles' => [],
        'script' => [
            'src' => 'scripts/yt-player.js',
            'async' => true,
        ],
    ];

    public static function getAll(): array
    {
        return [
            static::CORE_LIBRARIES,
            static::PRIMARY,
            static::SECONDARY,
            static::TERTIARY,
            static::FACEBOOK_TRACKER,
            static::YT_PLAYER,
        ];
    }
}
