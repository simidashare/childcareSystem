import { bridgeHandler } from "./bridgeHandler.js";
import { loadChild, loadMedicine } from "./bridgeLoad.js";
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
let medicine_id_load = document.getElementById("medicine_id_load");

window.addEventListener("load", (e) => {
  loadChild("child_id_load");
  loadMedicine("medicine_id_load");
});

add.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, mid, child_id, med_id;
  cid = getOptionValue(child_id_load);
  mid = getOptionValue(medicine_id_load);
  child_id = cid.value;
  med_id = mid.value;
  if (!child_id || !med_id) {
    alert("Please select Child ID and Medicine ID");
    return false;
  }
  let url = "../auth/child-medicine-process.php?add=1";
  bridgeHandler(
    url,
    child_id,
    null,
    null,
    null,
    null,
    null,
    null,
    null,
    med_id
  );
  loadChild("child_id_load");
  loadMedicine("medicine_id_load");
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  let cid, mid, child_id, med_id;
  cid = getOptionValue(child_id_load);
  mid = getOptionValue(medicine_id_load);
  child_id = cid.value;
  med_id = mid.value;
  if (!child_id || !med_id) {
    alert("Please select Child ID and Allergy ID");
    return false;
  }
  let url = "../auth/child-medicine-process.php?remove=1";
  bridgeHandler(
    url,
    child_id,
    null,
    null,
    null,
    null,
    null,
    null,
    null,
    med_id
  );
  loadChild("child_id_load");
  loadMedicine("medicine_id_load");
});

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let cid, mid, child_id, med_id;
  cid = getOptionValue(child_id_load);
  mid = getOptionValue(medicine_id_load);
  child_id = cid.value;
  med_id = mid.value;
  if (!child_id) {
    alert("Please select the Child ID");
    return false;
  }
  let url = "../auth/child-medicine-process.php?search=1";
  let searchMedicine = bridgeHandler(
    url,
    child_id,
    null,
    null,
    null,
    null,
    null,
    null,
    null,
    med_id
  );
  searchMedicine.then((res) => {
    // console.log(res);
    displayBridgeContent(
      res,
      true,
      null,
      null,
      "child_id_load",
      null,
      null,
      null,
      null,
      null,
      null,
      "medicine_id_load"
    );
  });
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "../auth/child-medicine-process.php?viewAll=1";
  let viewAllMedicineChild = bridgeHandler(url);
  viewAllMedicineChild.then((res) => {
    childMedicineViewAll(res);
  });
  loadChild("child_id_load");
  loadMedicine("medicine_id_load");
});

const childMedicineViewAll = (jsonObj) => {
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
    str += "<th scope='col'>Medicine ID</th>";
    str += "<th scope='col'>Medicine Name</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["child_id"] + "</td>";
      str += "<td>" + jsonObj[i]["child_name"] + "</td>";
      str += "<td>" + jsonObj[i]["med_id"] + "</td>";
      str += "<td>" + jsonObj[i]["med_name"] + "</td>";
      str += "</tr>";
    }
  }
  document.getElementById("message").innerHTML = str;
};
