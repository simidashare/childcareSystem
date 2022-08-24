import { bridgeHandler } from "./bridgeHandler.js";
import { loadChild, loadAllergy } from "./bridgeLoad.js";
import {
  getOptionValue,
  getArrValues,
  checkRadioButton,
} from "./bridgeContentManipulation.js";
import { displayBridgeContent } from "./bridgeLoadDisplay.js";

let add = document.getElementById("add");
let remove = document.getElementById("remove");
let search = document.getElementById("search");
let update = document.getElementById("update");
let viewAll = document.getElementById("viewAll");
let child_id_load = document.getElementById("child_id_load");
let alle_code_load = document.getElementById("alle_code_load");
let alle_code_load2 = document.getElementById("alle_code_load2");
let change_to = document.getElementById("change_to");
let confirm_update = document.getElementById("confirm_update");

window.addEventListener("load", (e) => {
  loadChild("child_id_load");
  loadAllergy("alle_code_load");
  loadAllergy("alle_code_load2");
});

update.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, alc, alc2, child_id, alle_code, alle_code2;
  cid = getOptionValue(child_id_load);
  alc = getOptionValue(alle_code_load);
  child_id = cid.value;
  alle_code = alc.value;
  if (!child_id || !alle_code) {
    alert("Please select Child ID and Allergy Code");
    return false;
  }
  toggleBtn();
  confirm_update.addEventListener("click", (e) => {
    e.preventDefault();
    alc2 = getOptionValue(alle_code_load2);
    alle_code2 = alc2.value;
    if (!child_id || !alle_code || !alle_code2) {
      alert(
        "Please select Child ID , the old Allergy Code and change to new Allergy Code"
      );
      return false;
    }

    let url = "../auth/child-allergy-process.php?update=1";
    bridgeHandler(
      url,
      child_id,
      alle_code,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      alle_code2
    );
    loadChild("child_id_load");
    loadAllergy("alle_code_load");
    loadAllergy("alle_code_load2");
    clearToggle();
  });
});

add.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, alc, child_id, alle_code;
  cid = getOptionValue(child_id_load);
  alc = getOptionValue(alle_code_load);
  child_id = cid.value;
  alle_code = alc.value;
  if (!child_id || !alle_code) {
    alert("Please select Child ID and Allergy Code");
    return false;
  }
  let url = "../auth/child-allergy-process.php?add=1";
  bridgeHandler(url, child_id, alle_code);
  loadChild("child_id_load");
  loadAllergy("alle_code_load");
  clearToggle();
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, alc, child_id, alle_code;
  cid = getOptionValue(child_id_load);
  alc = getOptionValue(alle_code_load);
  child_id = cid.value;
  alle_code = alc.value;
  if (!child_id || !alle_code) {
    alert("Please select Child ID and Allergy ID");
    return false;
  }
  let url = "../auth/child-allergy-process.php?remove=1";
  bridgeHandler(url, child_id, alle_code);
  loadChild("child_id_load");
  loadAllergy("alle_code_load");
  clearToggle();
});

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let cid, alc, child_id, alle_code;
  cid = getOptionValue(child_id_load);
  alc = getOptionValue(alle_code_load);
  child_id = cid.value;
  alle_code = alc.value;
  if (!child_id && !alle_code) {
    alert("Please select either the Child ID or Allergy Code");
    return false;
  }
  let url = "../auth/child-allergy-process.php?search=1";
  let searchAllergy = bridgeHandler(url, child_id, alle_code);
  searchAllergy.then((res) => {
    clearToggle();
    if (res[0]["child_gender"]) {
      displayBridgeContent(
        res,
        true,
        null,
        true,
        "child_id_load",
        null,
        null,
        "alle_code_load"
      );
    } else {
      displayBridgeContent(
        res,
        true,
        true,
        null,
        "child_id_load",
        null,
        null,
        "alle_code_load"
      );
    }
  });
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "../auth/child-allergy-process.php?viewAll=1";
  let viewAllAllergyChild = bridgeHandler(url);
  viewAllAllergyChild.then((res) => {
    ChildAllergyViewAll(res);
  });
  clearToggle();
  loadChild("child_id_load");
  loadAllergy("alle_code_load");
});

const ChildAllergyViewAll = (jsonObj) => {
  let str;
  if (jsonObj.length == 0) {
    str = "Nothing in this table";
  } else {
    str = "<br/>";
    str += "<div class='table-responsive-sm'>";
    str += "<table class='table table-striped table-hover table-bordered'>";
    str += "<br/>";
    str += "<tr scope='row'>";
    str +=
      "<div class='form-control' style='font-size:1.5rem;color:blue; text-align:center'>View All</div>";
    str += "</tr>";
    str += "<tr scope='row'>";
    str += "<th scope='col'>Child ID</th>";
    str += "<th scope='col'>Child Name</th>";
    str += "<th scope='col'>Allergy Code</th>";
    str += "<th scope='col'>Allergy Description</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["child_id"] + "</td>";
      str += "<td>" + jsonObj[i]["child_name"] + "</td>";
      str += "<td>" + jsonObj[i]["alle_code"] + "</td>";
      str += "<td>" + jsonObj[i]["alle_description"] + "</td>";
      str += "</tr>";
    }
  }
  document.getElementById("message").innerHTML = str;
};

const clearToggle = () => {
  change_to.classList.add("myHidden");
  update.classList.remove("myHidden");
  confirm_update.classList.add("myHidden");
};

const toggleBtn = () => {
  change_to.classList.remove("myHidden");
  update.classList.add("myHidden");
  confirm_update.classList.remove("myHidden");
};
