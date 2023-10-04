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
    <title>ShadowRun Dice Roller</title>
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
              <h5>ShadowRun 4th Ed Dice Roller</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="alert alert-warning">
                    <div class="text-center">
                      Hits do not necessarily equate to success on a test. Tests require a certain number of hits to succeed as determined by the gm.
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-text" id="lbl_dice_pool">Dice Pool Size</span>
                    <input type="text" class="form-control" id="txt_dice_pool" aria-label="Dice Pool Size" aria-describedby="lbl_dice_pool" />
                  </div> 
                </div>
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-text" id="lbl_modifier">Modifier</span>
                    <input type="text" class="form-control" id="txt_modifier" aria-label="Modifier" aria-describedby="lbl_modifier" />
                  </div> 
                </div>
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-text" id="lbl_edge">Edge Dice</span>
                    <input type="text" class="form-control" id="txt_edge" aria-label="Edge Dice" aria-describedby="lbl_edge" />
                  </div> 
                </div>
                <div class="col-md-3">
                  <button type="button" id="btn_roll" class="btn btn-success">Roll!</button>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-text" id="lbl_result">Results</span>
                    <textarea class="form-control" id="txt_result" rows="15" aria-label="Results" aria-describedby="lbl_result" readonly></textarea>
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
     
    <?php bootstrap_js(); ?>
    <script src="./roll.js"></script>
    <script>
      window.addEventListener('load', window.loaded);
    </script>
  </body>
</html>

<?php
  session_unset();
  session_destroy();
