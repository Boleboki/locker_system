<?php
return [
    'page_title' => 'Podešavanja čitača',

    'table' => [
        'id' => 'ID',
        'description' => 'Opis',
        'type' => 'Tip',
        'active' => 'Aktivan',

        'reader_type_title' => 'Vrsta čitača',

        'reader_type' => [
            'group_evidence' => 'Evidencija',
            'group_other' => 'Ostalo',
            'working_time' => 'Radnog vremena',
            'access_control' => 'Kontrola pristupa',
            'for_lockers' => 'Za ormariće',
            'for_lockers_group' => 'Za grupu ormarića',
            'for_logout' => 'Za odjavu',
        ],

        'delay_title' => 'Delay',
        'delay' => [
            'time' => 'Vremena',
            'sensor' => 'Senzora',
        ],

        'sn_title' => 'SN',
        'serial_number' => [
            'reader' => 'Čitača',
            'barrier' => 'Barijere',
        ],

        'lockers_title' => 'Ormarići',
        'lockers' => [
            'number' => 'Broj',
            'rows_number' => 'Broj redova',
            'by_index' => 'Po indeksu',
        ],
        'ip_address' => "IP adresa"
    ],
    'buttons' => [
        'add_new' => "Dodaj novi čitač",

    ],
    'modal_delete' => [
        'title' => 'Potvrda brisanja',
        'message' => 'Da li ste sigurni da želite da obrišete čitač',
    ],


    'form' => [
        'create_title' => 'Unos novog čitača',
        'edit_title' => 'Izmena čitača',
        'section_title' => "Funkcionalnosti čitača",
        'labels' => [
            'active' => 'Aktivan',
            'id' => 'ID čitača',
            'type' => 'Tip čitača',
            'serial_number_reader' => 'SN čitača',
            'serial_number_barrier' => 'SN barijere',
            'delay_time' => 'Delay vreme',
            'delay_sensor' => 'Delay senzora',
            'description' => 'Opis čitača',
            'lockers_number' => 'Broj ormarića',
            'lockers_rows' => 'Broj redova',
            'lockers_by_index' => 'Po indeksu niza',
            'lockers_ids' => 'Brojevi ormarića / ID brojevi čitača',
            'ip_address' => 'IP adresa'
        ],
        'checkboxes' => [
            'access_control' => 'za kontrolu pristupa',
            'working_time' => 'za radno vreme',
            'for_lockers' => 'za ormariće',
            'for_lockers_group' => 'za grupu ormarića',
            'for_logout' => 'za odjavu',
        ],
        'textarea_help' => '*koristite zarez za odvajanje ormarića',
    ],
];
