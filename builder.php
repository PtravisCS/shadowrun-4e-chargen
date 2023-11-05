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

          <div class="row" id="charEditorMenu">
            <div class="col">
              <button type="button" id="charEditorMenu_btnNewCharacter" class="btn btn-primary" aria-label="New Character"><b>+</b> New Character</button>
            </div>
          </div> 

          <div class="row d-none" id="charEditor">
            <div class="col-md-10">
              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabCommon" type="button" role="tab" aria-controls="tabCommon" aria-selected="true">Common</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabSkills" type="button" role="tab" aria-controls="tabSkills" aria-selected="false">Skills</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabMartialArts" type="button" role="tab" aria-controls="tabMartialArts" aria-selected="false">Martial Arts</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabCyberware" type="button" role="tab" aria-controls="tabCyberware" aria-selected="false">Cyberware/Bioware</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabGear" type="button" role="tab" aria-controls="tabGear" aria-selected="false">Street Gear</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabDrones" type="button" role="tab" aria-controls="tabDrones" aria-selected="false">Vehicles/Drones</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabCharacter" type="button" role="tab" aria-controls="tabCharacter" aria-selected="false">Character Info</button>
                    </li>
                  </ul> 
                </div>
              </div>
              <div class="tab-content" id="tab_body">

                <div class="tab-pane show active" id="tabCommon" role="tabpanel" aria-labelledby="tabCommon">
                  <div class="row mt-3">

                    <div class="col-md-2">
                      <div class="row mb-2">
                        <div class="col-md-12">
                          <button class="btn btn-secondary rounded-0" id="tabCommon_btnAddQuality">Add Quality</button>
                          <button class="btn btn-secondary rounded-0" id="tabCommon_btnRemoveQuality">Delete</button>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="input-group">
                            <select class="form-select" aria-label="list of character qualities" id="tabCommon_lstCharacterQualities" size="38">
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="input-group">
                            <span class="input-group-text">Cost</span>
                            <span class="input-group-text" id="tabCommon_lblQualityBP">0 BP</span>
                            <span class="input-group-text">Source</span>
                            <span class="input-group-text" id="tabCommon_lblQualitySource"></span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="input-group">
                            <span class="input-group-text">Alias</span>
                            <input type="text" class="form-control" id="tabCommon_txtCharAlias" aria-label="Alias" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="input-group">
                            <span class="input-group-text">Metatype</span>
                            <span class="input-group-text" id="tabCommon_lblMetatype"></span>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col-md-2">Attributes</div>
                        <div class="col-md-2">Base</div>
                        <div class="col-md-2">Aug</div>
                        <div class="col-md-2">Metatype Limits</div>
                        <div class="col-md-2" id="tabCommon_lblAttrSrc" >Source: </div>
                        <hr />
                      </div>
                      <div class="row">
                        <div class="col-md-2">Body (BOD)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharBod" aria-label="BOD" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharBodAug" aria-label="BOD aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharBodLimits"></div>
                        <div class="col-md-3" >
                          <div class="input-group">
                            <span class="input-group-text">Nuyen</span>
                            <input type="text" class="form-control" id="tabCommon_txtCharNuyen" aria-label="New Yen Amount" />
                            <span class="input-group-text" id="tabCommon_lblCharRealNuyen"> = 0¥</span>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Agility (AGI)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharAgi" aria-label="AGI" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharAgiAug" aria-label="AGI aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharAgiLimits"></div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Reaction (REA)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharRea" aria-label="REA" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharReaAug" aria-label="REA aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharReaLimits"></div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Strength (STR)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharStr" aria-label="STR" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharStrAug" aria-label="STR aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharStrLimits"></div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Charisma (CHA)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharCha" aria-label="cha" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharChaAug" aria-label="cha aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharChaLimits"></div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Intuition (INT)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharInt" aria-label="int" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharIntAug" aria-label="int aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharIntLimits"></div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Logic (LOG)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharLog" aria-label="log" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharLogAug" aria-label="log aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharLogLimits"></div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Willpower (WIL)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharWil" aria-label="will" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharWilAug" aria-label="will aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharWilLimits"></div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Edge (EDG)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharEdg" aria-label="edg" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharEdgAug" aria-label="edg aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharEdgLimits"></div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Magic (MAG)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharMag" aria-label="mag" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharMagAug" aria-label="mag aug" /></div>
                        <div class="col-md-2" id="tabCommon_lblCharMagLimits"></div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-2">Resonance (RES)</div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharRes" aria-label="res" disabled /></div>
                        <div class="col-md-2"><input type="text" class="form-control" id="tabCommon_txtCharResAug" aria-label="res aug" disabled /></div>
                        <div class="col-md-2" id="tabCommon_lblCharResLimits"></div>
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
                          <button class="btn btn-secondary rounded-0" id="tabCommon_btnAddContact">Add Contact</button>
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-md-12" id="tabCommon_contactRows">
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
                          <button class="btn btn-secondary rounded-0" id="tabCommon_btnAddEnemies">Add Enemy</button>
                        </div>
                      </div>
                      <div clas="row">
                        <div class="col-md-12" id="tabCommon_enemyRows">
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="tab-pane" id="tabSkills" role="tabpanel">
                    <div class="row mt-2">
                      <div class="col-md-3">
                        <div class="card">
                          <div class="card-header">
                            <strong>Skill Groups</strong>
                          </div>
                          <div class="card-body">
                            <div class="row mt-1">
                              <div class="col">Animal Husbandry</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_animalHusbandry" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Athletics</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_athletics" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Biotech</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_biotech" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Close Combat</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_closeCombat" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Conjuring</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_conjuring" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Cracking</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_cracking" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Electronics</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_electronics" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Firearms</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_firearms" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Influence</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_influence" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Mechanic</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_mechanic" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Outdoors</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_outdoors" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Sorcery</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_sorcery" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Stealth</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_stealth" min="0" /></div>
                            </div>
                            <div class="row mt-1">
                              <div class="col">Tasking</div>
                              <div class="col"><input type="number" class="form-control" id="tabSkills_tasking" min="0" /></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="card h-25 overflow-scroll">
                          <div class="card-header">
                            <strong>Active Skills</strong>
                          </div>
                          <div class="card-body" id="tabSkills_skillsActiveBody">
                          </div>
                        </div>
                        <div class="card mt-2">
                          <div class="card-header">
                            <strong>Knowledge Skills</strong>
                          </div>
                          <div class="card-body" id="tabSkills_skillsKnowledge">
                            <div class="row mt-1">
                              <div class="col-3">Knowledge Skills</div>
                              <div class="col-3">Free Skill Points Remaining: </div>
                              <div class="col-3" id="tabSkills_freeKnowledgeSkillPointsRemaining">6 of 6</div>
                            </div>
                            <div class="row mt-1">
                              <div class="col-2"><button class="btn btn-secondary" >Add Skill</button></div>
                            </div>
                            <div class="row mt-2" id="tabSkills_skillsKnowledgeBody">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="tab-pane" id="tabMartialArts" role="tabpanel">

                </div>
              </div>
            </div> 

            <div class="col-md-2 d-none" id="sidebar">
              <div class="card">
                <div class="card-body">
                  <ul class="nav nav-tabs" id="sidebar_tab_list" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="bpSummary_tab" data-bs-toggle="tab" data-bs-target="#bpSummary" type="button" role="tab" aria-controls="bpSummary" aria-selected="true">BP Summary</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="otherInfo_tab" data-bs-toggle="tab" data-bs-target="#otherInfo" type="button" role="tab" aria-controls="otherInfo" aria-selected="false">Other Info</button>
                    </li>
                  </ul> 

                  <div class="tab-content mt-2" id="sidebar_tab_body">

                    <div class="tab-pane show active" id="bpSummary" role="tabpanel" aria-labelledby="bpSummary">
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblMetatype">Metatype</div>
                        <div class="col-md-4" id="bpSummary_metatypeCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblAttributes">Primary Attributes</div>
                        <div class="col-md-4" id="bpSummary_attributesCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblSpecialAttributes">Special Attributes</div>
                        <div class="col-md-4" id="bpSummary_specialAttributesCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblPositiveQualities">Positive Qualities</div>
                        <div class="col-md-4" id="bpSummary_positiveQualitiesCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblNegativeQaulities">Negative Qualities</div>
                        <div class="col-md-4" id="bpSummary_negativeQualitiesCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblContacts">Contacts</div>
                        <div class="col-md-4" id="bpSummary_contactsCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblEnemies">Enemies</div>
                        <div class="col-md-4" id="bpSummary_enemiesCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblNuyen">Nuyen</div>
                        <div class="col-md-4" id="bpSummary_nuyenCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblSkillGroups">Skill Groups</div>
                        <div class="col-md-4" id="bpSummary_skillGroupsCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblActiveSkills">Active Skills</div>
                        <div class="col-md-4" id="bpSummary_activeSkillsCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblKnowledgeSkills">Knowledge Skills</div>
                        <div class="col-md-4" id="bpSummary_knowledgeSkillsCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblSpells">Spells</div>
                        <div class="col-md-4" id="bpSummary_spellsCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblFoci">Foci</div>
                        <div class="col-md-4" id="bpSummary_fociCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblSpirits">Spirits</div>
                        <div class="col-md-4" id="bpSummary_spiritsCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblSprites">Sprites</div>
                        <div class="col-md-4" id="bpSummary_spritesCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblComplexForms">Complex Forms</div>
                        <div class="col-md-4" id="bpSummary_complexFormsCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblInitiationSubmersion">Initiation/Submersion</div>
                        <div class="col-md-4" id="bpSummary_initiationSubmersionCost">0 BP</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="bpSummary_lblMartialArtsManeuvers">M.A. Meneuvers</div>
                        <div class="col-md-4" id="bpSummary_martialArtsMeneuversCost">0 BP</div>
                      </div>
                    </div>

                    <div class="tab-pane" id="otherInfo" role="tabpanel" aria-labelledby="otherInfo">
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblPhysCondTrack">Phys. Condition Track</div>
                        <div class="col-md-4" id="otherInfo_physCondTrack">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblStunCondTrack">Stun Condition Track</div>
                        <div class="col-md-4" id="otherInfo_stunCondTrack">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblInitiative">Initiative</div>
                        <div class="col-md-4" id="otherInfo_initiative">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblInitiativePasses">Initiative Passes</div>
                        <div class="col-md-4" id="otherInfo_initiativePasses">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblMatrixInitiative">Matrix Initiative</div>
                        <div class="col-md-4" id="otherInfo_matrixInitiative">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblMatrixInitiativePasses">Matrix Initiative Passes</div>
                        <div class="col-md-4" id="otherInfo_matrixInitiativePasses">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblAstralInitiative">Astral Initiative</div>
                        <div class="col-md-4" id="otherInfo_astralInitiative">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblAstralInitiativePasses">Astral Initiative Passes</div>
                        <div class="col-md-4" id="otherInfo_astralInitiativePasses">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblBallisticArmor">Ballistic Armor</div>
                        <div class="col-md-4" id="otherInfo_ballisticArmor">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblImpactArmor">Impact Armor</div>
                        <div class="col-md-4" id="otherInfo_impactArmor">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblEssence">Essence</div>
                        <div class="col-md-4" id="otherInfo_essence">6</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblNuyen">Nuyen Remaining</div>
                        <div class="col-md-4" id="otherInfo_nuyen">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblComposure">Composure</div>
                        <div class="col-md-4" id="otherInfo_composure">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblJudgeIntentions">Judge Intentions</div>
                        <div class="col-md-4" id="otherInfo_judgeIntentions">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblLiftCary">Lift and Carry</div>
                        <div class="col-md-4" id="otherInfo_liftCarry">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblMemory">Memory</div>
                        <div class="col-md-4" id="otherInfo_memory">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblMovement">Movement</div>
                        <div class="col-md-4" id="otherInfo_movement">0/0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblSwim">Swim</div>
                        <div class="col-md-4" id="otherInfo_swim">0</div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-8" id="otherInfo_lblFly">Fly</div>
                        <div class="col-md-4" id="otherInfo_fly">0</div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="mdlSettingsSelect" tabindex="-1" aria-hidden="true">
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
                    <select id="mdlSettingsSelect_lstSettings" class="form-select" aria-label="Rules Sets to Choose From">
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="mdlSettingsSelect_btnSaveSettings">Next</button> 
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="mdlPointsSelect" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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
                    <select id="mdlPointsSelect_lstPointType" class="form-select" aria-label="Point Type BP or Karma">
                      <option value="bp" selected >BP</option>
                      <option value="karma">Karma</option>
                    </select>
                    <input type="text" class="form-control" id="mdlPointsSelect_txtPoints" aria-label="Points" value="400" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="mdlPointsSelect_lblMaxAvail">Max Avail.</span>
                    <input type="text" class="form-control" id="mdlPointsSelect_txtMaxAvail" value="12" aria-label="Max Available" aria-describedby="mdlPointsSelect_lbl_maxAvail" />
                  </div> 
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="input-group mb-3">
                    <span class="input-group-text">Ignore Character Creation Rules</span>
                    <div class="input-group-text"><input type="checkbox" class="form-check-input mt-0" id="mdlPointsSelect_chkIgnoreRules" /></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="mdlPointsSelect_btnSavePoints">Next</button> 
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="mdlMetatypeSelect" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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
                        <select id="mdlMetatypeSelect_lstMetaCategory" class="form-select" aria-label="Meta-Categories to Choose From">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group mb-3">
                        <select id="mdlMetatypeSelect_lstMetatype" class="form-select" aria-label="Meta-Types to Choose From" size="13">
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
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeBPCost" aria-label="Metatype BP Cost" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">BOD</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeBod" aria-label="Metatype BOD" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">AGI</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeAgi" aria-label="Metatype AGI" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">REA</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeRea" aria-label="Metatype REA" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">STR</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeStr" aria-label="Metatype STR" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">INT</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeInt" aria-label="Metatype INT" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">LOG</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeLog" aria-label="Metatype LOG" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">CHA</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeCha" aria-label="Metatype CHA" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">WIL</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeWil" aria-label="Metatype WIL" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">INI</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetatypeIni" aria-label="Metatype INI" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <div class="input-group">
                        <span class="input-group-text">Metavariant</span>
                        <select id="mdlMetatypeSelect_lstMetavariant" class="form-select" aria-label="Metavariants to Choose From">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-text">BP</span>
                        <input type="text" class="form-control" id="mdlMetatypeSelect_txtMetavariantBP" aria-label="Metavariant BP Cost" />
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="input-group">
                        <span class="input-group-text">Variant Qualities</span>
                        <textarea class="form-control" id="mdlMetatypeSelect_txtMetavariantQualities" aria-label="Metavariant Qualities" rows="4"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="mdlMetatypeSelect_btnSaveMetatype">Next</button> 
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
