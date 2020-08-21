<?php
$previous = $page - 1;
$next = $page + 1;
if (!is_null($page)) {
    echo "<div aria-label='Page movies'>
  <ul class='pagination justify-content-center'>";
    if ($page != 1) // Si on est pas sur la première page on met le boutton précédent
        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?MP=catalogue&page=" . $previous . "\"><span aria-hidden=\"true\">&laquo;</span>
        <span class=\"sr-only\">Previous</span></a></li>";
    if ($page <= 2 || $page + 1 >= $nbPages) { // Si la page est une des deux premières ou une des deux dernières
        for ($i = 1; $i <= 2; $i++) { // On afficbe les deux premières
            if ($i == $page) {
                echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">$i <span class=\"sr-only\">(current)</span></a></li>";
            } else
                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?MP=catalogue&page=$i\" >$i</a></li>";
        }
        echo "<li class=\"page-item\"><a class=\"page-link\">...</a></li>";
        for ($i = $nbPages - 1; $i <= $nbPages; $i++) { // On affiche les deux dernières
            if ($i == $page) {
                echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">$i<span class=\"sr-only\">(current)</span></a></li>";
            } else
                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?MP=catalogue&page=$i\" >$i</a></li>";
        }
    } else { // Si on est au milieu des pages disponibles
        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?MP=catalogue&page=1\" >1</a></li>";
        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?MP=catalogue&page=2\" >2</a></li>";

        echo "<li class=\"page-item\"><a class=\"page-link\">...</a></li>";

        echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">$page<span class=\"sr-only\">(current)</span></a></li>";

        echo "<li class=\"page-item\"><a class=\"page-link\">...</a></li>";

        for ($i = $nbPages - 1; $i <= $nbPages; $i++) {
            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?MP=catalogue&page=$i\" >$i</a></li>";
        }
    }
    if ($page != $nbPages) // Si la page n'est pas la dernière
        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?MP=catalogue&page=" . $next . "\"><span aria-hidden=\"true\">&raquo;</span>
        <span class=\"sr-only\">Next</span></a></li>";

    echo "</ul></div>";
}


?>
