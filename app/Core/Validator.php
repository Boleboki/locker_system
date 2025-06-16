<?php

declare(strict_types=1);

namespace App\Core;

class Validator {
    private $errors = [];

    public function validateUsername(string $username) {
        $username = trim($username);
        if(empty($username)){
            $this->errors[] = "Korisnicko ime ne sme da bude prazno";
            return;
        }
        if (strlen($username) < 3 || strlen($username) > 20) {
            $this->errors[] = "Korisničko ime mora imati između 3 i 20 karaktera.";
            return;
        }
        if ($this->containsXSS($username)) {
            $this->errors[] = "Korisničko ime sadrži nedozvoljene karaktere.";
            return;
        }
        return htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    }

    public function validatePassword(string $password) {

        if(empty($password)){
            $this->errors[] = "Lozinka ne sme da bude prazna";
            return;
        }
        if (strlen($password) < 6) {
            $this->errors[] = "Lozinka mora imati najmanje 6 karaktera.";
            return;
        }
        // if (!preg_match('/[A-Z]/', $password) ||
        //     !preg_match('/[a-z]/', $password) ||
        //     !preg_match('/[0-9]/', $password)) {
        //     $this->errors[] = "Lozinka mora sadržati bar jedno veliko slovo, malo slovo i cifru.";
        //     return;
        // }
        if ($this->containsXSS($password)) {
            $this->errors[] = "Lozinka sadrži nedozvoljene karaktere.";
            return;
        }
        return htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
    }

    private function containsXSS($input) {
        return $input !== strip_tags($input);
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
    public function addError($message) {
        $this->errors[] = $message;
    }
}
