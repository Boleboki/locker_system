<?php
return [
    'page_title' => 'Lista korisnika',

    'modal_delete' => [
        'title' => 'Potvrda brisanja',
        'message' => 'Da li ste sigurni da želite da obrišete korisnika',
        'cancel' => 'Otkaži',
        'confirm' => 'Obriši',
    ],

    'table' => [
        'id' => 'ID',
        'username' => 'Korisničko ime',
        'role' => 'Rola',
        'active' => 'Aktivan',
        'empty' => 'Nema korisnika za prikaz.',
    ],

    'roles' => [
        'admin' => 'Admin',
        'user' => 'Korisnik',
    ],

    'form' => [
        'edit_title' => 'Izmena korisnika',
        'create_title' => 'Dodavanje novog korisnika',

        'labels' => [
            'username' => 'Korisničko ime',
            'password' => 'Lozinka',
            'role' => 'Rola',
            'active' => 'Aktivan',
            'new_password' => 'Nova lozinka',
            'confirm_password' => 'Potvrdi lozinku',
        ],

        'buttons' => [
            'save_changes' => 'Sačuvaj izmene',
            'save_user' => 'Sačuvaj korisnika',
            'reset_password' => 'Resetuj lozinku',
            'confirm_reset' => 'Potvrdi',
        ],

        'modals' => [
            'reset_password_title' => 'Resetuj lozinku korisniku',
        ],
    ],
];
