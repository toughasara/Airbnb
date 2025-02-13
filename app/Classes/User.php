<?php

namespace App\Classes;


class User{

    private $id;
    private $role;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $phone_number;
    private $profile_picture;
    private $status;
    private $created_at;
    private $last_login;
    private $is_connected;

    public function __construct(
        $id = null, 
        Role $role = null,
        $first_name = null, 
        $last_name = null, 
        $email = null, 
        $password = null, 
        $phone_number = null, 
        $profile_picture = null, 
        $status = null, 
        $created_at = null, 
        $last_login = null, 
        $is_connected = false
    ) {
        $this->id = $id;
        $this->role = $role;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->phone_number = $phone_number;
        $this->profile_picture = $profile_picture;
        $this->status = $status;
        $this->created_at = $created_at ?? date("Y-m-d H:i:s");
        $this->last_login = $last_login;
        $this->is_connected = $is_connected;
    }


    // Getters 
    public function getId() {
        return $this->id;
    }

    public function getRole() {
        return $this->role;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function getProfilePicture() {
        return $this->profile_picture;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getLastLogin() {
        return $this->last_login;
    }

    public function getIsConnected() {
        return $this->is_connected;
    }

    // Setters 
    public function setRole(Role $role) {
        $this->role = $role;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setPhoneNumber($phone_number) {
        $this->phone_number = $phone_number;
    }

    public function setProfilePicture($profile_picture) {
        $this->profile_picture = $profile_picture;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setLastLogin($last_login) {
        $this->last_login = $last_login;
    }

    public function setIsConnected($is_connected) {
        $this->is_connected = $is_connected;
    }

    
    
}