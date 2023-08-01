<!--Exercitiul 3-->
<?php
session_start();

if (isset($_POST['register'])) {
    registerUser($_POST['username'], $_POST['password']);
}

if (isset($_POST['login'])) {
    $result = loginUser($_POST['username'], $_POST['password']);
    if ($result === true) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: tema3.php");
        exit();
    } else {
        $loginError = $result;
    }
}

function registerUser($username, $password) {
    $credentials = file_get_contents('users.txt');
    if ($credentials === false) {
        $credentials = '';
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $userEntry = $username . ':' . $hashedPassword . "\n";
    $credentials .= $userEntry;

    file_put_contents('users.txt', $credentials, FILE_APPEND);
}

function loginUser($username, $password) {
    $credentials = file_get_contents('users.txt');
    $users = explode("\n", $credentials);

    foreach ($users as $user) {
        list($storedUsername, $hashedPassword) = explode(':', $user);
        if ($username === $storedUsername && password_verify($password, $hashedPassword)) {
            return true; 
        }
    }

    return "Invalid username or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
Exercitiul 1.
<br>
<form action="tema3.php" method="post">
    Num1: <br>
    <input type="number" name="num1"><br>
    OP: <br>
    <input type="textbox" name="operator"><br>
    Num2: <br>
    <input type="number" name="num2"><br>
    <input type="submit">
</form>
<br><br>
<?php
if (isset($_POST["num1"]) && isset($_POST["num2"]) && isset($_POST["operator"])) {
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];
    $operator = $_POST["operator"];

    switch ($operator) {
        case "+":
            echo $num1 + $num2;
            break;
        case "-":
            echo $num1 - $num2;
            break;
        case "*":
            echo $num1 * $num2;
            break;
        case "/":
            echo $num1 / $num2;
            break;
        default:
            echo "Invalid operator.<br>";
            break;
    }
}
?>
<br><br><br>
Exercitiul 3.
<br>
<h1>User Registration</h1>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="register" value="Register">
    </form>

    <h1>User Login</h1>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="login" value="Login">
    </form>

    <?php if (isset($loginError)) { ?>
        <p><?php echo $loginError; ?></p>
    <?php } ?>
<br><br><br>
</body>
</html>