<?php
namespace App\Services\Interfaces;
use App\DTO\UserDTO;
use App\Models\User;

interface UserServiceInterface{
    public function getAll():array;
    public function getById(string $id): ?User;
    public function create(UserDTO $userDTO):User;
    public function update( string $id, UserDTO $userDTO):?User;
    public function delete(string $id):bool;
}
