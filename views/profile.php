<?php
$user = new User();
$user = unserialize($_SESSION['user']);
echo "<h1 class=\"titre\">Hi there, <b>" .  $user->getFirstName() . "</b> !</h1>
      <div class=\"container\">";
?>
<a href="?MP=disconnect"><input type="button" class="btn btn-danger" value="Disconnect"></a>
<a href="?MP=changePassword"><input type="button" class="btn btn-danger" value="Change Password"></a>
