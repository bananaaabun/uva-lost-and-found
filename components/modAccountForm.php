<div class="fc center outline grow">
<h3>Account Details</h3>
<form id="login-form" method="post" action="?command=logout">
    <div class="form-group">
        <label for="username">Username</label>
        <?php echo "<input type=\"text\" class=\"form-control\" aria-describedby=\"username\" readonly placeholder=\"{$_SESSION["username"]}\">"; ?>
        <small id="emailHelp" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <?php echo "<input type=\"text\" class=\"form-control\" aria-describedby=\"emailHelp\" readonly placeholder=\"{$_SESSION["email"]}\">"; ?>
        <small id="emailHelp" class="form-text text-muted"></small>
    </div>
    <button type="submit" value="Submit" class="button-primary">Logout</button>
</form>
<hr>
</div>
<div class="fc outline grow">
    <h3>Change Username</h3>
    <form method="post" action="?command=newusername">
        <div class="form-group">
            <label for="username">New Username</label>
            <?php echo "<input name=\"username\" type=\"text\" class=\"form-control\" aria-describedby=\"username\" placeholder=\"{$_SESSION["username"]}\">"; ?>
            <small id="emailHelp" class="form-text text-muted"></small>
        </div>
        <button type="submit" value="Submit" class="button-primary">Change Username</button>
    </form>
</div>