<?php
$poster = $movie->getPoster();
$title = $movie->getTitle();
$year = $movie->getYear();
$genre = $movie->getGenre();
$country = $movie->getCountry();
$runtime = $movie->getRuntime();
$plot = $movie->getPlot();
$actors = $movie->getActorsText();
$director = $movie->getDirector()->getName();
$imdbID = $movie->getImdbID();
$imdbRating = $movie->getImdbRating();

if ($imdbRating == 0) $imdbRating = "Not rated";
if ($poster == "N/A") $poster = 'images/no_poster.png';

echo "
<div class=\"card flex-md-row mb-4 box-shadow h-md-250 bg-dark\">
    <div class='movie-card'>
        <div class='poster-container'>
            <img class=\"poster card-img-left flex-auto d-none d-md-block \" data-src=\"holder.js/200x250?theme=thumb\" style=\"width: 168px; height: 250px;\" src='$poster' data-holder-rendered=\"true\">
        </div>
        <div class=\"card-body d-flex flex-column align-items-start\">
            <div class='movie-prod'>
              <div>
                <h2><strong class=\"d-inline-block mb-2\">$title</strong></h2>
                    <div class=\"mb-1 text-muted year\">
                        <h5 class='rating' data-toggle=\"tooltip\" data-placement=\"left\" title=\"Imdb Rating\">
                            <strong>$imdbRating </strong><i style='color :#fbc81e;' class=\"material-icons\">star</i>
                        </h5>
                        <h6 style='color: #c34b3b !important;'>$year </h6>
                    </div>
                </div>
                <br>
                <div>
                <p class=\"card-text mb-auto\"><b>Director :</b> $director</p>
                <p class=\"card-text mb-auto\"><b>Genre :</b> $genre</p>
                <p class=\"card-text mb-auto\"><b>Country :</b> $country</p>
                <p class=\"card-text mb-auto\"><b>Runtime :</b> $runtime min</p>
                <p class=\"card-text mb-auto\"><b>Actors :</b> $actors</p>
                <br>
                <p class=\"card-text mb-auto\"><b>Plot :</b> $plot</p></div>
                <div class='form-selection'>";

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    if (selectionDAO::checkMovieSelection($user->getId(), $movie->getImdbId()) == 0) {
        echo "<form id='form-$imdbID'>
                    <button class='btn' id='submit-$imdbID' data-toggle=\"tooltip\" data-placement=\"left\" title=\"Add to my list\" style='background-color : royalblue ;position: absolute; bottom: 20px; border-radius: 100%; width: 26px !important; height: 26px !important;' >
                    <i id='add-$imdbID add-button' style='cursor: pointer; position: absolute;top: 0px; left: 0px; color: black' class=\"material-icons\">add</i></button></form>";
    } else
        echo "<form id='form-$imdbID'>
                    <button class='btn btn-danger' id='submit-$imdbID' data-toggle=\"tooltip\" data-placement=\"left\" title=\"Remove from my list\" style='position: absolute; bottom: 20px; border-radius: 100%; width: 26px !important; height: 26px !important;' >
                    <i id='add-$imdbID add-button' style='cursor: pointer; position: absolute;top: 0px; left: 0px; color: black' class=\"material-icons\">clear</i></button></form>";
}
echo "</div></div></div></div></div>";


if (isset($_SESSION['user'])) {
// Selection ajax caller

    $imdbID = $movie->getImdbID();
    echo "
            <script>
            $(document) . ready(function () {
                $(\"#submit-$imdbID\").click(function(e) {
        e.preventDefault();
        var button = document.getElementById('submit-$imdbID');
            button.disabled = 'disabled'
            button.style.backgroundColor = 'orange'
            button.innerHTML = \" <i id='add-$imdbID add-button' style ='cursor: pointer; position: absolute;top: -1px; left: 0px; color: black' class='material-icons'>sync</i> \"
        $.ajax({
        url : 'controllers/JQuery/addToSelection.php',
        type : 'POST',
        data : 'imdbID=' + '$imdbID' ,
        success : function (result){
            var res = JSON.parse(result);
            if(res.Res === \"1\"){
                button.style.backgroundColor = 'green'
                button.innerHTML = \"<i id='add-$imdbID add-button' style='cursor: pointer; position: absolute;top: -1px; left: 0px; color: black' class='material-icons'>check</i> \"
                window.navigator.vibrate(50);
            } else{
                button.disabled = '';
                button.style.backgroundColor = 'orange';
                button.setAttribute('data-original-title', 'Internal failure, try again')
                button.innerHTML = \" <i id ='add-$imdbID add-button' style ='cursor: pointer; position: absolute;top: -1px; left: 0px; color: black' class='material-icons'> sync</i> \"
                window.navigator.vibrate([50, 0, 50]);
            }
        }
        });
    });
});</script> ";
}