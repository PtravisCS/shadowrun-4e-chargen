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
    <div class="container-fluid mt-3">
      <div class="card">
        <div class="card-header">
          <h5>ShadowRun 4th Ed Character Builder</h5>
        </div>
        <div class="card-body" id="character_builder">

          <div class="row" id="new_char_row">
            <div class="col">
              <button type="button" id="btn_new_character" class="btn btn-primary" aria-label="New Character"><b>+</b> New Character</button>
            </div>
          </div> 

          <div class="row d-none" id="tab_row">
            <div class="col-md-12">
              <ul class="nav nav-tabs" id="tab_list" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="common_tab" data-bs-toggle="tab" data-bs-target="#common" type="button" role="tab" aria-controls="home" aria-selected="true">Common</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="skills_tab" data-bs-toggle="tab" data-bs-target="#skills" type="button" role="tab" aria-controls="skills" aria-selected="false">Skills</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="martial_arts_tab" data-bs-toggle="tab" data-bs-target="#martial_arts" type="button" role="tab" aria-controls="martial_arts" aria-selected="false">Martial Arts</button>
                </li>
              </ul> 
            </div>
          </div>
          <div class="tab-content d-none" id="tab_body">

            <div class="tab-pane show active" id="common" role="tabpanel" aria-labelledby="common_tab">
              <div class="row mt-3">

                <div class="col-md-2">
                  <div class="row mb-2">
                    <div class="col-md-12">
                      <button class="btn btn-secondary rounded-0" id="btn_add_quality">Add Quality</button>
                      <button class="btn btn-secondary rounded-0" id="btn_remove_quality">Delete</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <select class="form-select" aria-label="list of character qualities" id="lst_character_qualities" size="38">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-text">Cost</span>
                        <span class="input-group-text" id="lbl_quality_bp">0 BP</span>
                        <span class="input-group-text">Source</span>
                        <span class="input-group-text" id="lbl_quality_source"></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-text">Alias</span>
                        <input type="text" class="form-control" id="txt_char_alias" aria-label="Alias" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-text">Metatype</span>
                        <span class="input-group-text" id="lbl_metatype"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-2">Attributes</div>
                    <div class="col-md-2">Base</div>
                    <div class="col-md-2">Aug</div>
                    <div class="col-md-2">Metatype Limits</div>
                    <div class="col-md-2" id="lbl_attr_src" >Source: </div>
                    <hr />
                  </div>
                  <div class="row">
                    <div class="col-md-2">Body (BOD)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_bod" aria-label="BOD" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_bod_aug" aria-label="BOD aug" /></div>
                    <div class="col-md-2" id="lbl_char_bod_limits"></div>
                    <div class="col-md-3" >
                      <div class="input-group">
                        <span class="input-group-text">Nuyen</span>
                        <input type="text" class="form-control" id="txt_char_nuyen" aria-label="New Yen Amount" />
                        <span class="input-group-text" id="lbl_char_real_nuyen"> = 0¥</span>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Agility (AGI)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_agi" aria-label="AGI" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_agi_aug" aria-label="AGI aug" /></div>
                    <div class="col-md-2" id="lbl_char_agi_limits"></div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Reaction (REA)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_rea" aria-label="REA" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_rea_aug" aria-label="REA aug" /></div>
                    <div class="col-md-2" id="lbl_char_rea_limits"></div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Strength (STR)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_str" aria-label="STR" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_str_aug" aria-label="STR aug" /></div>
                    <div class="col-md-2" id="lbl_char_str_limits"></div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Charisma (CHA)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_cha" aria-label="cha" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_cha_aug" aria-label="cha aug" /></div>
                    <div class="col-md-2" id="lbl_char_cha_limits"></div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Intuition (INT)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_int" aria-label="int" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_int_aug" aria-label="int aug" /></div>
                    <div class="col-md-2" id="lbl_char_int_limits"></div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Logic (LOG)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_log" aria-label="log" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_log_aug" aria-label="log aug" /></div>
                    <div class="col-md-2" id="lbl_char_log_limits"></div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Willpower (WIL)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_wil" aria-label="will" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_wil_aug" aria-label="will aug" /></div>
                    <div class="col-md-2" id="lbl_char_wil_limits"></div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Edge (EDG)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_edg" aria-label="edg" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_edg_aug" aria-label="edg aug" /></div>
                    <div class="col-md-2" id="lbl_char_edg_limits"></div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Magic (MAG)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_mag" aria-label="mag" /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_mag_aug" aria-label="mag aug" /></div>
                    <div class="col-md-2" id="lbl_char_mag_limits"></div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-2">Resonance (RES)</div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_res" aria-label="res" disabled /></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="txt_char_res_aug" aria-label="res aug" disabled /></div>
                    <div class="col-md-2" id="lbl_char_res_limits"></div>
                  </div>

                  <!--Contacts -->
                  <div class="row mt-3">
                    <div class="col">
                      <h5>Contacts</h5>
                      <hr />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <button class="btn btn-secondary rounded-0" id="btn_add_contact">Add Contact</button>
                    </div> 
                  </div>
                  <div class="row">
                    <div class="col-md-12" id="contact_rows">
                    </div>
                  </div>
                  
                  <!-- Enemies -->
                  <div class="row mt-5">
                    <div class="col">
                      <h5>Enemies</h5>
                      <hr />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <button class="btn btn-secondary rounded-0" id="btn_add_enemy">Add Enemy</button>
                    </div>
                  </div>
                  <div clas="row">
                    <div class="col-md-12" id="enemy_rows">
                    </div>
                  </div>
                </div>

                <div class="col-md-2">

                </div>
              </div>
            </div>

            <div class="tab-pane" id="skills" role="tabpanel" aria-labelledby="skills_tab">

            </div>

            <div class="tab-pane" id="martial_arts" role="tabpanel" aria-labelledby="martial_arts_tab">

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
                        <span class="input-group-text rounded-0">Category</span>
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
