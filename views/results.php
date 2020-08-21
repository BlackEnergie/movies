<h1 class="titre" style="margin-bottom: 20px;">Search a movie</h1>
<div class="container">
    <form method='post' action='index.php?MP=Search' name='searchMultipleByTitle' id='searchMultipleByTitle' class='contentRecherche'>
        <div class='ligne'>
            <div class="search-container">
                <div class='input-group'>
                    <input type='text' class='form-control' name='titleMultiple' id='titleMultiple' placeholder='Title' required >
                    <div class="input-group-append">
                        <input class="btn btn-outline-danger" type="submit" value='Search'/>
                    </div>
                </div>
            </div>
            <div class='loader-container'>
                <div class='loader'></div>
            </div>
        </div>
    </form>

    <p>

    <?php

    if (isset($search)) {
        echo "Results for <b> " . $search . "</b>";
    }
    echo "</p>";
    echo "<br><div class=\"row mb-2\">";

    if (isset($movies_results)) {
        foreach ($movies_results as $movie) {
            include 'views/constant/movie-card.php';
        }
    }

    echo "</div>";

    // Scrollup button
    include_once 'constant/scrollup.php';
    ?>
        <!-- Loader -->
        <script src="script/loader.js"></script>


