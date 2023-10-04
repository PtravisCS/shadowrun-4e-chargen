class Character {
  constructor() {
    this.point_avail = 400;
    this.point_type = "bp";
    this.current_bp_cost = 0;

    this.metatype = '';
    this.metavariant = "";
    this.metatype_cost = 0;

    //Current character attribute level
    this.attr_bod = 0;
    this.attr_agi = 0;
    this.attr_rea = 0;
    this.attr_str = 0;
    this.attr_int = 0;
    this.attr_log = 0;
    this.attr_cha = 0;
    this.attr_wil = 0;
    this.attr_ini = 0;

    //Minimum attribute level
    this.attr_min_bod = 0;
    this.attr_min_agi = 0;
    this.attr_min_rea = 0;
    this.attr_min_str = 0;
    this.attr_min_int = 0;
    this.attr_min_log = 0;
    this.attr_min_cha = 0;
    this.attr_min_wil = 0;
    this.attr_min_ini = 0;

    //Max unaugmented attribute level
    this.attr_max_bod = 0;
    this.attr_max_agi = 0;
    this.attr_max_rea = 0;
    this.attr_max_str = 0;
    this.attr_max_int = 0;
    this.attr_max_log = 0;
    this.attr_max_cha = 0;
    this.attr_max_wil = 0;
    this.attr_max_ini = 0;

    //Max augmented attribute level
    this.attr_aug_bod = 0;
    this.attr_aug_agi = 0;
    this.attr_aug_rea = 0;
    this.attr_aug_str = 0;
    this.attr_aug_int = 0;
    this.attr_aug_log = 0;
    this.attr_aug_cha = 0;
    this.attr_aug_wil = 0;
    this.attr_aug_ini = 0;

    this.qualities = {positive: [], nevative: []};
  }

}
