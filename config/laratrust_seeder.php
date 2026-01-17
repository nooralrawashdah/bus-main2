<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' =>
     [
        'admin' => [
            'users' => 'c,r,u,d',
            'bus' => 'c,r,u,d',
            'trip' => 'c,r,u,d',
            'route' => 'c,r,u,d',
            'seat' => 'c,r,u,d',
            

        ],
        'driver' => [
            'seat' => 'r',
            'trip' => 'r,u',
            'route'=>'r'
        ],

        'student' => [
            'booking' => 'c,r,d',
             'trip' => 'r',
             'bus'=>'r',
             'route'=>'r',
             'seat'=>'r'


        ],
        'role_name' => [
            'module_1_name' => 'c,r,u,d',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
