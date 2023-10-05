<?php
  require '../shared_tools/database.php';
  require '../shared_tools/common_functions.php';

  session_start();

  if (is_logged_in()) {
    $username = $_SESSION['username'];
    $profile_picture = $_SESSION['profile_picture'];
    is_admin(); 
  }
  else {
    $username = '';
    $profile_picture = '';
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title>ShadowRun 4th Ed Resources</title>
    <?php bootstrap_css(); ?>
  </head>

  <body>
    <?php print_navbar($profile_picture, $username); ?>

    <div class="row mt-5">
      <div class="col-md-3">
      </div>
      <div class="col-md-6">
        <div class="container">
          <div class="card">
            <div class="card-header">
              <h5>ShadowRun 4th Ed Resources</h5>
            </div>
            <div class="card-body">
              <div class="list-group list-group-flush">
                <a href="https://www.shadowruntabletop.com/wp-content/uploads/Downloads/Shadowrun%20Quick-Start%20Rules.pdf" class="list-group-item list-group-item-action">Quick Start Guide</a>
                <a href="https://ptserv.ddns.net/fileServ/files/electracion/Shadowrun-4th-ed-Character-Sheet-fillable.pdf" class="list-group-item list-group-item-action">Character Sheet</a>
                <a href="./roll.php" class="list-group-item list-group-item-action">Dice Roller</a>
                <a href="https://github.com/chummer5a/chummer/releases/download/0.490/Chummer.zip" class="list-group-item list-group-item-action">Character Generator Program (Chummer)</a>
                <a href="https://ptserv.ddns.net/fileServ/files/electracion/So%20you%20want%20to%20break%20a%20Maglock_4e_v1.pdf" class="list-group-item list-group-item-action">Flowchart for Mag-Locks</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
     
    <?php bootstrap_js(); ?>
  </body>
</html>

<?php
  session_unset();
  session_destroy();
