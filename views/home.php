<?php
$msg = "<h3>Welcome on <b>Movies search engine !</b></h3>
        <h5>This project was made for people who want to discover new movies related to their preferences.</h5>
        <p>It is using the <a target='_blank' href='http://www.omdbapi.com/'>Omdb API</a> to find the movies information. <br>
        <b>If you don't find a movie in the catalogue you can search for it <a href='?MP=search'>right here</a>.<br>
        It will be automatically added to our database !</b></p><hr>";

if(isset($_SESSION["user"])){
    $msg .= "<p>You can now manage your movies as you want ! <br> Complete <a href='?MP=My%20list'>your selection</a>  with your favorite movies and discover new ones with our <a href='?MP=Recommended'>personalised recommendations.</a></p><br>";
    $msg .= "<p><i>PS : We are learning from what you like so don't be shy and complete your list ;) </i></p>";
}else{
    $msg .= "<p>To have a complete experience, please <a href=\"?MP=profile\">connect</a> or <a href=\"?MP=profile&r=true\">create your account !</a></p>";
}

echo "
<h1 class=\"titre\">Movies search engine</h1>
<div class=\"text-center\">
    <img src=\"images/movie-icon.png\" style=\"width: 100px; height: 100px;\">
    <div class='container flex-md-row mb-4 box-shadow h-md-250 bg-dark' style='margin-top : 15px; padding: 20px; border-radius: 15px; color: whitesmoke;'>
          $msg
    </div>
</div>
";