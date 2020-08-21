<div class="main">
    <div class="auth-form">
        <img src="images/movie-icon.png" style="width: 100px; height: 100px; text-align: center;">
        <h4 class="titre white">Forgot password</h4>
        <div class="register-container flex-md-row mb-4 bg-dark">
            <form method='POST' action='index.php?MP=forgotPassword' name='formForgot' id='formForgot' class='connect'>
                <div class='ligne on-left'>
                    <label id='label' class="white">Email</label>
                    <input type='text' class='form-control' name='email' id='email' placeholder='Email' required/>
                </div>
                <br>
                <div class='ligne'>
                    <input type='submit' name='forgot' id='forgot' value='Reset password' class='btn btn-danger'/>
                </div>
            </form>
        </div>
        <div class="register alert alert-dark" role="alert">
            If you have a <i>Movies search engine account</i>, you are going to receive an email to reset your password.
        </div>
    </div>
</div>