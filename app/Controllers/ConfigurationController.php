<?php

/** 
 * Ovaj fajl definiše kontroler koji upravlja konfiguracijama aplikacije.
 * Omogućava prikaz svih konfiguracija, ažuriranje vrednosti i brisanje pojedinačnih konfiguracija putem API zahteva.
 * 
 * @author 
 * @version 1.0.1
 */

namespace App\Controllers;

use App\Core\Lang;
use App\Models\Configure;
use App\Core\Logger;

class ConfigurationController
{
    // Instanca modela za rad sa konfiguracionim podacima
    protected Configure $configModel;

    /**
     * Konstruktor kontrolera
     * Inicijalizuje model koji komunicira sa bazom (tabela 'configure')
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
            Logger::error(Logger::translate("logs.configuration.error_show_index", ['error' => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Parsira JSON podatke iz HTTP tela zahteva
     * 
     * @return array|null - Vraća podatke kao asocijativni niz ako su validni, u suprotnom baca izuzetak
     * 
     * Čita raw JSON iz ulaza (`php://input`) i dekodira ga.
     * Ako JSON nije validan ili nije niz, loguje upozorenje i baca izuzetak sa prevedenom porukom.
     */
    private function data(): ?array
    {
        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            Logger::warning(Logger::translate("logs.general.invalid_data"));
            throw new \Exception(Lang::get("logs.general.invalid_data"));
        }

        return $data;
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
            $data = $this->data();

            $this->configModel->update($key, $data['value']);

            Logger::info(Logger::translate("logs.configuration.update_success", ['key' => $key, 'value' => $data['value']]));
            echo json_encode([
                'success' => true,
                'message' => Lang::get("responses.configuration.update_success", ["key" => $key])
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.configuration.error_update", ['key' => $key, 'error' => $e->getMessage()]));
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
            $this->configModel->delete($key);

            Logger::info(Logger::translate("logs.configuration.delete_success", ['key' => $key]));
            echo json_encode([
                'success' => true,
                'message' => Lang::get("responses.configuration.delete_success")
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.configuration.error_delete", ['key' => $key, 'error' => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }
}
