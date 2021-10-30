<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
    </style>
</head>


<body>
<div class="body_padded">
    <h1>Vulnerability: Cross Site Request Forgery (CSRF) - high</h1>
    <div class="vulnerable_code_area">
        <h3>Change your admin password:</h3> <br />
        <form action="3-1.CSRF-POST(server).php" method="POST">
            New password:<br />
            <input type="password" AUTOCOMPLETE="off" name="password_new"><br />
            Confirm new password:<br />
            <input type="password" AUTOCOMPLETE="off" name="password_conf"><br /> <br />
            <input type="submit" value="Change" name="Change">

        </form>
    </div>
</body>
</html>




