<h1 class="titre">Save a movie from a precise title</h1>
<?php
$formSearch->afficherFormulaire();

echo "<div class='movie-container'>";
if (!is_null($movie)) {
    echo "<img src='" . $movie->getPoster() . "' class='poster'>";
    echo "<ul><li><b>Title : </b>" . $movie->getTitle() . "</li>";
    echo "<li><b>IMDB ID : </b>" . $movie->getImdbID() . "</li>";
    echo "<li><b>Year : </b>" . $movie->getYear() . "</li>";
    echo "<li><b>Director : </b>" . $movie->getDirector() . "</li>";
    echo "<li><b>Genre : </b>" . $movie->getGenre() . "</li>";
    echo "<li><b>Actors : </b>" . $movie->getActors() . "</li>";
    echo "<li><b>Country : </b>" . $movie->getCountry() . "</li>";
    echo "<li><b>IMDB Rating : </b>" . $movie->getImdbRating() . "</li>";
    echo "<li><b>Box office : </b>" . $movie->getBoxOffice() . "</li>";
    echo "<li><b>Plot : </b>" . $movie->getPlot() . "</li>";
}
echo "</div>";
$formSave->afficherFormulaire();
?>

<script>
    document.getElementById("title").focus();
    document.getElementById("save").focus();
</script>