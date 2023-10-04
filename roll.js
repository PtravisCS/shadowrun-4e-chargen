window.loaded = function () {
  add_click_listner("btn_roll", calculate_results);
}

function add_click_listner(elem_id, func) {
  const elem = document.getElementById(elem_id); 
  elem.addEventListener("click", (ev) => func(ev));
}

function rand(min, max) {
  return Math.floor(Math.random() * (max - min + 1) ) + min;
}

function get_rolls(dice, edge_used) {
  const results = [];
  let num = 0;

  for (let i = 0; i < dice; i++) {
    num = rand(1, 6);  
    results[results.length] = num;

    if (edge_used) {
      while (num == 6) {
        num = rand(1,6);
        results[results.length] = num;
      }
    }
  }

  return results;
}

function generate_output(results) {
  let text = "",
    num_hits = 0,
    num_ones = 0;

  for (const res of results) {
    text += res;

    if (res >= 5) {
      num_hits++;
      text += ": hit";
    }
    else if (res == 1) {
      num_ones++;
      text += ": miss"; 
    }
    else {
      text += ": miss";
    }

    text += "\n";
  }

  text += "\n------------\n";
  text += "For " + results.length + " dice rolled,\n";
  text += "you scored: " + num_hits + " hits\n";
  text += "and you also rolled: " + num_ones + " ones.\n";

  if (num_ones > 0 && (results.length / num_ones) <= 2) {
    if (num_hits > 0) {
      text += "\nYou suffered a glitch.\n";
    }
    else {
      text += "\nYou suffered a _critical_ glitch.\n";
    }
  }

  return text;
}

function calculate_results() {
  const txtDicePool = document.getElementById("txt_dice_pool"),
    txtModifier = document.getElementById("txt_modifier"),
    txtResult = document.getElementById("txt_result"),
    txtEdge = document.getElementById("txt_edge");

  let num_dice = parseInt(txtDicePool.value, 10),
    mod = parseInt(txtModifier.value, 10),
    edge = parseInt(txtEdge.value, 10),
    edge_used = false;

  if (isNaN(num_dice + mod + edge)) {
    let text = "You need to enter the dice/mod/edge values. They cannot be empty.";
    txtResult.value = text;

    return;
  }

  if (edge > 0) {
    edge_used = true;
  }

  let dice = num_dice + mod + edge,
    res = 0;

  const results = get_rolls(dice, edge_used);

  const text = generate_output(results);

  txtResult.value = text; 

  return;
}
