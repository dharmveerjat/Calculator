<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
$numberfirst = "";
$numbersecond = "";
$operator = "";
$result = "";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php require 'partials/_nav.php' ?>

    <div style="margin-top: 20px; margin-bottom: 20px; text-align: center;">

        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <label style="margin-top: 20px; margin-bottom: 20px; text-align: left;" for="numberfirst">Enter First
                Number:</label>
            <input type="number" id="numberfirst" name="numberfirst" required><br>
            <label for="numbersecond">Enter Second Number:</label>
            <input type="number" id="numbersecond" name="numbersecond" required><br>
            <label style="margin-top: 20px; margin-bottom: 20px; text-align: left;" for="operator">Choose an
                operation:</label>
            <select name="operator" id="operator">
                <option value="+">+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
            </select><br>
            <input type="submit" name="submit" value="Calculate">
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
            crossorigin="anonymous"></script>
</body>

</html>
<?php
if (isset($_POST["submit"])) {
    $numberfirst = $_POST["numberfirst"];
    $numbersecond = $_POST["numbersecond"];
    $operator = $_POST["operator"];
    if (!is_numeric($numberfirst) || !is_numeric($numbersecond) || empty($numberfirst) || empty($numbersecond)) {
        echo "Please enter valid numbers.";
    } else {
        switch ($operator) {
            case '+':
                $result = $numberfirst + $numbersecond;
                break;
            case '-':
                $result = $numberfirst - $numbersecond;
                break;
            case '*':
                $result = $numberfirst * $numbersecond;
                break;
            case '/':
                if ($numbersecond == 0) {
                    echo "Can't divide by zero.";
                } else {
                    $result = $numberfirst / $numbersecond;
                }
                break;
            default:
                echo "Invalid operation.";
                break;
        }
        ?>
        <div style="margin-top: 20px; margin-bottom: 20px; text-align: center;">
            <?php echo "<p>The result of {$numberfirst} {$operator} {$numbersecond} is {$result}.</p>"; ?>
        </div>
        <?php
    }
}
?>
</div>
