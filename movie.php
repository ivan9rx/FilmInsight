<?php
require_once("templates/header.php");
require_once("models/Movie.php");

require_once("dao/MovieDAO.php");

$id = filter_input(INPUT_GET, "id");

$movie;

$movieDao = new MovieDAO($conn, $BASE_URL);

if (empty($id)) {
    $message->setMessage("O filme não foi encontrado", "error", "index.php");
} else {
    $movie = $movieDao->findById($id);

    if (!$movie) {
        $message->setMessage("O filme não foi encontrado", "error", "index.php");
    }
}

if ($movie->image == "") {
    $movie->image = "movie_cover.jpg";
}

$userOwnsMovie = false;

if (!empty($userData)) {
    if ($userData->id ===  $movie->users_id) {
        $userOwnsMovie = true;
    }
}

$alreadyReviewd = false;

?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 movie-container">
            <h1 class="page-title"><?= $movie->title ?></h1>
            <p class="movie-details">
                <span>Duração: <?= $movie->lenght ?></span>
                <span class="pipe">/</span>
                <span>Categoria: <?= $movie->lenght ?></span>
                <span class="pipe">/</span>
                <spanp><i class="fas fa-star"></i> 9</span>
            </p>

            <iframe src="<?= $movie->trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture;" allowfullscreen></iframe>

            <p><?= $movie->description ?></p>

        </div>

        <div class="col-md-4">
            <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>/img/movies/<?= $movie->image ?>');"></div>
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações: </h3>

            <?php if(!empty($userData) && !$userOwnsMovie && !$alreadyReviewd):?>



            <div class="col-md-12" id="review-form-container">
                <h4>Envie sua avaliação:</h4>

                <p class="page-description">Preencha o formulário com a nota e o comentário sobre o filme</p>

                <form action="<?= $BASE_URL ?>review_process.php" method="POST" id="review-form-id">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="movies_id" value="<?= $movie->id ?>">

                    <div class="form-group">
                        <label for="rating">Nota do filme: </label>
                        <select name="rating" class="form-control" id="rating">
                            <option value="">Selecione</option>
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                        <div class="form-group">
                            <label for="review">Sua review do filme:</label>
                            <textarea name="review" id="review" rows="3" class="form-control" placeholder="O que você achou do filme"></textarea>
                        </div>
                        <input type="submit" name="" id="" class="btn card-btn" value="Enviar comentário">
                    </div>

                </form>

            </div>

            <?php endif;?>

            <div class="col-md-12 review">
                <div class="row">
                    <div class="col-md-2">

                        <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/user.png');">
                        </div>

                        <div class="col-md-9 author-details-container">
                            <h4 class="author-name"><a href="#">ivan Teste</a></h4>
                            <p><i class="fas fa-star"></i> 9</p>
                        </div>

                        <div class="col-md-12">
                            <p class="comment-title">Comentário: </p>
                            <p>Este é meu comentário do</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">

                        <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/user.png');">
                        </div>

                        <div class="col-md-9 author-details-container">
                            <h4 class="author-name"><a href="#">ivan Teste</a></h4>
                            <p><i class="fas fa-star"></i> 9</p>
                        </div>

                        <div class="col-md-12">
                            <p class="comment-title">Comentário: </p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint eius quibusdam at pariatur labore, perspiciatis molestiae, sed itaque vel quae eos? Voluptatum iure maiores eaque quibusdam adipisci dicta at accusamus?</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once("templates/footer.php");


?>