<div class="modal" id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login to Discussion Dock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="login-form" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                    <input type="hidden" name="action" value="login">
                    <div class="mb-3">
                        <label for="email-login" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email-login" name="email-login" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="password-login" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password-login" name="password-login" required>
                        <div id="password-login_response" class="form-text"></div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary button-56" id="login-btn"> Login </button>

            </div>
            </form>
        </div>
    </div>
</div>