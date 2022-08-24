import {
  getOptionValue,
  checkRadioButton,
  getSelectedOptionValues,
  paymentRelatedHandlers,
} from "./bridgeContentManipulation.js";
import { ajaxHandler } from "./ajaxHandler.js";
import { loadChild } from "./bridgeLoad.js";

let add = document.getElementById("add");
let remove = document.getElementById("remove");
let search = document.getElementById("search");
let update = document.getElementById("update");
let viewAll = document.getElementById("viewAll");

let eid = document.getElementById("enrolment_id");
let esd = document.getElementById("enrolment_startDate");
let eed = document.getElementById("enrolment_endDate");
let end = document.getElementById("enrolment_numDays");
let enh = document.getElementById("enrolment_numHours");
let cid = document.getElementById("child_id");
let es = document.getElementsByName("enrolment_status");

window.addEventListener("load", (e) => {
  loadChild("child_id");
});

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidEid = validateId(eid);
  if (chkValidEid) {
    let obj = {
      enrolment_id: eid.value,
    };
    let url = "../auth/enrolment-process.php?search=1";
    let searchResult = ajaxHandler(url, obj);
    searchResult.then((res) => {
      displaySearch(res);
    });
  }
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  const chkValidEid = validateId(eid);
  if (chkValidEid) {
    let obj = {
      enrolment_id: eid.value,
    };
    let url = "../auth/enrolment-process.php?remove=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

add.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";

  let childID = getOptionValue(cid);
  let selectedChildID = childID.value;
  let checkEs = checkRadioButton(es);
  const chkValidity = validateOthers(
    esd,
    eed,
    end,
    enh,
    selectedChildID,
    checkEs
  );
  const chkValidDay = validateDays(end);
  const chkValidHour = validateHours(enh);
  const dayChecked = dateHandler();
  if (chkValidity && chkValidDay && chkValidHour && dayChecked) {
    let obj = {
      enrolment_startDate: esd.value,
      enrolment_endDate: eed.value,
      enrolment_numDays: end.value,
      enrolment_numHours: enh.value,
      child_id: selectedChildID,
      enrolment_status: checkEs,
    };
    let url = "../auth/enrolment-process.php?add=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

update.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidEid = validateId(eid);
  let childID = getOptionValue(cid);
  let selectedChildID = childID.value;
  let checkEs = checkRadioButton(es);
  const chkValidity = validateOthers(
    esd,
    eed,
    end,
    enh,
    selectedChildID,
    checkEs
  );
  const chkValidDay = validateDays(end);
  const chkValidHour = validateHours(enh);
  const dayChecked = dateHandler();
  if ((chkValidEid && chkValidity && chkValidDay && chkValidHour, dayChecked)) {
    let obj = {
      enrolment_id: eid.value,
      enrolment_startDate: esd.value,
      enrolment_endDate: eed.value,
      enrolment_numDays: end.value,
      enrolment_numHours: enh.value,
      child_id: selectedChildID,
      enrolment_status: checkEs,
    };
    let url = "../auth/enrolment-process.php?update=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let url = "../auth/enrolment-process.php?viewAll=1";
  let viewAllEnrolment = ajaxHandler(url);
  viewAllEnrolment.then((res) => {
    enrolmentViewAll(res);
  });
  clearContent();
});

const displaySearch = (jsonObj) => {
  document.getElementById("enrolment_id").value = jsonObj[0].enrolment_id;
  document.getElementById("enrolment_startDate").value =
    jsonObj[0].enrolment_startDate;
  document.getElementById("enrolment_endDate").value =
    jsonObj[0].enrolment_endDate;
  document.getElementById("enrolment_numDays").value =
    jsonObj[0].enrolment_numDays;
  document.getElementById("enrolment_numHours").value =
    jsonObj[0].enrolment_numHours;
  if (jsonObj[0].enrolment_status === "Y") {
    document.getElementById("enrolment_status_y").checked = "checked";
  }
  if (jsonObj[0].enrolment_status === "N") {
    document.getElementById("enrolment_status_n").checked = "checked";
  }
  let sel = document.getElementById("child_id");
  getSelectedOptionValues(sel, jsonObj[0].child_id);
};

const enrolmentViewAll = (jsonObj) => {
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
      "<div class='form-control' style='font-size:1.25rem;color:blue; text-align:center'>View All</div>";
    str += "</tr>";
    str += "<tr scope='row'>";
    str += "<th scope='col'>Enrolment ID</th>";
    str += "<th scope='col'>Start Date</th>";
    str += "<th scope='col'>End Date</th>";
    str += "<th scope='col'>Numbers of Day</th>";
    str += "<th scope='col'>Numbers of Hour</th>";
    str += "<th scope='col'>Child ID</th>";
    str += "<th scope='col'>Status</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["enrolment_id"] + "</td>";
      str += "<td>" + jsonObj[i]["enrolment_startDate"] + "</td>";
      str += "<td>" + jsonObj[i]["enrolment_endDate"] + "</td>";
      str += "<td>" + jsonObj[i]["enrolment_numDays"] + "</td>";
      str += "<td>" + jsonObj[i]["enrolment_numHours"] + "</td>";
      str += "<td>" + jsonObj[i]["child_id"] + "</td>";
      str += "<td>" + jsonObj[i]["enrolment_status"] + "</td>";
      str += "</tr>";
    }
  }

  document.getElementById("message").innerHTML = str;
};

const validateId = (eid) => {
  if (!eid.value) {
    alert("Please enter Enrolment Id");
    return false;
  }
  return true;
};

const validateOthers = (esd, eed, end, enh, selectedChildID, checkEs) => {
  if (
    !esd.value ||
    !eed.value ||
    !end.value ||
    !enh.value ||
    !selectedChildID ||
    !checkEs
  ) {
    alert(
      `Enrolment Start Date, End Date, Numbers of Day, Numbers of Hours, Child ID, Status are required`
    );
    return false;
  }
  return true;
};

const validateDays = (end) => {
  const reg = /^[1-7]$/;
  let result = reg.test(end.value);
  if (!result) {
    alert(`Days per week must be a number from 1 to 7`);
    return false;
  }
  return true;
};

const validateHours = (enh) => {
  const reg = /^[1-9][0]?$/;
  let result = reg.test(enh.value);
  if (!result) {
    alert(`Hours per week must be a number from 1 to 10`);
    return false;
  }
  return true;
};

const clearContent = () => {
  document.getElementById("enrolment_id").value = "";
  document.getElementById("enrolment_startDate").value = "";
  document.getElementById("enrolment_endDate").value = "";
  document.getElementById("enrolment_numDays").value = "";
  document.getElementById("enrolment_numHours").value = "";
  document.getElementById("child_id").value = "";
  document.getElementById("enrolment_status_y").checked = "";
  document.getElementById("enrolment_status_n").checked = "";
};

const dateHandler = () => {
  const dayDiff = new paymentRelatedHandlers(esd.value, eed.value);
  const startConfirm = dayDiff.startDateFormatCheck();
  const endConfirm = dayDiff.endDateFormatCheck();
  const diffConfirm = dayDiff.dayChecker();

  const dateFormated =
    !startConfirm || !endConfirm ? alert("Invalid Date format") : true;

  const daysConfirm =
    diffConfirm < 6 ? alert("Minimum 7 days per enrolment") : true;

  return dateFormated && daysConfirm;
};
