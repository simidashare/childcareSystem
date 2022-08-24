import { bridgeHandler } from "./bridgeHandler.js";
import { loadFamily, loadDoctor } from "./bridgeLoad.js";
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
let family_id_load = document.getElementById("family_id_load");
let doc_id_load = document.getElementById("doc_id_load");

window.addEventListener("load", (e) => {
  loadFamily("family_id_load");
  loadDoctor("doc_id_load");
});

add.addEventListener("click", (e) => {
  e.preventDefault();
  let fid, did, family_id, doc_id;
  fid = getOptionValue(family_id_load);
  did = getOptionValue(doc_id_load);
  family_id = fid.value;
  doc_id = did.value;
  if (!family_id || !doc_id) {
    alert("Please select Family ID and Doctor ID");
    return false;
  }
  let url = "../auth/family-doctor-process.php?add=1";
  bridgeHandler(url, null, null, null, null, null, null, family_id, doc_id);
  loadFamily("family_id_load");
  loadDoctor("doc_id_load");
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  let fid, did, family_id, doc_id;
  fid = getOptionValue(family_id_load);
  did = getOptionValue(doc_id_load);
  family_id = fid.value;
  doc_id = did.value;
  if (!family_id || !doc_id) {
    alert("Please select Family ID and Doctor ID");
    return false;
  }
  let url = "../auth/family-doctor-process.php?remove=1";
  bridgeHandler(url, null, null, null, null, null, null, family_id, doc_id);
  loadFamily("family_id_load");
  loadDoctor("doc_id_load");
});

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let fid, did, family_id, doc_id;
  fid = getOptionValue(family_id_load);
  did = getOptionValue(doc_id_load);
  family_id = fid.value;
  doc_id = did.value;
  if (!family_id) {
    alert("Please select the Family ID");
    return false;
  }
  let url = "../auth/family-doctor-process.php?search=1";
  let searchFamilyDoctor = bridgeHandler(
    url,
    null,
    null,
    null,
    null,
    null,
    null,
    family_id,
    doc_id
  );
  searchFamilyDoctor.then((res) => {
    // console.log(res);
    displayBridgeContent(
      res,
      true,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      "family_id_load",
      "doc_id_load"
    );
  });
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "../auth/family-doctor-process.php?viewAll=1";
  let viewAllDoctorFamily = bridgeHandler(url);
  viewAllDoctorFamily.then((res) => {
    familyDoctorViewAll(res);
  });
  loadFamily("family_id_load");
  loadDoctor("doc_id_load");
});

const familyDoctorViewAll = (jsonObj) => {
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
    str += "<th scope='col'>Family ID</th>";
    str += "<th scope='col'>Family Name</th>";
    str += "<th scope='col'>Doctor ID</th>";
    str += "<th scope='col'>Doctor Name</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["family_id"] + "</td>";
      str += "<td>" + jsonObj[i]["family_name"] + "</td>";
      str += "<td>" + jsonObj[i]["doc_id"] + "</td>";
      str += "<td>" + jsonObj[i]["doc_name"] + "</td>";
      str += "</tr>";
    }
  }
  document.getElementById("message").innerHTML = str;
};
