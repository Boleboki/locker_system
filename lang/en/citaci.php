<?php
return [
    'page_title' => 'Reader Configuration',

    'table' => [
        'id' => 'ID',
        'description' => 'Description',
        'type' => 'Type',
        'active' => 'Active',

        'reader_type_title' => 'Reader Type',

        'reader_type' => [
            'group_evidence' => 'Tracking',
            'group_other' => 'Other',
            'working_time' => 'Working Time',
            'access_control' => 'Access Control',
            'for_lockers' => 'For Lockers',
            'for_lockers_group' => 'For Locker Group',
            'for_logout' => 'For Logout',
        ],

        'delay_title' => 'Delay',
        'delay' => [
            'time' => 'Time',
            'sensor' => 'Sensor',
        ],

        'sn_title' => 'SN',
        'serial_number' => [
            'reader' => 'Reader',
            'barrier' => 'Barrier',
        ],

        'lockers_title' => 'Lockers',
        'lockers' => [
            'number' => 'Number',
            'rows_number' => 'Number of Rows',
            'by_index' => 'By Index',
        ],
        'ip_address' => "IP address"

    ],

    'buttons' => [
        'add_new' => "Add new reader",

    ],

    'modal_delete' => [
        'title' => 'Delete Confirmation',
        'message' => 'Are you sure you want to delete reader',
    ],

    'form' => [
        'create_title' => 'Create New Reader',
        'edit_title' => 'Edit Reader',
        'section_title' => "Reader Functionalities",
        'labels' => [
            'active' => 'Active',
            'id' => 'Reader ID',
            'type' => 'Reader Type',
            'serial_number_reader' => 'Reader SN',
            'serial_number_barrier' => 'Barrier SN',
            'delay_time' => 'Delay Time',
            'delay_sensor' => 'Sensor Delay',
            'description' => 'Reader Description',
            'lockers_number' => 'Number of Lockers',
            'lockers_rows' => 'Number of Rows',
            'lockers_by_index' => 'By Index',
            'lockers_ids' => 'Locker Numbers / Reader IDs',
            'ip_address' => 'IP address'
        ],
        'checkboxes' => [
            'access_control' => 'for access control',
            'working_time' => 'for working time',
            'for_lockers' => 'for lockers',
            'for_lockers_group' => 'for locker group',
            'for_logout' => 'for logout',
        ],
        'textarea_help' => '*use a comma to separate locker numbers',
    ],
];
