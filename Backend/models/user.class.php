<?php

class User
{
    // Eigenschaften (Attribute) des Benutzers
    private int $id;
    private bool $is_admin;
    private string $first_name;
    private string $last_name;
    private string $address;
    private string $postal_code;
    private string $city;
    private string $email;
    private string $benutzername;
    private string $password;
    private bool $active;

    // Konstruktor – wird beim Erstellen eines User-Objekts aufgerufen
    public function __construct(
        int $id,
        bool $is_admin,
        string $first_name,
        string $last_name,
        string $address,
        string $postal_code,
        string $city,
        string $email,
        string $benutzername,
        string $password,
        bool $active
    ) {
        $this->id = $id;
        $this->is_admin = $is_admin;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->address = $address;
        $this->postal_code = $postal_code;
        $this->city = $city;
        $this->email = $email;
        $this->benutzername = $benutzername;
        $this->password = $password;
        $this->active = $active;
    }

    // Getter & Setter

    public function getId(): int {
        return $this->id;
    }

    public function isAdmin(): bool {
        return $this->is_admin;
    }

    public function getFirstName(): string {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void {
        $this->first_name = $first_name;
    }

    public function getLastName(): string {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void {
        $this->last_name = $last_name;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getPostalCode(): string {
        return $this->postal_code;
    }

    public function getCity(): string {
        return $this->city;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getBenutzername(): string {
        return $this->benutzername;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function isActive(): bool {
        return $this->active;
    }

    //  Gibt alle Daten als Array zurück – z. B. für JSON oder Session
    public function toArray(): array {
        return [
            "id" => $this->id,
            "is_admin" => $this->is_admin,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "address" => $this->address,
            "postal_code" => $this->postal_code,
            "city" => $this->city,
            "email" => $this->email,
            "benutzername" => $this->benutzername,
            "password" => $this->password,
            "active" => $this->active
        ];
    }
}
