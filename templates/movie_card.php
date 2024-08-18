

<?php 
if(empty($movie->image)) {
    $movie->image = "movie_cover.jpg";
}

?>

<div class="card movie-card">
    <div class="card-img-top" style="background-image: url('<?php echo $BASE_URL; ?>img/movies/<?= $movie->image ?>')"></div>
    <div class="card-body">
        <p class="card-rating">
            <i class="fas fa-star"></i>
            <span class="rating">9</span>
        </p>
        <h5 class="card-title"><a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>"><?= $movie->title ?></a></h5>
        <div style="display: flex; flex-direction: column;">
            <a href="#" class="btn btn-primary rate-btn">Avaliar</a>
            <a href="#" class="btn btn-primary card-btn">Conhecer</a>
        </div>
    </div>
</div>