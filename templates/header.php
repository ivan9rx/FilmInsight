<?php
require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");

$message = new Message($BASE_URL);

$flashMessage = $message->getMessage();

if (!empty($flashMessage["msg"])) {
    //limpa a menssagem
    $message -> clearMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmInsight</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.css" integrity="sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="icon" href="<?php echo $BASE_URL; ?>img/logo.svg" />
    <link rel="stylesheet" href="<?php echo $BASE_URL; ?>css/styles.css" />
</head>

<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="<?php echo $BASE_URL; ?>" class="navbar-brand">
                <img src="<?php echo $BASE_URL; ?>img/logo.svg" alt="" id="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="toggle navigation"><i class="fas fa-bars"></i></button>
            <form action="" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
                <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar filmes" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?php echo $BASE_URL; ?>auth.php" class="nav-link">Entrar / Cadastrar</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <?php if (!empty($flashMessage["msg"])): ?>
        <div class="msg-container">
            <p class='msg <?php echo htmlspecialchars($flashMessage["type"]); ?>'>
                <?php echo htmlspecialchars($flashMessage["msg"]); ?>
            </p>
        </div>
    <?php endif; ?>