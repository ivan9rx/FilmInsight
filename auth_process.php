<?php

use function PHPSTORM_META\type;

require_once("globals.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("db.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");


if ($type === "register") {
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    //verificaçao de dados minimos

    if ($name && $lastname && $email && $password) {
        //verifica se as senhas batem

        if ($password === $confirmpassword) {
            //verifica se o email esta cadastrado no sistema    
            if ($userDao->findByEmail($email) === false) {
                $user =  new User();

                //criando token e senha

                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);
            } else {
                $message->setMessage("Usuario já cadastrado", "error", "back");
            }
        } else {
            $message->setMessage("Por favor confira as senhas", "error", "back");
        }
    } else {
        $message->setMessage("Por favor preencha todos os campos", "error", "back");
    }
} else if ($type === "login") {
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    if($userDao->authenticateUser($email, $password)) {
        $message->setMessage("Seja bem vindo!", "success", "editprofile.php");

    } else {

        $message->setMessage("Usuário ou senha incorretos", "error", "back");

    }
} else {
    $message->setMessage("informações inválidas", "error", "index.php");
}
