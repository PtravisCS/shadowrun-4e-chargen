let chummer = {};
let character = new Character();

window.loaded = function () {
  window.modals = {};
  add_event_listener("btn_new_character", "click", getSettings);
  add_event_listener("btn_save_settings_selection", "click", getPointSelection);
  add_event_listener("btn_save_point_selection", "click", getMetaTypeSelection);
  add_event_listener("lst_meta_category", "change", updateMetaTypes);
  add_event_listener("lst_meta_type", "change", updateMetatypeStats);
  add_event_listener("lst_metavariant", "change", updateMetavariantStats);
  add_event_listener("btn_save_metatype_selection", "click", createCharacter);
}

function ajax(url, func) {
  fetch(url).then((response) => {
    return response.json();
  })
  .then(func)
  .catch((ex) => {
    console.log(ex);
  });
}

function add_event_listener(elem_id, event, func) {
  const elem = document.getElementById(elem_id); 
  elem.addEventListener(event, (ev) => func(ev));
}

function showModal(elem_id, options = { "keyboard": false }) {
  if (!window.modals[elem_id]) {
    const modal = new bootstrap.Modal(document.getElementById(elem_id), options);
    window.modals[elem_id] = modal;
    modal.show();
  }
  else {
    const modal = window.modals[elem_id];
    modal.toggle();
  }
}

function hideModal(elem_id) {
  if (window.modals[elem_id]) {
    window.modals[elem_id].hide();

    window.modals[elem_id] = null;
    delete window.modals[elem_id];
  }
}

function getSettings() {
  const settings_files_string = document.getElementById('settings_files').value,
    lst_settings = document.getElementById('lst_settings');

  const settings_files = settings_files_string.split(', ');

  while (lst_settings.options.length > 0) {
    lst_settings.remove(0);
  }

  for (const file of settings_files) {
    if (file.trim() != '') {
      let opt = document.createElement('option');
      opt.value = file;
      opt.innerHTML = file;
      lst_settings.appendChild(opt);
    }
  }

  showModal('settings_select_dialogue', {});
}

function getPointSelection() {
  hideModal('settings_select_dialogue');
  showModal('points_select_dialogue');
}

function updateMetaTypes() {
  const lst_meta_category = document.getElementById('lst_meta_category'),
    lst_meta_type = document.getElementById('lst_meta_type');

  while (lst_meta_type.options.length > 0) {
    lst_meta_type.remove(0);
  }

  for (const metatype of chummer.metatypes.metatype) {
    if (metatype.category == lst_meta_category.value) {
      let opt = document.createElement('option');
      opt.value = metatype.name;
      opt.innerHTML = metatype.name;
      lst_meta_type.appendChild(opt); 
    }
  }
}

function updateMetavariantStats() {
  const variant_bp = document.getElementById('txt_metavariant_bp'),
    qualities = document.getElementById('txt_metavariant_qualities'),
    metatype = document.getElementById('lst_meta_type').value,
    metavariant = document.getElementById('lst_metavariant').value;

  const meta_obj = chummer.metatypes.metatype.find((obj) => obj.name === metatype);
  const metavariant_obj = meta_obj.metavariants.metavariant.find((variant) => variant.name === metavariant);

  if (metavariant_obj) {
    variant_bp.value = metavariant_obj?.bp; 
    qualities.innerHTML = '';

    for (const quality of metavariant_obj.qualities.negative.quality) {
      if (quality) {
        qualities.innerHTML += quality + "\n";
      }
    }

    for (const quality of metavariant_obj.qualities.positive.quality) {
      if (quality) {
        qualities.innerHTML += quality + "\n";
      }
    }

  }
  else {
    variant_bp.value = ''; 
    qualities.innerHTML = '';
  }

}

function updateMetatypeStats() {
  const bp_cost = document.getElementById('txt_metatype_bp_cost'),
    txt_bod = document.getElementById('txt_metatype_bod'),
    txt_agi = document.getElementById('txt_metatype_agi'),
    txt_rea = document.getElementById('txt_metatype_rea'),
    txt_str = document.getElementById('txt_metatype_str'),
    txt_int = document.getElementById('txt_metatype_int'),
    txt_log = document.getElementById('txt_metatype_log'),
    txt_wil = document.getElementById('txt_metatype_wil'),
    txt_ini = document.getElementById('txt_metatype_ini'),
    txt_cha = document.getElementById('txt_metatype_cha'),
    lst_metavariant = document.getElementById('lst_metavariant'),
    variant_bp = document.getElementById('txt_metavariant_bp'),
    qualities = document.getElementById('txt_metavariant_qualities'),
    metatype = document.getElementById('lst_meta_type').value;

  const meta_obj = chummer.metatypes.metatype.find((obj) => obj.name === metatype); 

  bp_cost.value = meta_obj.bp;
  txt_bod.value = meta_obj.bodmin + "/" + meta_obj.bodmax + " (" + meta_obj.bodaug + ")";
  txt_agi.value = meta_obj.agimin + "/" + meta_obj.agimax + " (" + meta_obj.agiaug + ")";
  txt_rea.value = meta_obj.reamin + "/" + meta_obj.reamax + " (" + meta_obj.reaaug + ")";
  txt_str.value = meta_obj.strmin + "/" + meta_obj.strmax + " (" + meta_obj.straug + ")";
  txt_int.value = meta_obj.intmin + "/" + meta_obj.intmax + " (" + meta_obj.intaug + ")";
  txt_log.value = meta_obj.logmin + "/" + meta_obj.logmax + " (" + meta_obj.logaug + ")";
  txt_cha.value = meta_obj.chamin + "/" + meta_obj.chamax + " (" + meta_obj.chaaug + ")";
  txt_wil.value = meta_obj.wilmin + "/" + meta_obj.wilmax + " (" + meta_obj.wilaug + ")";
  txt_ini.value = meta_obj.inimin + "/" + meta_obj.inimax + " (" + meta_obj.iniaug + ")";

  const metavariants = meta_obj?.metavariants?.metavariant;

  while (lst_metavariant.options.length > 0) {
    lst_metavariant.remove(0);
  }

  qualities.innerHTML = '';
  variant_bp.value = '';

  if (metavariants) {
    const opt = document.createElement('option');
    opt.value = '-1';
    opt.innerHTML = 'None';
    lst_metavariant.appendChild(opt); 

    for (const variant of metavariants) {
      const opt = document.createElement('option');
      opt.value = variant.name;
      opt.innerHTML = variant.name;
      lst_metavariant.appendChild(opt); 
    }
  }
}

function getMetaTypeSelection() {
  hideModal('points_select_dialogue');

  const url = 'https://ptserv.ddns.net/shadowRun/data/metatypes.json';

  ajax(url, (data) => {
    chummer = data.chummer;

    const lst_meta_category = document.getElementById('lst_meta_category');

    for (const category of chummer.categories.category) {
      let opt = document.createElement('option');
      opt.value = category;
      opt.innerHTML = category;
      lst_meta_category.appendChild(opt); 
    }

    updateMetaTypes();

    showModal('metatype_select_dialogue');
  });
}

function createCharacter() {
  const metatype_bp = parseInt(document.getElementById('txt_metatype_bp_cost').value, 10),
    variant_bp = parseInt(document.getElementById('txt_metavariant_bp').value, 10),
    metatype = document.getElementById('lst_meta_type').value,
    metavariant = document.getElementById('lst_metavariant').value;

  if (variant_bp > 0) {
    character.metatype_cost = variant_bp;
  }
  else {
    character.metatype_cost = metatype_bp;
  }

  const meta_obj = chummer.metatypes.metatype.find((obj) => obj.name === metatype);
  const metavariant_obj = meta_obj.metavariants.metavariant.find((variant) => variant.name === metavariant);
  
  character.metatype = metatype;
  character.metavariant = metavariant;

  character.attr_min_bod = meta_obj.bodmin;
  character.attr_min_agi = meta_obj.agimin;
  character.attr_min_rea = meta_obj.reamin;
  character.attr_min_str = meta_obj.strmin;
  character.attr_min_int = meta_obj.intmin;
  character.attr_min_log = meta_obj.logmin;
  character.attr_min_cha = meta_obj.chamin;
  character.attr_min_wil = meta_obj.wilmin;
  character.attr_min_ini = meta_obj.inimin;
  character.attr_max_bod = meta_obj.bodmax; 
  character.attr_max_agi = meta_obj.agimax; 
  character.attr_max_rea = meta_obj.reamax; 
  character.attr_max_str = meta_obj.strmax; 
  character.attr_max_int = meta_obj.intmax; 
  character.attr_max_log = meta_obj.logmax; 
  character.attr_max_cha = meta_obj.chamax; 
  character.attr_max_wil = meta_obj.wilmax; 
  character.attr_max_ini = meta_obj.inimax; 
  character.attr_aug_bod = meta_obj.bodaug;
  character.attr_aug_agi = meta_obj.agiaug;
  character.attr_aug_rea = meta_obj.reaaug;
  character.attr_aug_str = meta_obj.straug;
  character.attr_aug_int = meta_obj.intaug;
  character.attr_aug_log = meta_obj.logaug;
  character.attr_aug_cha = meta_obj.chaaug;
  character.attr_aug_wil = meta_obj.wilaug;
  character.attr_aug_ini = meta_obj.iniaug;

  if (metavariant != -1) {
    character.qualities.positive = metavariant_obj.qualities.positive.quality;
    character.qualities.negative = metavariant_obj.qualities.negative.quality;
  }

  hideModal('metatype_select_dialogue');
  document.getElementById('tab_row').classList.remove('d-none');
  document.getElementById('tab_body').classList.remove('d-none');
  document.getElementById('new_char_row').classList.add('d-none');
}
