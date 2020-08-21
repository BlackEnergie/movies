<h1 class="titre" style="margin-bottom: 20px;">My list</h1>
<div class="container">
    <div class='ligne'>
        <div class="search-container">
            <div class='input-group'>
                <input type='text' class='form-control' name='search' id='search' placeholder='Search'">
            </div>
        </div>
    </div>
    <p><span id="dynamic-counter" ></span><?php echo $nb ?> Movies <b id="dynamic-search"></b></p>
    <p id="dynamic-redirect-container" style="display: none;">You don't find your movie ? You can add it to the catalogue by <a id="dynamic-redirect" href=''>searching for it</a>.</p>
    <hr>
    <?php
    if (!is_null($movies)) {
        foreach ($movies as $movie) {
            include 'views/constant/movie-card.php';
        }
        require_once 'views/constant/scrollup.php';
    } ?>s
</div>
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