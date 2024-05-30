<?php
echo '<div class="offcanvas offcanvas-start bg-dark" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
aria-labelledby="offcanvasWithBothOptionsLabel" data-bs-theme="dark">
<div class="offcanvas-header">
    <h5 class="offcanvas-title text-light" id="offcanvasWithBothOptionsLabel">Sign up to Discussion-Dock</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body text-light">
    <p>Sign up to Discussion Dock to get exclusive contents.</p>
    <form class="text-light" id="registration_form" method="post" action="' . htmlspecialchars($_SERVER['REQUEST_URI']) . '">
    <input type="hidden" name="action" value="register">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" name="username"
                required>
                <div id="username_response" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="email_response" name="email" required>
            <div id="email_response" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div id="password_response" class="form-text"></div>

        </div>

        <button type="submit" class="btn btn-success" id="reg-btn"><b>Register</b></button>
    </form>
</div>
</div>';
