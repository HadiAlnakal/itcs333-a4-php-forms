<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/validate.php';

$name = "";
$email = "";
$message = "";

$nameError = "";
$emailError = "";
$messageError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["name"]) && is_string($_POST["name"])) {
        $name = $_POST["name"];
    }

    if (isset($_POST["email"]) && is_string($_POST["email"])) {
        $email = $_POST["email"];
    }

    if (isset($_POST["message"]) && is_string($_POST["message"])) {
        $message = $_POST["message"];
    }

    if (!validate_required($name)) {
        $nameError = "Name is required.";
    }
    else if (!validate_length($name, 2, 60)) {
        $nameError = "Name must be between 2 and 60 characters.";
    }

    if (!validate_email($email)) {
        $emailError = "Invalid email address.";
    }

    if (!validate_required($message)) {
        $messageError = "Message is required.";
    }
    else if (!validate_length($message, 10, 1000)) {
        $messageError = "Message must be between 10 and 1000 characters.";
    }

    if ($nameError == "" && $emailError == "" && $messageError == "") {
        header("Location: index.php?success=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Us</title>
</head>
<body>

    <h1>Contact Us</h1>

    <?php
    if (isset($_GET["success"]) && $_GET["success"] === "1") {
        echo "<p>Message sent successfully!</p>";
    }
    ?>

    <form method="post" action="index.php" novalidate>

        <label>Name
            <input type="text" name="name"
                   value="<?php echo htmlspecialchars($name); ?>">
        </label>
        <span><?php echo htmlspecialchars($nameError); ?></span>
        <br>

        <label>Email
            <input type="email" name="email"
                   value="<?php echo htmlspecialchars($email); ?>">
        </label>
        <span><?php echo htmlspecialchars($emailError); ?></span>
        <br>

        <label>Message
            <textarea name="message"><?php echo htmlspecialchars($message); ?></textarea>
        </label>
        <span><?php echo htmlspecialchars($messageError); ?></span>
        <br>

        <button type="submit">Send</button>

    </form>

</body>
</html>