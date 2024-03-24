function show_hide_pass() {
  let ele_icon = document.getElementById("show_hide_pass");
  let ele = document.getElementById("upass");
  //console.log(ele_icon.className);
  if (ele_icon.className == "icofont-eye-blocked") {
    ele_icon.className = "icofont-eye";
    ele.type = "text";
  } else {
    ele_icon.className = "icofont-eye-blocked";
    ele.type = "password";
  }
}

function resetError(error_id) {
  document.getElementById(error_id).innerText = "";
}
//console.log("working");
