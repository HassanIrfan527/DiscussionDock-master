$(document).ready(function () {
    const btn = document.getElementById('reg-btn');

    $('#username').blur(function () {
        var username = $(this).val();
        // var form = document.getElementById('registration_form');
        $.ajax({
            url: 'utils/_username_check.php',
            type: 'post',
            data: {
                username: username
            },
            success: function (response) {
                if (response === '<span style="color: red;">Username already exists.</span>' || response === '<span style="color: red;">Username must be greater than 5 characters.</span>') {
                    btn.setAttribute('disabled', 'true')
                    $('#username_response').html(response);
                } else {
                    btn.removeAttribute('disabled')
                    $('#username_response').html(response);

                }



            }
        });
    });
    $('#registration_form #password').focus(function () {
        btn.setAttribute('disabled', 'true')
    });


    $('#registration_form #password').blur(function () {
        btn.removeAttribute('disabled')
    });
});

$(document).ready(function () {
    $('#email').blur(function () {
        var email = $(this).val();
        const btn = document.getElementById('reg-btn');
        $.ajax({
            url: 'utils/_username_check.php',
            type: 'post',
            data: {
                email: email
            },
            success: function (response) {
                if (response === '<span style="color: red;">Another account is created with this email</span>') {
                    btn.setAttribute('disabled', 'true');
                    $('#email_response').html(response);

                } else {
                    btn.removeAttribute('disabled')
                    $('#email_response').html(response);

                }
            }
        });
    });
});

$(document).ready(function () {
    $('#password').blur(function () {
        var password = $(this).val();
        const btn = document.getElementById('reg-btn');
        $.ajax({
            url: 'utils/_username_check.php',
            type: 'post',
            data: {
                password: password
            },
            success: function (response) {
                if (response === '<span style="color: red;">Password should be at least 8 characters.</span>') {
                    btn.setAttribute('disabled', 'true');
                    $('#password_response').html(response);

                } else {
                    btn.removeAttribute('disabled')
                    $('#password_response').html(response);

                }
            }
        });
    });
});

$(document).ready(function () {
    const btn = document.getElementById('login-btn');

    $('#password-login').blur(function () {
        var password = $(this).val();
        var email = $(document.getElementById('email-login')).val();
        $.ajax({
            url: 'utils/_login_cred_check.php',
            type: 'post',
            data: {
                email: email,
                password: password
            },
            success: function (response) {
                if (response === '<span style="color: red;">Incorrect Password</span>') {
                    btn.setAttribute('disabled', 'true');
                    $('#password-login_response').html(response);
                    console.log(btn)
                } else {
                    btn.removeAttribute('disabled')
                    $('#password-login_response').html(response);

                }
            }
        });
    });
});

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

