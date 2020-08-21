<div class="main">
    <div class="auth-form">
        <img src="images/movie-icon.png" style="width: 100px; height: 100px; text-align: center;">
        <h4 class="titre white">Join Movies Search Engine</h4>
        <?php
        $pre_email = "";
        $pre_first_name = "";
        $pre_last_name = "";
        if($message != ""){
            echo "<div class=\"alert alert-danger\" role=\"alert\">" . $message . "</div>";
            $pre_email = $_POST['email'];
            $pre_first_name = $_POST['firstname'];
            $pre_last_name = $_POST['lastname'];
        }
        ?>
        <div class="register-container flex-md-row mb-4 bg-dark">
            <form method='POST' action='index.php?MP=profile&r=true' name='formRegister' id='formRegister'
                  class='register'>

                <div class='ligne on-left'>
                    <label for="validationServer04" id='label email_lbl' class="white" >Email</label>
                    <input type='text' class='form-control' name='email' id='email' placeholder='Email' value="<?php echo $pre_email ?>" required/>
                </div>

                <div class='ligne on-left'>
                    <label id='label' class="white">First name</label>
                    <input type='text' class='form-control' name='firstname' id='firstname' placeholder='First Name' value="<?php echo $pre_first_name ?>" required/>
                </div>

                <div class='ligne on-left'>
                    <label id='label' class="white">Last name</label>
                    <input type='text' class='form-control' name='lastname' id='lastname' placeholder='Last Name' value="<?php echo $pre_last_name ?>" required/>
                </div>

                <div class='ligne on-left'>
                    <label id='label pass_lbl' class="white">Password</label>
                    <input class='form-control' type='password' name='password' id='password' placeholder='Password'
                           required min="5"/>
                </div>

                <div class='ligne on-left'>
                    <label id='label conf_lbl' class="white">Confirm Password</label>
                    <input class='form-control' type='password' name='conf-password' id='conf-password'
                           placeholder='Confirm password' required min="5"/>
                </div>
                <br>
                <div class='ligne'>
                    <input type='submit' name='register' id='register' value='Create an account'
                           class='btn btn-danger' disabled="disabled" />
                </div>
            </form>
        </div>
    </div>
</div>
<script src="script/signout.js"></script>