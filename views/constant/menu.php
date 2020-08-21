<?php
$menu = array();

$menu[] = "Home";
$menu[] = "Search";
$menu[] = "Catalogue";

if(isset($_SESSION['user'])){
    $menu[] = "Recommended";
    $menu[] = "My list";
}

$html_menu = "<ul class=\"navbar-nav mr-auto\">";

foreach ($menu as $tab){
    $html_menu .= "<li class=\"nav-item\" id=\"$tab\">
                        <a class=\"nav-link\" href=\"?MP=$tab\">$tab</a>
                    </li>";
}

$html_menu .= "</ul>";

echo $html_menu;
