<?php
require_once 'templates/header.php';

$db = new PDO("mysql:host=localhost;dbname=practice_security", "root", "");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    $query =("SELECT username,password, credit_card_number FROM userdata WHERE username=:username");
    $statement = $db->prepare($query);
    $statement->bindParam(':username', $username);
    // $statement->bindParam(':password', $password);
    $statement->execute();

    $user = $statement->fetch();

    if (!$user) {
        echo "User does not exist";
    } else {
        if ($password !== $user['password']) {
            echo '<div class="text-danger">Wrong username or password!</div>';
        } else {
            echo '<div class="card m-3">
                <div class="card-header">
                    <span>' . $user['username'] . '</span>
                </div>
                <div class="card-body">
                    <p class="card-text">Your credit card number: ' . $user['credit_card_number'] . '</p>
                </div>
            </div>
            <hr>';
        }
    }
}
?>

<form action="" method="post" class="m-3">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Username" name="username">
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter password" name="password">
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">View your data</button>
    </div>
</form>

<?php
require_once 'templates/footer.php';
?>