<?php
require_once("templates/header.php");
require_once("models/User.php");

require_once("dao/UserDAO.php");

$user = new User();

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

$fullname = $user->getFullName($userData);

if ($userData->image == "") {
    $userData->image = "user.png";
}

?>

<div id="main-container">
    <div class="col md-12">
        <form action="<?php echo $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <div class="row">
                <div class="col md-4">
                    <h1><?php echo $fullname ?></h1>
                    <p class="page-description">Altere seus dados no formulário abaixo</p>
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome" value="<?= $userData->name ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite seu sobrenome" value="<?= $userData->lastname ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control disabled" id="email" readonly name="email" placeholder="Digite seu email" value="<?= $userData->email ?>">
                    </div>
                    <input type="submit" class="btn card-btn" value="Alterar">
                </div>
                <div class="col md-4">
                    <div class="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                    <div class="form-group">
                        <label for="image">Foto:</label>
                        <input type="file" class="form-control-file" name="image">
                    </div>
                    <div class="form-group">
                        <label for="bio">Sobre você:</label>
                        <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="Conte um pouco sobre você"><?= $userData->bio ?></textarea>
                    </div>
                </div>
            </div>
        </form>

        <form action="<?php echo $BASE_URL ?>user_process.php" method="POST" id="form-edit-password">
            <input type="hidden" name="type" value="changepassword">
            <div class="row">
                <div class="col md-4">
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua nova senha">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirme a senha:</label>
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirme sua nova senha">
                    </div>
                    <input type="submit" class="btn card-btn" value="Alterar senha">
                </div>   
            </div>
        </form>

      
    </div>
</div>
<?php

require_once("templates/footer.php");
?>