
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePassword(pass,valid){
    return (pass === valid && pass !== "");
}

pass = document.getElementById('password');
label_pass = document.getElementById("label pass_lbl");
conf = document.getElementById('conf-password');
label_conf = document.getElementById("label conf_lbl");
sub = document.getElementById("register");
email = document.getElementById("email");
label_email = document.getElementById("label email_lbl");

var res_email;
var res_password;

email.addEventListener("input", function () {
    res_email = validateEmail(email.value);
    if (res_email) {
        email.className = "form-control is-valid";
        label_email.className = "white";
    } else {
        email.className = "form-control is-invalid";
        label_email.className = "red";
    }
    if(res_email === res_password){
        sub.disabled = "";
    }else{
        sub.disabled = "disabled";
    }
});

conf.addEventListener("input", function () {
    res_password = validatePassword(pass.value,conf.value);
    if(res_password){
        pass.className = "form-control is-valid";
        label_pass.className = "white";
        conf.className = "form-control is-valid";
        label_conf.className = "white";
    }else{
        pass.className = "form-control is-invalid";
        label_pass.className = "red";
        conf.className = "form-control is-invalid";
        label_conf.className = "red";
    }
    subVisibility();
});

pass.addEventListener("input", function () {
    res_password = validatePassword(pass.value,conf.value);
    if(res_password){
        pass.className = "form-control is-valid";
        label_pass.className = "white";
        conf.className = "form-control is-valid";
        label_conf.className = "white";
    }else{
        pass.className = "form-control is-invalid";
        label_pass.className = "red";
        conf.className = "form-control is-invalid";
        label_conf.className = "red";
    }
    subVisibility();
});

function subVisibility() {
    if(res_email !== false && res_email === res_password){
        sub.disabled = "";
    }else{
        sub.disabled = "disabled";
    }
}