import { bridgeHandler } from "./bridgeHandler.js";
import { loadChild, loadGuardian } from "./bridgeLoad.js";
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
let guardian_id_load = document.getElementById("guardian_id_load");
let guardian_id_load2 = document.getElementById("guardian_id_load2");

window.addEventListener("load", (e) => {
  loadChild("child_id_load");
  loadGuardian("guardian_id_load");
  loadGuardian("guardian_id_load2");
});

update.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, gid, gid2, child_id, guardian_id, guardian_id2;
  cid = getOptionValue(child_id_load);
  gid = getOptionValue(guardian_id_load);
  child_id = cid.value;
  guardian_id = gid.value;
  if (!child_id || !guardian_id) {
    alert("Please select Child ID and Guardian ID");
    return false;
  }
  toggleBtn();
  confirm_update.addEventListener("click", (e) => {
    e.preventDefault();
    gid2 = getOptionValue(guardian_id_load2);
    guardian_id2 = gid2.value;

    if (!child_id || !guardian_id || !guardian_id2) {
      alert(
        "Please select Child ID , the old Guardian ID and change to new  Guardian ID"
      );
      return false;
    }

    let url = "../auth/child-guardian-process.php?update=1";
    bridgeHandler(
      url,
      child_id,
      null,
      guardian_id,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      guardian_id2
    );
    clearToggle();
    loadChild("child_id_load");
    loadGuardian("guardian_id_load");
    loadGuardian("guardian_id_load2");
  });
});

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

add.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, gid, child_id, guardian_id;
  cid = getOptionValue(child_id_load);
  gid = getOptionValue(guardian_id_load);
  child_id = cid.value;
  guardian_id = gid.value;
  if (!child_id || !guardian_id) {
    alert("Please select Child ID and Guardian ID");
    return false;
  }
  let url = "../auth/child-guardian-process.php?add=1";
  bridgeHandler(url, child_id, null, guardian_id);
  loadChild("child_id_load");
  loadGuardian("guardian_id_load");
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, gid, child_id, guardian_id;
  cid = getOptionValue(child_id_load);
  gid = getOptionValue(guardian_id_load);
  child_id = cid.value;
  guardian_id = gid.value;
  if (!child_id || !guardian_id) {
    alert("Please select Child ID and Allergy ID");
    return false;
  }
  let url = "../auth/child-guardian-process.php?remove=1";
  bridgeHandler(url, child_id, null, guardian_id);
  loadChild("child_id_load");
  loadGuardian("guardian_id_load");
});

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let cid, gid, child_id, guardian_id;
  cid = getOptionValue(child_id_load);
  gid = getOptionValue(guardian_id_load);
  child_id = cid.value;
  guardian_id = gid.value;
  if (!child_id) {
    alert("Please select the Child ID");
    return false;
  }
  let url = "../auth/child-guardian-process.php?search=1";
  let searchGuardian = bridgeHandler(url, child_id, null, guardian_id);
  searchGuardian.then((res) => {
    // console.log(res);
    displayBridgeContent(
      res,
      true,
      null,
      true,
      "child_id_load",
      null,
      "guardian_id_load"
    );
  });
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "../auth/child-guardian-process.php?viewAll=1";
  let viewAllGuardianChild = bridgeHandler(url);
  viewAllGuardianChild.then((res) => {
    childGuardianViewAll(res);
  });
  loadChild("child_id_load");
  loadGuardian("guardian_id_load");
});

const childGuardianViewAll = (jsonObj) => {
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
    str += "<th scope='col'>Guardian ID</th>";
    str += "<th scope='col'>Guardian Name</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["child_id"] + "</td>";
      str += "<td>" + jsonObj[i]["child_name"] + "</td>";
      str += "<td>" + jsonObj[i]["guardian_id"] + "</td>";
      str += "<td>" + jsonObj[i]["guardian_name"] + "</td>";
      str += "</tr>";
    }
  }
  document.getElementById("message").innerHTML = str;
};
