import { bridgeHandler } from "./bridgeHandler.js";
import { loadChild, loadStaff } from "./bridgeLoad.js";
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
let staff_id_load = document.getElementById("staff_id_load");

window.addEventListener("load", (e) => {
  loadChild("child_id_load");
  loadStaff("staff_id_load");
});

add.addEventListener("click", (e) => {
  e.preventDefault();

  let cid, sid, child_id, staff_id;
  cid = getOptionValue(child_id_load);
  sid = getOptionValue(staff_id_load);
  child_id = cid.value;
  staff_id = sid.value;
  if (!child_id || !staff_id) {
    alert("Please select Child ID and Staff ID");
    return false;
  }
  let url = "../auth/staff-child-process.php?add=1";
  bridgeHandler(url, child_id, null, null, staff_id);
  loadChild("child_id_load");
  loadStaff("staff_id_load");
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, sid, child_id, staff_id;
  cid = getOptionValue(child_id_load);
  sid = getOptionValue(staff_id_load);
  child_id = cid.value;
  staff_id = sid.value;
  if (!child_id || !staff_id) {
    alert("Please select Child ID and Staff ID");
    return false;
  }
  let url = "../auth/staff-child-process.php?remove=1";
  bridgeHandler(url, child_id, null, null, staff_id);
  loadChild("child_id_load");
  loadStaff("staff_id_load");
});

update.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, sid, child_id, staff_id;
  cid = getOptionValue(child_id_load);
  sid = getOptionValue(staff_id_load);
  child_id = cid.value;
  staff_id = sid.value;
  if (!child_id || !staff_id) {
    alert("Please select Child ID and Staff ID");
    return false;
  }
  let url = "../auth/staff-child-process.php?update=1";
  bridgeHandler(url, child_id, null, null, staff_id);
  loadChild("child_id_load");
  loadStaff("staff_id_load");
});

search.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, sid, child_id, staff_id;
  cid = getOptionValue(child_id_load);
  sid = getOptionValue(staff_id_load);
  child_id = cid.value;
  staff_id = sid.value;
  if (!staff_id) {
    alert("Please select the Staff ID");
    return false;
  }
  let url = "../auth/staff-child-process.php?search=1";
  let searchStaff = bridgeHandler(url, child_id, null, null, staff_id);
  searchStaff.then((res) => {
    // console.log(res);
    displayBridgeContent(
      res,
      true,
      true,
      null,
      "child_id_load",
      "staff_id_load"
    );
  });
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "../auth/staff-child-process.php?viewAll=1";
  let viewAllStaffChild = bridgeHandler(url);
  viewAllStaffChild.then((res) => {
    staffChildViewAll(res);
  });
  loadChild("child_id_load");
  loadStaff("staff_id_load");
});

const staffChildViewAll = (jsonObj) => {
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
    str += "<th scope='col'>First Name</th>";
    str += "<th scope='col'>Last Name</th>";
    str += "<th scope='col'>Staff Name</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["Child ID"] + "</td>";
      str += "<td>" + jsonObj[i]["First Name"] + "</td>";
      str += "<td>" + jsonObj[i]["Last Name"] + "</td>";
      str += "<td>" + jsonObj[i]["Staff"] + "</td>";
      str += "</tr>";
    }
  }
  document.getElementById("message").innerHTML = str;
};
