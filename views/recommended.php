<h1 class="titre" style="margin-bottom: 20px;">Recommendations</h1>
<div class="container">
    <?php
    echo "<div style=\"display: $display\">";
    ?>
        <div class='ligne'>
            <div class="search-container">
                <div class='input-group'>
                    <input type='text' class='form-control' name='search' id='search' placeholder='Filter'">
                </div>
            </div>
        </div>
        <p><span id="dynamic-counter"></span><?php echo $nb ?> Movies <b id="dynamic-search"></b></p>
        <p id="dynamic-redirect-container" style="display: none;">You don't find your movie ? You can add it to the
            catalogue by <a id="dynamic-redirect" href=''>searching for it</a>.</p>
        <hr>
    </div>
    <div class="filter-container container flex-md-row mb-4 box-shadow h-md-250 bg-dark">
        <p>Favorite <b>actors :</b></p>
        <hr>
        <?php
        $name = "";
        $i = 1;
        foreach ($actors as $actor) {
            $id = $actor->getId();
            $name = $actor->getName();
            switch ($i) {
                case 1 :
                    $style = "btn-warning";
                    break;
                case 2 :
                    $style = "btn-secondary";
                    break;
                case 3 :
                    $style = "btn-secondary btn-bronze";
                    break;
                default :
                    $style = "btn-outline-light";
                    break;
            }
            echo "<a href='?MP=Recommended&Type=actor&ID=$id'><button type=\"button\" class=\"filter-btn btn $style\">$name</button></a>";
            $i++;
        }
        ?>
    </div>
    <div class="filter-container container flex-md-row mb-4 box-shadow h-md-250 bg-dark">
        <p>Favorite <b>directors :</b></p>
        <hr>
        <?php
        $i = 1;
        foreach ($directors as $director) {
            $id = $director->getId();
            $name = $director->getName();
            switch ($i) {
                case 1 :
                    $style = "btn-warning";
                    break;
                case 2 :
                    $style = "btn-secondary";
                    break;
                case 3 :
                    $style = "btn-secondary btn-bronze";
                    break;
                default :
                    $style = "btn-outline-light";
                    break;
            }
            echo "<a href='?MP=Recommended&Type=director&ID=$id'><button type=\"button\" class=\"filter-btn btn $style\">$name</button></a>";
            $i++;
        }
        ?>
    </div>
    <div class="filter-container container flex-md-row mb-4 box-shadow h-md-250 bg-dark">
        <p>Favorite <b>genres :</b></p>
        <hr>
        <?php
        $i = 1;
        foreach ($genres as $genre) {
            $id = $genre->getId();
            $name = $genre->getName();
            switch ($i) {
                case 1 :
                    $style = "btn-warning";
                    break;
                case 2 :
                    $style = "btn-secondary";
                    break;
                case 3 :
                    $style = "btn-secondary btn-bronze";
                    break;
                default :
                    $style = "btn-outline-light";
                    break;
            }
            echo "<a href='?MP=Recommended&Type=genre&ID=$id'><button type=\"button\" class=\"filter-btn btn $style\">$name</button></a>";
            $i++;
        }
        ?>
    </div>

    <?php
    if (!empty($movies)) {
        echo "<p>Movies of </p><b>$name</b>";
        foreach ($movies as $movie) include "views/constant/movie-card.php";
    }
    require_once 'views/constant/scrollup.php';
    ?>

    <script>
        $(function () {
            var $cells = $(".movie-card");
            $("#search").keyup(function () {
                var original_val = $.trim(this.value)
                var val = original_val.toUpperCase();
                if (val === "") {
                    $cells.parent().show();
                    $("#dynamic-counter").text("");
                    $('#dynamic-search').text("");
                    $("#dynamic-redirect-container").hide();
                }
                else {
                    $cells.parent().hide();
                    var cards = $cells.filter(function () {
                        return -1 != $(this).text().toUpperCase().indexOf(val);
                    }).parent();
                    cards.show();
                    $("#dynamic-counter").text(cards.length + " / ");
                    $('#dynamic-search').text("for " + original_val);
                    $("#dynamic-redirect-container").show();
                    $("#dynamic-redirect").attr("href", ("?MP=search&S=" + original_val));
                }
            });
        });
    </script>