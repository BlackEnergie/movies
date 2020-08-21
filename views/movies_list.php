<div class="container top">
<h1 class="titre">Movies catalogue</h1>
    <br><br>
    <?php echo $formSearch->afficherFormulaire();
    echo "<hr><p>$nbMovies results ";
    if (isset($_POST["searchMovies"])) {
        echo "for <b> $search </b>";
        echo "<p>You don't find your movie ? You can add it to the catalogue by <a href='?MP=search&S=$search'>searching for it</a>.</p>";
    }
    echo "</p>";
    ?>
</div>
<div class="container">
    <br>
    <div class="row mb-2">
        <?php
        if (!is_null($movies)) {
            foreach ($movies as $movie) {
                include 'views/constant/movie-card.php';
            }
        }
        ?>
    </div>
</div>

<?php
include_once "constant/pagination.php";
include_once 'constant/scrollup.php';
?>
