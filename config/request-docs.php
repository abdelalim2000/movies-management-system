<?php

return [
    'document_name' => 'Movies Management System',

    /*
    * Route where request docs will be served from
    * localhost:8080/request-docs
    */
    'url' => 'api/v1/documentation',
    'middlewares' => [
        //Example
        // \App\Http\Middleware\NotFoundWhenProduction::class,
    ],
    /**
     * Path to to static HTML if using command line.
     */
    'docs_path' => base_path('docs/request-docs/'),

    /**
     * Sorting route by and there is two types default(route methods), route_names.
     */
    'sort_by' => 'route_names',

    'hide_matching' => [
        "#^telescope#",
        "#^docs#",
        "#^api/v1/documentation#",
    ]
];
