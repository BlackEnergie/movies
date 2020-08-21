<div class="main">
    <div class="auth-form">
        <img src="images/movie-icon.png" style="width: 100px; height: 100px; text-align: center;">
        <h4 class="titre white">Sign in</h4>
        <?php
        if ($error) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">Incorrect email or password.</div>";
        }
        ?>
        <div class="register-container flex-md-row mb-4 bg-dark">
            <form method='POST' action='index.php?MP=profile' name='formConnect' id='formConnect' class='connect'>
                <div class='ligne on-left'>
                    <label id='label' class="white">Email</label>
                    <?php
                        echo "<input type='text' class='form-control' name='email' id='email' placeholder='Email' value= '$email' required/>";
                    ?>
                </div>
                <div class='ligne on-left'>
                    <label id='label' class="white">Password</label>
                    <input class='form-control' type='password' name='password' id='password' placeholder='Password' required/>
                </div>
                <br>
                <div class='ligne'>
                    <input type='submit' name='connect' id='connect' value='Login' class='btn btn-danger'/>
                </div>
            </form>
        </div>
        <div class="register alert alert-dark" role="alert">
            New to Movies Search Engine? <br> <a href="index.php?MP=profile&r=true">Create an account.</a>
        </div>
        <?php
        if ($error) {
            echo "<div class=\"register alert alert-dark\" role=\"alert\"> Forgot password ? <a href='index.php?MP=forgotPassword'>Reset it</a> </div>";
        }
        ?>
    </div>
</div>