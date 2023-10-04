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

  $settings_files = glob('./settings/*.json');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>ShadowRun 4th Ed Resources</title>
    <?php bootstrap_css(); ?>
  </head>

  <body>
    <?php print_navbar($profile_picture, $username); ?>
    <input type="text" class="d-none" id="settings_files" value="<?php foreach ($settings_files as $file) { echo $file.', '; }?>" />
    <div class="row mt-5">
      <div class="col-md-3">
      </div>
      <div class="col-md-6">
        <div class="container">
          <div class="card">
            <div class="card-header">
              <h5>ShadowRun 4th Ed Character Builder</h5>
            </div>
            <div class="card-body" id="character_builder">
              <div class="row">
                <div class="col">
                  <button type="button" id="btn_new_character" class="btn btn-primary" aria-label="New Character"><b>+</b> New Character</button>
                </div>
              </div> 
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="settings_select_dialogue" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">Select Setting</div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col">
                  <p>Select a settings file to use. Settings determine the default build method, number of build points, maximum Availability, optional and house rules that will be used when building your character.</p>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="input-group mb-3">
                    <span class="input-group-text">Settings File</span>
                    <select id="lst_settings" class="form-select" aria-label="Rules Sets to Choose From">
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_save_settings_selection">Next</button> 
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="points_select_dialogue" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">BP Amount</div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col">
                  <p>Enter the amount of build points you are allowed to create your character with (Default 400)</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="input-group">
                    <select id="lst_point_type" class="form-select" aria-label="Point Type BP or Karma">
                      <option value="bp" selected >BP</option>
                      <option value="karma">Karma</option>
                    </select>
                    <input type="text" class="form-control" id="points" aria-label="Points" value="400" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="lbl_max_avail">Max Avail.</span>
                    <input type="text" class="form-control" id="txt_max_avail" value="12" aria-label="Max Available" aria-describedby="lbl_max_avail" />
                  </div> 
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="input-group mb-3">
                    <span class="input-group-text">Ignore Character Creation Rules</span>
                    <div class="input-group-text" id="lbl_ignore_rules"><input type="checkbox" class="form-check-input mt-0" id="chk_ignore_rules" /></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_save_point_selection">Next</button> 
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="metatype_select_dialogue" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">Select a Metatype</div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-text">Category</span>
                        <select id="lst_meta_category" class="form-select" aria-label="Meta-Categories to Choose From">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group mb-3">
                        <select id="lst_meta_type" class="form-select" aria-label="Meta-Types to Choose From" size="13">
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-text">BP</span>
                        <input type="text" class="form-control" id="txt_metatype_bp_cost" aria-label="Metatype BP Cost" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">BOD</span>
                        <input type="text" class="form-control" id="txt_metatype_bod" aria-label="Metatype BOD" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">AGI</span>
                        <input type="text" class="form-control" id="txt_metatype_agi" aria-label="Metatype AGI" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">REA</span>
                        <input type="text" class="form-control" id="txt_metatype_rea" aria-label="Metatype REA" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">STR</span>
                        <input type="text" class="form-control" id="txt_metatype_str" aria-label="Metatype STR" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">INT</span>
                        <input type="text" class="form-control" id="txt_metatype_int" aria-label="Metatype INT" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">LOG</span>
                        <input type="text" class="form-control" id="txt_metatype_log" aria-label="Metatype LOG" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">CHA</span>
                        <input type="text" class="form-control" id="txt_metatype_cha" aria-label="Metatype CHA" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">WIL</span>
                        <input type="text" class="form-control" id="txt_metatype_wil" aria-label="Metatype WIL" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">INI</span>
                        <input type="text" class="form-control" id="txt_metatype_ini" aria-label="Metatype INI" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <div class="input-group">
                        <span class="input-group-text">Metavariant</span>
                        <select id="lst_metavariant" class="form-select" aria-label="Metavariants to Choose From">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-text">BP</span>
                        <input type="text" class="form-control" id="txt_metavariant_bp" aria-label="Metavariant BP Cost" />
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="input-group">
                        <span class="input-group-text">Variant Qualities</span>
                        <textarea class="form-control" id="txt_metavariant_qualities" aria-label="Metavariant Qualities" rows="4"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_save_metatype_selection">Next</button> 
          </div>
        </div>
      </div>
    </div>

    <?php bootstrap_js(); ?>
    <script src="./character.js"></script>
    <script src="./builder.js"></script>
    <script>
      window.addEventListener('load', window.loaded);
    </script>
  </body>
  </html>



  <?php
    session_unset();
    session_destroy();
