<?php 
//session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true ) {
  $loggedin=true;
  $username = $_SESSION['username']; // Assuming 'username' is the key for the username in the session
}else
{
  $loggedin=false;

}

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
  <div class="container-fluid">
    <a class="navbar-brand" >Calculator</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/calculator/calculator.php">Home</a>
        </li>';

        if (!$loggedin) {
        echo'<li class="nav-item">
          <a class="nav-link" href="/calculator/login.php">Login</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="/calculator/signup.php">Signup</a>
        </li>';
        }

        if ($loggedin) {
        echo'<li class="nav-item">
          <a class="nav-link" href="/calculator/logout.php">Logout</a>
        </li>';
        // Adding the username and user icon
        
              echo '</ul>
              <div class="ms-auto">
                <ul class="navbar-nav mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link" href="#">Welcome- '.$username.'</a>
                  </li>
                </ul>
              </div>';
      }
      echo'</ul>
    </div>
  </div>
</nav>';