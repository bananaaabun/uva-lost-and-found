<script>
    document.getElementById('login-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission until validation is complete

        const email = document.getElementById('email').value;
        const username = document.getElementById('username').value;
        
        const emailError = validateEmail(email);
        const usernameError = validateUsername(username);

        // Clear previous error messages
        document.getElementById('emailHelp').textContent = '';
        document.getElementById('userName').textContent = '';

        // Check for errors and display them
        if (emailError || usernameError) {
            if (emailError) {
                document.getElementById('emailHelp').textContent = emailError;
            }
            if (usernameError) {
                document.getElementById('userName').textContent = usernameError;
            }
        } else {
            // If no errors, submit the form
            document.getElementById('login-form').submit();
        }
    });

    const validateEmail = (email, regex = "") => {
        const check1 = /^[\w\-\+]+(\.[\w\-\+]+)*@[a-zA-Z\d\-]+(\.[a-zA-Z\d\-]+)+$/;
        if (!check1.test(email)) {
            return "Invalid email format.";
        }
        if (regex !== "" && !new RegExp(regex).test(email)) {
            return "Email does not meet the specific criteria.";
        }
        return "";
    };

    const validateUsername = (username) => {
        const check = /.+/; // Any character or more
        if (!check.test(username)) {
            return "Username cannot be empty.";
        }
        return "";
    };
</script>

<div class="fc center outline">
    <img src="assets/logo.png" style="width: 200px;" alt="logo">
    <hr>
    <h2>Login or Create Account</h2>
    <hr>
    <form id="login-form" method="post" action="?command=login" >
        <div class="form-group">
            <label for="username">Username</label>
            <?php if (empty($_COOKIE["username"])) { ?>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="userName"
                    placeholder="Enter username">
            <?php } else {
                echo "<input type=\"text\" class=\"form-control\" name=\"username\" id=\"username\" aria-describedby=\"userName\" value=\"{$_COOKIE["username"]}\">";
            } ?>
            <small id="userName" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <?php if (empty($_COOKIE["email"])) { ?>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                    placeholder="Enter email">
            <?php } else {
                echo "<input type=\"email\" class=\"form-control\" id=\"email\" name=\"email\" aria-describedby=\"emailHelp\" value=\"{$_COOKIE["email"]}\" >";
            } ?>
            <small id="emailHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <button type="submit" value="Submit" class="button-primary">Submit</button>
    </form>
</div>