<?php

use function PHPSTORM_META\type;

require_once("globals.php");
require_once("models/Movie.php");
require_once("models/Message.php");
require_once("db.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");

$userData = $userDao->verifyToken();

if ($type === "create") {
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer = filter_input(INPUT_POST, "trailer");
    $category = filter_input(INPUT_POST, "category");
    $lenght = filter_input(INPUT_POST, "lenght");

    $movie = new Movie();

    if (!empty($title) && !empty($description) && !empty($category)) {
        $movie->title = $title;
        $movie->description = $description;
        $movie->trailer = $trailer;
        $movie->category = $category;
        $movie->lenght = $lenght;
        $movie->users_id = $userData->id;

        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            if (in_array($image["type"], $imageTypes)) {
                if (in_array($image["type"], $jpgArray)) {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                $imageName = $movie->imageGenerateName();

                // Verificar a extensão do arquivo
                $ext = pathinfo($imageName, PATHINFO_EXTENSION);

                if ($ext == 'jpg' || $ext == 'jpeg') {
                    imagejpeg($imageFile, "./img/movies/" . $imageName, 100);
                } else if ($ext == 'png') {
                    imagepng($imageFile, "./img/movies/" . $imageName);
                } else {
                    $message->setMessage("Tipo de imagem não suportado!", "error", "back");
                }

                $movie->image = $imageName;
            } else {
                $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
            }
        }

        $movieDao->create($movie);
    } else {
        $message->setMessage("Você precisa adicionar um título, uma descrição e uma categoria!", "error", "index.php");
    }
} else if ($type === "delete") {

    $id = filter_input(INPUT_POST, "id");

    $movie =  $movieDao->findById($id);

    if ($movie) {
        if ($movie->users_id === $userData->id) {
            $movieDao->destroy($movie->id);
        } else {
            $message->setMessage("Informações inválidas", "error", "index.php");
        }
    } else {
        $message->setMessage("Informações inválidas", "error", "index.php");
    }
} else if ($type === "update") {

    // Receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer = filter_input(INPUT_POST, "trailer");
    $category = filter_input(INPUT_POST, "category");
    $lenght = filter_input(INPUT_POST, "lenght");
    $id = filter_input(INPUT_POST, "id");

    $movieData = $movieDao->findById($id);

    // Verifica se encontrou o filme
    if ($movieData) {

        // Verificar se o filme é do usuário
        if ($movieData->users_id === $userData->id) {

            // Validação mínima de dados
            if (!empty($title) && !empty($description) && !empty($category)) {

                // Edição do filme
                $movieData->title = $title;
                $movieData->description = $description;
                $movieData->trailer = $trailer;
                $movieData->category = $category;
                $movieData->lenght = $lenght;


                // Upload de imagem do filme
                if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                    $image = $_FILES["image"];
                    $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                    $jpgArray = ["image/jpeg", "image/jpg"];

                    // Checando tipo da imagem
                    if (in_array($image["type"], $imageTypes)) {

                        // Checa se imagem é jpg
                        if (in_array($image["type"], $jpgArray)) {
                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                        } else {
                            $imageFile = imagecreatefrompng($image["tmp_name"]);
                        }

                        // Gerando o nome da imagem
                        $movie = new Movie();

                        $imageName = $movie->imageGenerateName();

                        imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                        $movieData->image = $imageName;
                    } else {

                        $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
                    }
                }

                $movieDao->update($movieData);
            } else {

                $message->setMessage("Você precisa adicionar pelo menos: título, descrição e categoria!", "error", "back");
            }
        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");
        }
    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");
    }
} else {

    $message->setMessage("Informações inválidas!", "error", "index.php");
}
