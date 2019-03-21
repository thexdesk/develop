<?php

return [

    'default' => env('CODEX_COMMENTS_DRIVER', 'disqus'),

    'connections' => [
        'disqus' => [
            'driver'    => 'disqus',
            'shortcode' => env('CODEX_COMMENTS_DISQUS_SHORTCODE', 'codex-project'),
        ],
    ],
];
