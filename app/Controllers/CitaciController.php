<?php

/**
 * ČitačiController je kontroler zadužen za upravljanje CRUD operacijama nad čitačima.
 * Omogućava:
 * - Prikaz liste čitača
 * - Prikaz pojedinačnog čitača po ID-u
 * - Kreiranje novog čitača
 * - Ažuriranje postojećeg čitača
 * - Brisanje čitača
 * Sve metode koriste model `Citaci` za komunikaciju sa bazom.
 * 
 * @author 
 * @version 1.0.1
 */

namespace App\Controllers;

use App\Core\Lang;
use App\Models\Citaci;
use App\Core\Logger;
use App\Core\Validator;
use Exception;
use Respect\Validation\Validator as v;

class CitaciController
{
    private Citaci $citaci;

    /**
     * Konstruktor inicijalizuje instancu modela Čitači,
     * koja se koristi u svim metodama za pristup podacima o čitačima.
     */
    public function __construct()
    {
        $this->citaci = new Citaci();
    }

    public function __destruct()
    {
        $this->citaci->disconnect();
    }

    /**
     * Prikazuje stranicu sa svim konfiguracijama čitača.
     * Ne prima parametre.
     * Vraća view sa listom svih čitača dobijenih iz baze.
     */
    public function index()
    {
        try {
            return view("citaci/index.view.php", [
                'config' => $this->citaci->getAll() // Dohvatanje svih čitača iz baze
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.citaci.error_show_index", ['error' => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Dohvata jednog čitača po njegovom ID-u i vraća podatke u JSON formatu.
     *
     * @param int $id - ID čitača koji se traži
     * @return void - Odgovor je JSON objekat ili greška 404 ako nije pronađen
     */
    public function getById(int $id)
    {
        try {
            $citac = $this->citaci->getById($id); // SQL: SELECT WHERE ID
            if (!$citac) {
                Logger::warning(Logger::translate("logs.citaci.not_found", ["id" => $id]));
                http_response_code(500);
                echo json_encode(['error' => Lang::get("responses.citaci.not_found_citac")]);
                return;
            }

            echo json_encode($citac); // Vraćanje pronađenog čitača kao JSON
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.citaci.error_find", ["id" => $id, "error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $sort = $_GET['sort'] ?? "";
            $direction = $_GET['direction'] ?? 'asc';
            $search = $_GET['search'] ?? "";

            echo json_encode([
                'success' => true,
                'data' => $this->citaci->getAll($sort, $direction, $search)
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.citaci.error_get_all", ["error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }


    /**
     * Prikazuje formu za kreiranje novog čitača.
     *
     * @return mixed - HTML view forma
     */
    public function create()
    {
        try {
            return view("citaci/create.view.php");
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.citaci.error_show_create", ["error" => $e->getMessage()]));
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
            throw new Exception(Lang::get("logs.general.invalid_data"));
        }

        return $data;
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
            $data = $this->data();

            $v = new Validator;
            if ($this->citaci->getById((int)$data["id_citaca"])) {
                $v->addError("id_citaca", Lang::get("validator.DBduplicate"));
            }
            $v->validate($data, [
                'id_citaca' => v::notEmpty()->addRule(v::intVal()),
                'opis_citaca' => $v->optionalIfFilled(v::alnum(' ', '-')->length(1, 50)),
                'delay' => $v->optionalIfFilled(v::intVal()->min(0)),
                'sn_citaca' => v::notEmpty()->addRule(v::intVal()->min(0)),
                'sn_barijere' => $v->optionalIfFilled(v::alnum()->length(3, 15)),
                'delay_senzora' => $v->optionalIfFilled(v::intVal()->min(0)),
                'broj_ormarica' => $v->optionalIfFilled(v::intVal()),
                'broj_redova_ormarica' => $v->optionalIfFilled(v::intVal()->max(99)),
                'brojevi_ormarica' => $v->optionalIfFilled(v::regex('/^\d+(,\d+)*$/')->setTemplate(Lang::get("validator.intCommaSeparator"))->length(1, 255)),
                'ip_address' => $v->optionalIfFilled(v::ip())
            ]);
            if ($v->hasErrors()) {
                echo json_encode(['success' => false, 'errors' => $v->getErrors()]);
                return;
            }
            // Pokušava da sačuva novog čitača u bazi
            $this->citaci->create($data);

            Logger::info(Logger::translate("logs.citaci.create_success", ["citac" => json_encode($data)]));
            echo json_encode([
                'success' => true,
                'message' => Lang::get("responses.citaci.create_success"),
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.citaci.error_create", ["error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
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
            $data = $this->data();

            $citacPostoji = $this->citaci->getById((int)$data["id_citaca"]);

            $v = new Validator;
            if ($citacPostoji && $citacPostoji["id_citaca"] != $id) {
                $v->addError("id_citaca", Lang::get("validator.DBduplicate"));
            }
            $v->validate($data, [
                'id_citaca' => v::notEmpty()->addRule(v::intVal()->min(0)),
                'opis_citaca' => $v->optionalIfFilled(v::alnum(' ', '-')->length(1, 50)),
                'delay' => $v->optionalIfFilled(v::intVal()->min(0)),
                'sn_citaca' => v::notEmpty()->addRule(v::intVal()->min(0)),
                'sn_barijere' => $v->optionalIfFilled(v::alnum()->length(3, 15)),
                'delay_senzora' => $v->optionalIfFilled(v::intVal()->min(0)),
                'broj_ormarica' => $v->optionalIfFilled(v::intVal()),
                'broj_redova_ormarica' => $v->optionalIfFilled(v::intVal()->max(99)),
                'brojevi_ormarica' => $v->optionalIfFilled(v::regex('/^\d+(,\d+)*$/')->setTemplate(Lang::get("validator.intCommaSeparator"))->length(1, 255)),
                'ip_address' => $v->optionalIfFilled(v::ip())
            ]);
            if ($v->hasErrors()) {
                echo json_encode(['success' => false, 'errors' => $v->getErrors()]);
                return;
            }
            $this->citaci->update($id, $data);

            Logger::info(Logger::translate("logs.citaci.update_success", ["id" => $id]));
            echo json_encode([
                'success' => true,
                'message' => Lang::get("responses.citaci.update_success"),
                'data' => $this->citaci->getById($data['id_citaca']) // Ponovno dohvaćanje ažuriranog zapisa
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.citaci.error_update", ["id" => $id, "error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
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
            $this->citaci->delete($id);

            Logger::info(Logger::translate("logs.citaci.delete_success", ["id" => $id]));
            echo json_encode([
                'success' => true,
                'message' => Lang::get("responses.citaci.delete_success"),
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.citaci.error_delete", ["id" => $id, "error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }
}
