<?php

// Ovaj fajl definiše kontroler koji upravlja konfiguracijama aplikacije.
// Omogućava prikaz svih konfiguracija, ažuriranje vrednosti i brisanje pojedinačnih konfiguracija putem API zahteva.

namespace App\Controllers;

use App\Models\Configure;

class ConfigurationController
{
    // Instanca modela za rad sa konfiguracionim podacima
    protected Configure $configModel;

    /**
     * Konstruktor kontrolera
     * Inicijalizuje model koji komunicira sa bazom (tabela 'confingure')
     */
    public function __construct()
    {
        $this->configModel = new Configure();
    }

    /**
     * Prikazuje sve konfiguracije.
     * Ne prima parametre.
     * Ne vraća eksplicitno ništa, ali renderuje view sa listom konfiguracija.
     */
    public function index()
    {
        $config = $this->configModel->getAll(); // Dobavlja sve konfiguracije iz baze
        view("configuration/index.view.php", ['config' => $config]); // Prosleđuje ih view fajlu za prikaz
    }

    /**
     * Ažurira određenu konfiguraciju na osnovu njenog ključa.
     * 
     * @param string $key - Ključ konfiguracije koja se ažurira
     * Ne vraća ništa, ali šalje JSON odgovor nazad frontend-u.
     */
    public function update(string $key)
    {
        // Čita JSON payload iz zahteva
        $data = json_decode(file_get_contents("php://input"), true);

        // Pokušava da ažurira vrednost u bazi
        if (!$this->configModel->update($key, $data['value'])) {
            // Ako ažuriranje ne uspe, vraća HTTP 500 i poruku o grešci
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update configuration']);
            return;
        }

        // Uspesan odgovor ako je ažuriranje prošlo bez greške
        echo json_encode(['success' => true, 'message' => 'Configuration updated successfully']);
    }

    /**
     * Briše konfiguraciju na osnovu njenog ključa.
     * 
     * @param string $key - Ključ konfiguracije koja se briše
     * Ne vraća ništa, ali šalje JSON odgovor o uspehu ili grešci.
     */
    public function delete(string $key)
    {
        // Pokušava da obriše konfiguraciju iz baze
        if (!$this->configModel->delete($key)) {
            // Ako brisanje ne uspe, vraća HTTP 500 i poruku o grešci
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete configuration']);
            return;
        }

        // Uspesan odgovor ako je brisanje prošlo bez greške
        echo json_encode(['success' => true, 'message' => 'Configuration deleted successfully']);
    }
}
