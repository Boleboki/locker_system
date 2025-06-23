<?php

/**
 * CitaciController je kontroler zadužen za upravljanje CRUD operacijama nad čitačima.
 * Omogućava:
 * - Prikaz liste čitača
 * - Prikaz pojedinačnog čitača po ID-u
 * - Kreiranje novog čitača
 * - Ažuriranje postojećeg čitača
 * - Brisanje čitača
 * Sve metode koriste model `Citaci` za komunikaciju sa bazom.
 */

namespace App\Controllers;

use App\Models\Citaci;

class CitaciController
{
    private Citaci $citaci;

    /**
     * Konstruktor inicijalizuje instancu modela Citaci,
     * koja se koristi u svim metodama za pristup podacima o čitačima.
     */
    public function __construct()
    {
        $this->citaci = new Citaci();
    }

    /**
     * Prikazuje stranicu sa svim konfiguracijama čitača.
     * Ne prima parametre.
     * Vraća view sa listom svih čitača dobijenih iz baze.
     */
    public function index()
    {
        return view("citaci/index.view.php", [
            'config' => $this->citaci->getAll() // Dohvatanje svih čitača iz baze
        ]);
    }

    /**
     * Dohvata jednog čitača po njegovom ID-u i vraća podatke u JSON formatu.
     *
     * @param int $id - ID čitača koji se traži
     * @return void - Odgovor je JSON objekat ili greška 404 ako nije pronađen
     */
    public function getById(int $id)
    {
        $citac = $this->citaci->getById($id); // SQL: SELECT WHERE ID
        if (!$citac) {
            http_response_code(404); // Postavljanje HTTP koda ako nije pronađen
            echo json_encode(['error' => 'Čitač nije pronađen']);
            exit;
        }

        echo json_encode($citac); // Vraćanje pronađenog čitača kao JSON
    }

    /**
     * Prikazuje formu za kreiranje novog čitača.
     *
     * @return mixed - HTML view forma
     */
    public function create()
    {
        return view("citaci/create.view.php");
    }

    /**
     * Snima novog čitača na osnovu JSON podataka poslatih iz zahteva.
     *
     * @return void - Vraća JSON sa statusom uspeha ili greške
     */
    public function store()
    {
        try {
            // Čitanje JSON podataka iz tela HTTP zahteva
            $data = json_decode(file_get_contents("php://input"), true);

            // Validacija: Proverava da li su podaci validni
            if (!$data) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid input data']);
                exit;
            }

            // Pokušava da sačuva novog čitača u bazi
            if (!$this->citaci->create($data)) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Greška prilikom dodavanja čitača.'
                ]);
                exit;
            }

            // Uspešan odgovor
            echo json_encode([
                'success' => true,
                'message' => 'Citac je uspesno dodat',
            ]);
        } catch (\Exception $e) {
            // Hvata i prikazuje nepredviđene greške
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }

        exit;
    }

    /**
     * Ažurira postojeći čitač sa zadatim ID-om na osnovu podataka iz zahteva.
     *
     * @param int|string $id - ID čitača koji se ažurira
     * @return void - Vraća JSON sa informacijom o uspehu ili grešci
     */
    public function update($id)
    {
        try {
            // Čitanje JSON podataka iz tela zahteva
            $data = json_decode(file_get_contents("php://input"), true);

            // Provera validnosti podataka
            if (!$data) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid input data']);
                exit;
            }

            // Pokušaj ažuriranja čitača u bazi
            if (!$this->citaci->update($id, $data)) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Greška prilikom ažuriranja čitača.'
                ]);
                exit;
            }

            // Vraća ažurirane podatke i poruku o uspehu
            echo json_encode([
                'success' => true,
                'message' => 'Citac je uspesno ažuriran',
                'data' => $this->citaci->getById($data['id_citaca']) // Ponovno dohvaćanje ažuriranog zapisa
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }

        exit;
    }

    /**
     * Briše čitača iz baze na osnovu ID-a.
     *
     * @param int|string $id - ID čitača koji se briše
     * @return void - Vraća JSON sa potvrdom o brisanju ili greškom
     */
    public function delete($id)
    {
        try {
            // Pokušaj brisanja zapisa iz baze
            if (!$this->citaci->delete($id)) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Greška prilikom brisanja čitača.'
                ]);
                exit;
            }

            // Potvrda o uspešnom brisanju
            echo json_encode([
                'success' => true,
                'message' => 'Citac je uspesno obrisan',
            ]);
        } catch (\Exception $e) {
            // Neobrađena greška
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }

        exit;
    }
}
