<nav class="navbar navbar-expand-lg navbar-dark ">
    <a class="navbar-brand" href="?MP=home">
        <img src="images/movie-icon.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Movies search engine </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <?php
            require_once "menu.php";
        ?>
        <a href="?MP=profile" style="text-decoration: none;" >
            <?php
            require_once 'model/dto/user.php';
            if(isset($_SESSION['user'])){
                $user = new User();
                $user = unserialize($_SESSION['user']);
                echo "<p class='font-weight-bold' style='display: inline-block; vertical-align: super; margin-right: 5px;'>" . $user->getFirstName() . "</p>";
            }
            ?>
            <span class="navbar-text">
                <i class="material-icons" id="profile" style="width: 40px; color: white;">account_circle</i>
            </span>
        </a>
    </div>
</nav>