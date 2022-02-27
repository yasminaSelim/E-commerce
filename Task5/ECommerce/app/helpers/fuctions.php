<?php 

function base_path(){
    return __DIR__ ."\..\..\\";
}

function bcrypt(string $password) :string 
{
    return password_hash($password,PASSWORD_BCRYPT);
}