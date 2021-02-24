<?php

return [
    'role_structure' => [
        'owner' => [
            'users'                 => 'c,r,u,d',
            'check'                 => 'c,r,u,d',
            'jobTitle'              => 'c,r,u,d',
            'clients'               => 'c,r,u,d',
            'checkStatus'           => 'c,r,u,d',
            'branches'              => 'c,r,u,d',
            'technicals'            => 'c,r,u,d',
            'engineers'             => 'c,r,u,d',
            'cars'                  => 'c,r,u,d',
            'carType'               => 'c,r,u,d',
            'carSize'               => 'c,r,u,d',
            'carModel'              => 'c,r,u,d',
            'carEngine'             => 'c,r,u,d',
            'carDevelopmentCode'    => 'c,r,u,d',
            'managementNotes'       => 'c,r,u,d',
        ],
        'general_manager' => [

            'users'                 => 'c,r,u',
            'check'                 => 'c,r,u',
            'jobTitle'              => 'c,r,u',
            'clients'               => 'c,r,u',
            'checkStatus'           => 'c,r,u',
            'branches'              => 'c,r,u',
            'technicals'            => 'c,r,u',
            'engineers'             => 'c,r,u',
            'cars'                  => 'c,r,u',
            'carType'               => 'c,r,u',
            'carSize'               => 'c,r,u',
            'carModel'              => 'c,r,u',
            'carEngine'             => 'c,r,u',
            'carDevelopmentCode'    => 'c,r,u',
            'managementNotes'       => 'c,r,u',
        ],
        'branch_manager' => [
            'check'                 => 'c,r,u',
            'clients'               => 'c,r',
            'cars'                  => 'c,r',
            'carType'               => 'c,r',
            'carSize'               => 'c,r',
            'carModel'              => 'c,r',
            'carEngine'             => 'c,r',
            'carDevelopmentCode'    => 'c,r',
            'checkStatus'           => 'u',
        ],
        'accountant' => [
            'check'                 => 'c,r',
            'clients'               => 'c,r',
            'cars'                  => 'c,r',
            'checkStatus'           => 'u'
        ]
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
