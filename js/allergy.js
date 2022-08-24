import { checkRadioButton } from "./bridgeContentManipulation.js";
import { ajaxHandler } from "./ajaxHandler.js";

let add = document.getElementById("add");
let remove = document.getElementById("remove");
let search = document.getElementById("search");
let update = document.getElementById("update");
let viewAll = document.getElementById("viewAll");

let alc = document.getElementById("alle_code");
let ald = document.getElementById("alle_description");
let als = document.getElementById("alle_symptoms");
let aldth = document.getElementsByName("alle_dth");

remove.addEventListener("click", (e) => {
  e.preventDefault();
  const chkAlc = validateCode(alc);

  if (chkAlc) {
    let obj = {
      alle_code: alc.value,
    };
    let url = "../auth/allergy-process.php?remove=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});
add.addEventListener("click", (e) => {
  e.preventDefault();
  let alleDth;
  alleDth = checkRadioButton(aldth);
  const chkValidity = validateOthers(ald, als, alleDth);
  if (chkValidity) {
    let obj = {
      alle_symptoms: als.value,
      alle_description: ald.value,
      alle_dth: alleDth,
    };
    let url = "../auth/allergy-process.php?add=1";
    ajaxHandler(url, obj);
    // clearContent();
  }
});
viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "../auth/allergy-process.php?viewAll=1";
  let viewAllAllergy = ajaxHandler(url);
  viewAllAllergy.then((res) => {
    allergyViewAll(res);
  });
  clearContent();
});

update.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let alleDth;
  alleDth = checkRadioButton(aldth);
  const chkValidity = validateOthers(ald, als, alleDth);
  const chkValidALc = validateCode(alc);
  if (chkValidity && chkValidALc) {
    let obj = {
      alle_code: alc.value,
      alle_description: ald.value,
      alle_symptoms: als.value,
      alle_dth: alleDth,
    };
    let url = "../auth/allergy-process.php?update=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidALc = validateCode(alc);
  if (chkValidALc) {
    let obj = {
      alle_code: alc.value,
    };
    let url = "../auth/allergy-process.php?search=1";
    let searchResult = ajaxHandler(url, obj);
    searchResult.then((res) => {
      displaySearch(res);
    });
  }
});

const displaySearch = (jsonObj) => {
  document.getElementById("alle_code").value = jsonObj[0].alle_code;
  document.getElementById("alle_description").value =
    jsonObj[0].alle_description;
  document.getElementById("alle_symptoms").value = jsonObj[0].alle_symptoms;
  if (jsonObj[0].alle_dth === "Y") {
    document.getElementById("alle_dth_y").checked = "checked";
  }
  if (jsonObj[0].alle_dth === "N") {
    document.getElementById("alle_dth_n").checked = "checked";
  }
};

const allergyViewAll = (jsonObj) => {
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
    str += "<th scope='col'>Allergy Code</th>";
    str += "<th scope='col'>Allergy Description</th>";
    str += "<th scope='col'>Allergy Code</th>";
    str += "<th scope='col'>Cause Death</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["alle_code"] + "</td>";
      str += "<td>" + jsonObj[i]["alle_description"] + "</td>";
      str += "<td>" + jsonObj[i]["alle_symptoms"] + "</td>";
      str += "<td>" + jsonObj[i]["alle_dth"] + "</td>";
      str += "</tr>";
    }
  }
  document.getElementById("message").innerHTML = str;
};

const validateCode = (alc) => {
  if (!alc.value) {
    alert("Please enter Allergy Code");
    return false;
  }
  return true;
};

const validateOthers = (ald, als, alleDth) => {
  if (!ald.value || !als.value || !alleDth) {
    alert(`Allergy description, symptoms, cause death info are needed`);
    return false;
  }
  return true;
};

const clearContent = () => {
  document.getElementById("alle_code").value = "";
  document.getElementById("alle_description").value = "";
  document.getElementById("alle_symptoms").value = "";
  document.getElementById("alle_dth_n").checked = "";
  document.getElementById("alle_dth_y").checked = "";
};
