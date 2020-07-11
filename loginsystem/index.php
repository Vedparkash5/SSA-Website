<?php
 
  require "header.php";
?>

    <main>
      <div class="wrapper-main">
        <section class="section-default">
        
          <?php
          if (!isset($_SESSION['id'])) {
            echo '<p class="login-status">You are logged out!</p>';
          }
          else if (isset($_SESSION['id'])) {
            echo '<p class="login-status">You are logged in!</p>';
          }
          ?>
        </section>
      </div>
    </main>

<?php
  // include the header from a separate file, we do the same with the footer.
  require "footer.php";
?>
