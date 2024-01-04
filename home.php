<?php
    if($_SESSION['loggedin'] != 1) {
?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
        Zur Nutzung des Services m&uuml;ssen die IP Adressen <kbd>89.58.51.156</kbd> und <kbd>2a03:4000:68:5e:c862:a3ff:fe53:3311</kbd> in der <kbd>query_ip_whitelist.txt</kbd> oder <kbd>query_ip_allowlist.txt</kbd> der jeweiligen Teamspeak Instanz hinterlegt sein.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <main class="form-signin text-center">
        <form method="post" action="index.php?site=login">
            <img class="mb-4" src="images/header/motd_2015_clear_back_small.png" alt="">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
            <input type="text" class="form-control" id="login_ts3ip" name="login_ts3ip" placeholder="1.2.3.4">
            <label for="login_ts3ip">Teamspeak IP</label>
            </div>
            <div class="form-floating">
            <input type="text" class="form-control" id="login_ts3queryport" name="login_ts3queryport" placeholder="10011">
            <label for="login_ts3queryport">Queryport</label>
            </div>
            <div class="form-floating">
            <input type="text" class="form-control" id="login_username" name="login_username" placeholder="serveradmin">
            <label for="login_username">Username</label>
            </div>
            <div class="form-floating">
            <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Password">
            <label for="login_password">Password</label>
            </div>

            <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; <?php echo date("Y"); ?></p>
        </form>
    </main>
<?php
    } else {
?>
    <div class="bg-light p-5 rounded">
        <img class="mb-2 img-fluid" src="images/header/motd_2015_clear_back.png" alt="">
        <p class="lead">
            Teamspeak Webinterface - control everything, everywhere
        </p>
    </div>
<?php
    }
?>