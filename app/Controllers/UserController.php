<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Logger;
use App\Core\Validator;
use App\Models\User;
use Exception;

class UserController{
    private $user;
    public function __construct() {
        $this->user =  new User();
    }

    public function index(){
        return view("users/index.view.php", [
            "users" => $this->user->getAll()
        ]);
    }

    public function create(){
        return view("users/create.view.php");
    }

    public function store() {
        try {
            $rawInput = file_get_contents("php://input");
            $data = json_decode($rawInput, true);
            
            $validator = new Validator();
            $username = $validator->validateUsername($data['username']);
            $password = $validator->validatePassword($data['password']);
            $isAdmin = intval($data["isAdmin"]) ?? 0;

            if ($validator->hasErrors()) {
                echo json_encode([
                    'success' => false,
                    'error' => implode("\n", $validator->getErrors())
                ]);
                return;
            }

            if($this->user->getByUsername($username)){
                Logger::error("Korisnik je pokusao da doda {$username}, koji vec postoji");
                echo json_encode([ "success" => false, "error" => "Korisnik vec postoji"]);
                return;
            }

            if (!$this->user->add($username, $password, $isAdmin)) {
                Logger::error("Korisnik {$username} nije dodat");
                echo json_encode([ "success" => false, "error" => "Korsnik nije dodat"]);
                return;
            }
            Logger::info("Korisnik {$username} uspesno dodat");
            echo json_encode(["success" => true, "message" => "Korisnik uspesno dodat"]);
        }
        catch(\Exception $e){
            http_response_code(500);
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
            exit;
        }
        
    }
    public function delete(int $id) {
        try{
            $userUsername = $this->user->getById($id)["username"] ?? '';
            if (!$this->user->delete($id)) {
                Logger::error("Brisanje {$userUsername} nije uspelo");
                http_response_code(500);
                echo json_encode(["success" => false, 'error' => 'Brisanje nije uspelo']);
                return;
            }
            Logger::info("Korisnik {$userUsername} uspesno obrisan");
            echo json_encode(["success" => true, 'message' => 'Korisnik je obrisan']);
            exit;
        }catch(\Exception $e){
            http_response_code(500);
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
            exit;
        }
        
    }

    public function edit(int $id){
        try{
            $user = $this->user->getById($id);
            if(!$user){
                Logger::error("Korisnik je pokusao da menja nepostojeceg korisnika");
                header("Location: /users");
                exit;
            }
            return view("users/edit.view.php", [
                "user" => $user
            ]);
        }catch(\Exception $e){
            http_response_code(500);
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
            exit;
        }
        
    }

    public function update(int $id) {
        try {
            $input = json_decode(file_get_contents("php://input"), true);
    
            if (!$input || !isset($input["username"], $input["isAdmin"])) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Neispravan unos podataka.'
                ]);
                return;
            }


            $validator = new Validator();

            $username = $validator->validateUsername($input['username']) ?? '';
            $password = $input['password'];
            if(!empty($password)) $password = $validator->validatePassword($input['password']);
            $isAdmin = (int)$input["isAdmin"];

            $currentUser = $this->user->getById($id);
            $existingUser = $this->user->getByUsername($username);

            if ($existingUser && (int)$existingUser["member_id"] !== $id)
                $validator->addError("Korisničko ime već postoji.");
    
            if ($validator->hasErrors()) {
                echo json_encode([
                    'success' => false,
                    'error' => implode("<br>", $validator->getErrors())
                ]);
                return;
            }
            $password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $currentUser["password"];
            
            $result = $this->user->edit($id, $username, $password, $isAdmin);
    
            if ($result) {
                Logger::info("Korisnik {$username} uspešno izmenjen");
                echo json_encode([
                    "success" => true,
                    "message" => "Korisnik uspešno izmenjen"
                ]);
            } else {
                Logger::error("Neuspešna izmena korisnika {$username}");
                echo json_encode([
                    "success" => false,
                    "error" => "Korisnik nije izmenjen"
                ]);
            }
    
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }
    
    
    
    

}