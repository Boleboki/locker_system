<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Klasa Validator služi za validaciju korisničkih podataka kao što su korisničko ime i lozinka.
 * Validira dužinu, prazninu i potencijalne XSS napade.
 * Čuva sve greške koje su nastale tokom validacije.
 * 
 * @author
 * @version 1.0.1
 */
class Validator
{
    /**
     * Niz u kome se čuvaju poruke o greškama nastalim tokom validacije.
     * @var array
     */
    private $errors = [];

    /**
     * Validira korisničko ime.
     * Proverava da li je korisničko ime prazno, da li je dužine između 3 i 20 karaktera,
     * kao i da li sadrži potencijalno maliciozne HTML tagove (XSS napad).
     * 
     * @param string $username Korisničko ime koje se validira
     * @return string|null Vraća sanitizovano korisničko ime ili null ako je bilo grešaka
     */
    public function validateUsername(string $username)
    {
        $username = trim($username);
        if (empty($username)) {
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
        // Sanitizacija korisničkog imena radi sigurnosti
        return htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validira lozinku.
     * Proverava da li je lozinka prazna, da li ima najmanje 6 karaktera,
     * kao i da li sadrži potencijalne XSS napade.
     * Komentarisan je deo koda za proveru složenosti lozinke koji se može aktivirati po potrebi.
     * 
     * @param string $password Lozinka koja se validira
     * @return string|null Vraća sanitizovanu lozinku ili null ako je bilo grešaka
     */
    public function validatePassword(string $password)
    {
        if (empty($password)) {
            $this->errors[] = "Lozinka ne sme da bude prazna";
            return;
        }
        if (strlen($password) < 6) {
            $this->errors[] = "Lozinka mora imati najmanje 6 karaktera.";
            return;
        }
        // Primer naprednije validacije lozinke (veliko, malo slovo, cifra) je zakomentarisan
        /*
        if (!preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/[0-9]/', $password)) {
            $this->errors[] = "Lozinka mora sadržati bar jedno veliko slovo, malo slovo i cifru.";
            return;
        }
        */
        if ($this->containsXSS($password)) {
            $this->errors[] = "Lozinka sadrži nedozvoljene karaktere.";
            return;
        }
        // Sanitizacija lozinke za bezbednost
        return htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Pomoćna metoda za proveru da li ulazni string sadrži HTML tagove,
     * što može ukazivati na pokušaj XSS napada.
     * 
     * @param string $input Ulazni string koji se proverava
     * @return bool Vraća true ako postoji razlika između originalnog i "očistjenog" stringa
     */
    private function containsXSS($input)
    {
        return $input !== strip_tags($input);
    }

    /**
     * Proverava da li postoje greške nastale tokom validacije.
     * 
     * @return bool Vraća true ako postoje greške, false ako nema
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Vraća niz sa svim greškama koje su nastale tokom validacije.
     * 
     * @return array Niz tekstualnih poruka o greškama
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Dodaje proizvoljnu grešku u listu grešaka.
     * 
     * @param string $message Tekstualna poruka greške
     */
    public function addError($message)
    {
        $this->errors[] = $message;
    }
}
