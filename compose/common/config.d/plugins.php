<?php

return [
    'plugins' => [
        'EvaluationMethodTechnical' => ['namespace' => 'EvaluationMethodTechnical'],
        'EvaluationMethodSimple' => ['namespace' => 'EvaluationMethodSimple'],
        'EvaluationMethodDocumentary' => ['namespace' => 'EvaluationMethodDocumentary'],
        
        'MultipleLocalAuth' => [ 'namespace' => 'MultipleLocalAuth' ],
        'SamplePlugin' => ['namespace' => 'SamplePlugin'],
        'Fva' =>['namespace'=>'Fva'],
        "LocationPatch" => [
            "namespace" => "LocationPatch",
            "config" => [
                "enable" => env("LOCATION_PATCH_ENABLE", false),
                "cutoff" => env("LOCATION_PATCH_CUTOFF", "19800101000001"),
            ],
        ],
    ]
];
