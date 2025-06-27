<?php

/** 
 * Ovaj fajl definiše kontroler koji upravlja konfiguracijama aplikacije.
 * Omogućava prikaz svih konfiguracija, ažuriranje vrednosti i brisanje pojedinačnih konfiguracija putem API zahteva.
 * 
 * @author 
 * @version 1.0.1
 */

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

    public function __destruct()
    {
        $this->configModel->disconnect();
    }

    /**
     * Prikazuje sve konfiguracije.
     * Ne prima parametre.
     * Ne vraća eksplicitno ništa, ali renderuje view sa listom konfiguracija.
     */
    public function index()
    {
        try {
            $config = $this->configModel->getAll(); // Dobavlja sve konfiguracije iz baze
            return view("configuration/konfiguracija.view.php", ['config' => $config]); // Prosleđuje ih view fajlu za prikaz
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Ažurira određenu konfiguraciju na osnovu njenog ključa.
     * 
     * @param string $key - Ključ konfiguracije koja se ažurira
     * Ne vraća ništa, ali šalje JSON odgovor nazad frontend-u.
     */
    public function update(string $key)
    {
        try {
            // Čita JSON payload iz zahteva
            $data = json_decode(file_get_contents("php://input"), true);

            // Pokušava da ažurira vrednost u bazi
            $this->configModel->update($key, $data['value']);

            // Uspesan odgovor ako je ažuriranje prošlo bez greške
            echo json_encode(['success' => true, 'message' => 'Configuration updated successfully']);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Briše konfiguraciju na osnovu njenog ključa.
     * 
     * @param string $key - Ključ konfiguracije koja se briše
     * Ne vraća ništa, ali šalje JSON odgovor o uspehu ili grešci.
     */
    public function delete(string $key)
    {
        try {
            // Pokušava da obriše konfiguraciju iz baze
            $this->configModel->delete($key);

            // Uspesan odgovor ako je brisanje prošlo bez greške
            echo json_encode(['success' => true, 'message' => 'Configuration deleted successfully']);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }
}
