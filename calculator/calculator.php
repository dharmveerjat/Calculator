<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

$cookie_name1 = "num";
$cookie_value1 = "";
$cookie_name2 = "op";
$cookie_value2 = "";
$num = "";
$result = "";
$history = isset($_SESSION['history']) ? $_SESSION['history'] : [];

if (isset($_POST['num'])) {
    // If a number button is pressed, append it to the input
    $num = $_POST['input'] . $_POST['num'];
} elseif (isset($_POST['op'])) {
    // If an operator button is pressed, save the current input and operator
    $cookie_value1 = $_POST['input'];
    setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/");

    $cookie_value2 = $_POST['op'];
    setcookie($cookie_name2, $cookie_value2, time() + (86400 * 30), "/");
    // Reset the input to start a new number entry
    $num = "";
} elseif (isset($_POST['equal'])) {
    // If the equal button is pressed, perform the calculation
    if (!empty($_COOKIE['num']) && $_COOKIE['num'] != "Error: Division by zero" && !empty($_COOKIE['op'])) {
        $num = $_POST['input'];
        switch ($_COOKIE['op']) {
            case "+":
                $result = $_COOKIE['num'] + $num;
                break;
            case "-":
                $result = $_COOKIE['num'] - $num;
                break;
            case "*":
                $result = $_COOKIE['num'] * $num;
                break;
            case "/":
                if ($num == 0) {
                    $result = "Error: Division by zero";
                } else {
                    $result = $_COOKIE['num'] / $num;
                }
                break;
        }
        // Display the entire calculation including the previous number, operator, and current number
        $history[] = $_COOKIE['num'] . " " . $_COOKIE['op'] . " " . $num . " = " . $result;
        $num = $result;
        // Update the num cookie with the new result
        setcookie($cookie_name1, $result, time() + (86400 * 30), "/");
        // Reset the op cookie since the calculation is completed
        setcookie($cookie_name2, "", time() - 3600, "/");
    }
} elseif (isset($_POST['clear'])) {
    // If the clear button is pressed, reset the cookies and input
    $cookie_value1 = "";
    $cookie_value2 = "";
    setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/");
    setcookie($cookie_name2, $cookie_value2, time() + (86400 * 30), "/");
    $num = "";
    // Clear the history
    $history = [];
}

// Store the history array in a session variable
$_SESSION['history'] = $history;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculator</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <style>
        body {
            background-color: rgb(163, 159, 159);
        }

        .calc {
            margin: auto;
            background-color: black;
            border: 2px solid whitesmoke;
            width: 30%;
            height: fit-content;
            border-radius: 20px;
            box-shadow: 10px 10px 40px;
            padding: 20px;
        }

        .maininput {
            background-color: black;
            border: none;
            height: 80px;
            width: 100%;
            font-size: 40px;
            color: whitesmoke;
            font-weight: 700;
            text-align: right;
            padding-right: 20px;
            margin-bottom: 20px;
        }

        .history {
            background-color: black;
            border: none;
            height: 100px;
            width: 100%;
            font-size: 20px;
            color: whitesmoke;
            font-weight: 700;
            text-align: left;
            padding-left: 20px;
            margin-bottom: 20px;
            overflow-y: auto;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .numbtn,
        .calbtn,
        .c,
        .equal {
            width: 23%;
            margin-bottom: 20px;
            border: none;
            border-radius: 50px;
            font-size: 25px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s;
            padding: 20px 0;
        }

        .numbtn:hover,
        .calbtn:hover,
        .c:hover,
        .equal:hover {
            background-color: rgba(255, 255, 255, 0.3);
            color: whitesmoke;
        }

        .c,
        .equal {
            background-color: red;
        }

        .equal {
            background-color: green;
        }
    </style>
</head>

<body>
    <?php require 'partials/_nav.php' ?>
    <!-- <div class="containter" my-3>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Welcome- <?php echo $_SESSION['username'] ?>!
            </h4>
            <p>hey how are you doing ? welcome to our website. You are logged in as <?php echo $_SESSION['username'] ?> </p>
            <hr>
            <p class="mb-0">Whenever you need to, be sure to logout <a href="/calculator/logout.php">using this link.</a> </p>
        </div> -->
    </div>
    <div class="calc">
        <form action="" method="post">
            <input type="text" class="maininput" name="input" value="<?php echo htmlspecialchars($num) ?>"> <br>
            <div class="button-container">
                <input type="submit" class="numbtn" name="num" value="7">
                <input type="submit" class="numbtn" name="num" value="8">
                <input type="submit" class="numbtn" name="num" value="9">
                <input type="submit" class="calbtn" name="op" value="+">
                <input type="submit" class="numbtn" name="num" value="4">
                <input type="submit" class="numbtn" name="num" value="5">
                <input type="submit" class="numbtn" name="num" value="6">
                <input type="submit" class="calbtn" name="op" value="-">
                <input type="submit" class="numbtn" name="num" value="1">
                <input type="submit" class="numbtn" name="num" value="2">
                <input type="submit" class="numbtn" name="num" value="3">
                <input type="submit" class="calbtn" name="op" value="*">
                <input type="submit" class="c" name="clear" value="C">
                <input type="submit" class="numbtn" name="num" value="0">
                <input type="submit" class="equal" name="equal" value="=">
                <input type="submit" class="calbtn" name="op" value="/">
            </div>
        </form>
        <div class="history">
            <?php
            // Display all history
            foreach ($history as $calculation) {
                echo $calculation . "<br>";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
