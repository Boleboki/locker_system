<?php


return [
    'auth' => [
        'validation_failed' => 'Validacija neuspešna za korisnika :username. Greške: :errors',
        'login_failed'      => 'Neuspešan pokušaj prijave za korisnika :username.',
        'login_success'     => 'Korisnik :username je uspešno prijavljen.',
        'logout_success'    => 'Korisnik :username je uspešno odjavljen.',
        'error_login'       => 'Greška prilikom prijave: :error',
        'error_logout'      => 'Greška prilikom odjave: :error',
        'error_show_index'  => 'Greška prilikom prikaza forme za prijavu: :error',
    ],

    'citaci' => [
        'error_show_index' => "Greška prilikom prikaza svih čitača: :error",
        'error_get_all' => "Greška prilikom dohvatanja svih čitača: :error",
        'error_get_by_id' => "Greška prilikom dohvatanja čitača sa ID-jem :id: :error",
        'not_found' => "Čitač sa ID :id nije pronađen",
        'error_find' => "Greška prilikom prikaza čitača sa ID-jem :id: :error",
        'error_show_create' => "Greška prilikom prikaza forme za čitača: :error",
        'error_create' => "Greška prilikom dodavanja čitača: :error",
        'error_update' => "Greška prilikom ažuriranja čitača sa ID-jem :id: :error",
        'error_delete' => "Greška prilikom brisanja čitača sa ID-jem :id: :error",
        'create_success' => "Uspešno dodat novi čitač: :citac",
        'update_success' => "Čitač sa ID-jem :id uspešno ažuriran",
        'delete_success' => "Čitač sa ID-jem :id uspešno obrisan",
        'missing_field' => "Nedostaje obavezno polje: :field",

    ],
    'configuration' => [
        'error_get_all' => "Greška prilikom učitavanja svih konfiguracija: :error",
        'error_show_index' => "Greška prilikom prikaza svih konfiguracija: :error",
        'update_success' => "Konfiguracija sa ključem ':key' uspešno ažurirana na: :value",
        'error_update' => "Greška prilikom ažuriranja konfiguracije sa ključem ':key': :error",
        'delete_success' => "Konfiguracija sa ključem ':key' uspešno obrisana",
        'error_delete' => "Greška prilikom brisanja konfiguracije sa ključem ':key': :error",
    ],
    'users' => [
        'error_show_index' => "Greška prilikom prikaza korisnika: :error",
        'error_show_create' => "Greška prilikom prikaza forme za korisnika: :error",
        'error_create' => "Greška prilikom dodavanja korisnika: :error",
        'error_delete' => "Greška prilikom brisanja korisnika sa ID-jem :id: :error",
        'error_update' => "Greška prilikom ažuriranja korisnika sa ID-jem :id: :error",
        'error_edit' => "Greška prilikom prikaza korisnika za izmenu sa ID-jem :id: :error",
        'create_success' => "Korisnik :username uspešno dodat",
        'delete_success' => "Korisnik :username uspešno obrisan",
        'update_success' => "Korisnik :username uspešno izmenjen",
        'not_found' => "Korisnik sa ID-jem :id nije pronađen",
        'exists' => "Pokušaj dodavanja već postojećeg korisnika: :username",
        'validation_failed' => "Validacija neuspešna za korisnika: :username. Greške: :errors",
        'error_get_by_id' => "Greška prilikom dohvaćanja korisnika po ID-ju :id: :error",
        'error_get_by_username' => "Greška prilikom dohvaćanja korisnika po korisničkom imenu ':username': :error",
        'error_get_all' => "Greška prilikom dohvaćanja svih korisnika: :error",
        'error_add' => "Greška prilikom dodavanja korisnika ':username': :error",
        'error_delete_by_id' => "Greška prilikom brisanja korisnika sa ID-jem :id: :error",
        'error_edit_by_id' => "Greška prilikom ažuriranja korisnika sa ID-jem :id: :error",
    ],

    'general' => [
        'invalid_data' => "Nevalidni podaci"
    ]
];
