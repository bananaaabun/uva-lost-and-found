<div class="fc center outline">
    <img src="assets/logo.png" style="width: 200px;" alt="logo">
    <hr>
    <h2>Login or Create Account</h2>
    <hr>
    <form id="login-form" method="post" action="?command=login">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Enter username">
            <small id="emailHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <button type="submit" value="Submit" class="button-primary">Submit</button>
    </form>
</div>