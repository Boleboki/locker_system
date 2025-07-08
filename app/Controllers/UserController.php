<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Lang;
use App\Core\Logger;
use App\Core\Validator;
use App\Models\User;
use Exception;
use Respect\Validation\Validator as v;

/**
 * Kontroler za upravljanje korisnicima.
 * Obezbeđuje CRUD funkcionalnosti i validaciju podataka korisnika.
 *
 * @author 
 * @version 1.0.1
 */
class UserController
{
    private User $user;

    public function __construct()
    {
        // Inicijalizuje model korisnika za rad sa bazom
        $this->user = new User();
    }

    public function __destruct()
    {
        $this->user->disconnect();
    }

    /**
     * Prikazuje listu svih korisnika.
     *
     */
    public function index()
    {
        try {
            return view("users/index.view.php", [
                "users" => $this->user->getAll()
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.users.error_show_index", ["error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Prikazuje formu za kreiranje novog korisnika.
     *
     */
    public function create()
    {
        try {
            return view("users/create.view.php");
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.users.error_show_create", ["error" => $e->getMessage()]));
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
     * Obrada POST zahteva za dodavanje novog korisnika.
     * Validira podatke, proverava postojanje korisnika i upisuje novog korisnika.
     */
    public function store(): void
    {
        try {
            $data = $this->data();

            $username = $data['username'] ?? '';


            $validator = new Validator();
            if ($this->user->getByUsername($username)) {
                $validator->addError("username", Lang::get("validator.username.exists"));
            }
            $validator->validate($data, [
                'username' => v::notEmpty()->addRule($validator->noSpecialChars())->addRule(v::length(3, 20)),
                'password' => v::notEmpty()->addRule($validator->noSpecialChars())->addRule(v::length(3, 20))
            ]);

            if ($validator->hasErrors()) {
                Logger::warning(Logger::translate("logs.users.validation_failed", ['username' => $username, 'errors' => json_encode($validator->getErrors())]));
                echo json_encode([
                    'success' => false,
                    'errors' => $validator->getErrors()
                ]);
                return;
            }

            if ($this->user->getByUsername($username)) {
                Logger::warning(Logger::translate("logs.users.exists", ["username" => $username]));
                echo json_encode([
                    "success" => false,
                    "error" => Lang::get("responses.users.exists")
                ]);
                return;
            }

            $this->user->add($data);

            Logger::info(Logger::translate("logs.users.create_success", ["username" => $username]));
            echo json_encode([
                "success" => true,
                "message" => Lang::get("responses.users.create_success")
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.users.error_add", ["error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }


    /**
     * Briše korisnika po ID-u.
     *
     * @param int $id ID korisnika za brisanje
     */
    public function delete(int $id): void
    {
        try {
            $user = $this->user->getById($id);
            $username = $user['username'] ?? '';

            if (!$user) {
                Logger::warning(Logger::translate("logs.users.not_found", ["id" => $id]));
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "error" => Lang::get("responses.users.not_found")
                ]);
                return;
            }

            $this->user->delete($id);

            Logger::info(Logger::translate("logs.users.delete_success", ["username" => $username]));
            echo json_encode([
                "success" => true,
                "message" => Lang::get("responses.users.delete_success")
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.users.error_delete", ["id" => $id, "error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Prikazuje formu za izmenu korisnika.
     *
     * @param int $id ID korisnika za izmenu
     */
    public function edit(int $id)
    {
        try {
            $user = $this->user->getById($id);

            if (!$user) {
                Logger::warning(Logger::translate("logs.users.not_found", ["id" => $id]));
                redirect("/users");
            }

            return view("users/edit.view.php", [
                "user" => $user
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.users.error_edit", ["id" => $id, "error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }


    /**
     * Ažurira korisnika na osnovu ID-a.
     *
     * @param int $id ID korisnika
     */
    public function update(int $id): void
    {
        try {
            $data = $this->data();

            $username = $data["username"] ?? '';

            $existingUser = $this->user->getByUsername($username);

            $validator = new Validator();

            if ($existingUser && (int)$existingUser["member_id"] !== $id) {
                $validator->addError("username", Lang::get("validator.username.exists"));
            }

            $validator->validate($data, [
                'username' => v::notEmpty()->addRule($validator->noSpecialChars())->addRule(v::length(3, 20)),
            ]);

            if ($validator->hasErrors()) {
                Logger::warning(Logger::translate("logs.users.validation_failed", ['username' => $username, 'errors' => json_encode($validator->getErrors())]));
                echo json_encode([
                    'success' => false,
                    'errors' => $validator->getErrors()
                ]);
                return;
            }

            $this->user->edit($id, $data);

            Logger::info(Logger::translate("logs.users.update_success", ["username" => $username]));
            echo json_encode([
                "success" => true,
                "message" => Lang::get("responses.users.update_success")
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.users.error_update", ["id" => $id, "error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Ažurira korisničku lozinku na osnovu ID-a.
     *
     * @param int $id ID korisnika
     */
    public function updatePassword(int $id)
    {
        try {

            $data = $this->data();

            $username = $this->user->getById($id)['username'] ?? '';

            $validator = new Validator();

            $validator->validate($data, [
                'new_password' => v::notEmpty()->addRule($validator->noSpecialChars())->addRule(v::length(3, 20)),
                'confirm_password' => v::equals($data["new_password"])->setTemplate(Lang::get("validator.password.equals")),
            ]);

            if ($validator->hasErrors()) {
                Logger::warning(Logger::translate("logs.users.validation_failed", ['username' => $username, 'errors' => json_encode($validator->getErrors())]));
                echo json_encode([
                    'success' => false,
                    'errors' => $validator->getErrors()
                ]);
                return;
            }

            $this->user->editPassword($id, $data["new_password"]);

            Logger::info(Logger::translate("logs.users.update_success", ["username" => $username]));
            echo json_encode([
                "success" => true,
                "message" => Lang::get("responses.users.update_success")
            ]);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.users.error_update", ["id" => $id, "error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }
}
