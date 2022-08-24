import {
  getOptionValue,
  getSelectedOptionValues,
  paymentRelatedHandlers,
} from "./bridgeContentManipulation.js";
import { ajaxHandler } from "./ajaxHandler.js";
import { loadEnrolment } from "./bridgeLoad.js";

let add = document.getElementById("add");
let remove = document.getElementById("remove");
let search = document.getElementById("search");
let update = document.getElementById("update");
let viewAll = document.getElementById("viewAll");

let pi = document.getElementById("payment_id");
let pf = document.getElementById("payment_from");
let pt = document.getElementById("payment_to");
let ap = document.getElementById("payment_amountPaid");
let oa = document.getElementById("payment_outstandingAmount");
let eid = document.getElementById("enrolment_id");

window.addEventListener("load", (e) => {
  loadEnrolment("enrolment_id");
});

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidPi = validateId(pi);
  if (chkValidPi) {
    let obj = {
      payment_id: pi.value,
    };
    let url = "../auth/payment-process.php?search=1";
    let searchResult = ajaxHandler(url, obj);
    searchResult.then((res) => {
      displaySearch(res);
    });
  }
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  const chkValidPi = validateId(pi);
  if (chkValidPi) {
    let obj = {
      payment_id: pi.value,
    };
    let url = "../auth/payment-process.php?remove=1";
    ajaxHandler(url, obj);
    clearContent();
    loadEnrolment("enrolment_id");
  }
});

add.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let enrolmentID = getOptionValue(eid);
  let selectedEnrolmentID = enrolmentID.value;
  const chkValidity = validateOthers(pf, pt, ap, oa, selectedEnrolmentID);
  const dayChecked = dateHandler();
  const apCheck = validateAmt(ap);

  const oaCheck = validateAmt(oa);
  if (chkValidity && dayChecked && apCheck && oaCheck) {
    let obj = {
      payment_from: pf.value,
      payment_to: pt.value,
      payment_amountPaid: ap.value,
      payment_outstandingAmount: oa.value,
      enrolment_id: selectedEnrolmentID,
    };
    let url = "../auth/payment-process.php?add=1";
    ajaxHandler(url, obj);
    clearContent();
    loadEnrolment("enrolment_id");
  }
});

update.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidPi = validateId(pi);
  let enrolmentID = getOptionValue(eid);
  let selectedEnrolmentID = enrolmentID.value;
  const chkValidity = validateOthers(pf, pt, ap, oa, selectedEnrolmentID);
  const dayChecked = dateHandler();
  const apCheck = validateAmt(ap);
  const oaCheck = validateAmt(oa);
  if (chkValidPi && chkValidity && dayChecked && apCheck && oaCheck) {
    let obj = {
      payment_id: pi.value,
      payment_from: pf.value,
      payment_to: pt.value,
      payment_amountPaid: ap.value,
      payment_outstandingAmount: oa.value,
      enrolment_id: selectedEnrolmentID,
    };
    let url = "../auth/payment-process.php?update=1";
    ajaxHandler(url, obj);
    clearContent();
    loadEnrolment("enrolment_id");
  }
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let url = "../auth/payment-process.php?viewAll=1";
  let viewAllPayment = ajaxHandler(url);
  viewAllPayment.then((res) => {
    paymentViewAll(res);
  });
  clearContent();
  loadEnrolment("enrolment_id");
});

const displaySearch = (jsonObj) => {
  document.getElementById("payment_id").value = jsonObj[0].payment_id;
  document.getElementById("payment_from").value = jsonObj[0].payment_from;
  document.getElementById("payment_to").value = jsonObj[0].payment_to;
  document.getElementById("payment_amountPaid").value =
    jsonObj[0].payment_amountPaid;
  document.getElementById("payment_outstandingAmount").value =
    jsonObj[0].payment_outstandingAmount;
  let sel = document.getElementById("enrolment_id");
  getSelectedOptionValues(sel, jsonObj[0].enrolment_id);
};

const paymentViewAll = (jsonObj) => {
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
    str += "<th scope='col'>Payment ID</th>";
    str += "<th scope='col'>From</th>";
    str += "<th scope='col'>To</th>";
    str += "<th scope='col'>Paid Amount</th>";
    str += "<th scope='col'>Outstanding Amount</th>";
    str += "<th scope='col'>Enrolment ID</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["payment_id"] + "</td>";
      str += "<td>" + jsonObj[i]["payment_from"] + "</td>";
      str += "<td>" + jsonObj[i]["payment_to"] + "</td>";
      str += "<td>" + jsonObj[i]["payment_amountPaid"] + "</td>";
      str +=
        "<td style='color:red'>" +
        jsonObj[i]["payment_outstandingAmount"] +
        "</td>";
      str += "<td>" + jsonObj[i]["enrolment_id"] + "</td>";
      str += "</tr>";
    }
  }
  document.getElementById("message").innerHTML = str;
};

const validateId = (pi) => {
  if (!pi.value) {
    alert("Please enter Payment ID");
    return false;
  }
  return true;
};

const validateOthers = (pf, pt, ap, oa, selectedEnrolmentID) => {
  if (
    !pf.value ||
    !pt.value ||
    !ap.value ||
    !oa.value ||
    !selectedEnrolmentID
  ) {
    alert(
      `Payment From, To, Paid Ammount, Outstanding Ammount, Enrolment ID are required`
    );
    return false;
  }
  return true;
};

const validateAmt = (amt) => {
  const regex = /^\d+(?:\.\d{0,2})$/;
  const result = regex.test(amt.value);
  if (!result) {
    alert("Amount format must be a number with 2 decimals");
    return false;
  }
  return true;
};

const clearContent = () => {
  document.getElementById("payment_id").value = "";
  document.getElementById("payment_from").value = "";
  document.getElementById("payment_to").value = "";
  document.getElementById("payment_amountPaid").value = "";
  document.getElementById("payment_outstandingAmount").value = "";
};

const dateHandler = () => {
  const dayDiff = new paymentRelatedHandlers(pf.value, pt.value);
  const startConfirm = dayDiff.startDateFormatCheck();
  const endConfirm = dayDiff.endDateFormatCheck();
  const diffConfirm = dayDiff.dayChecker();

  const dateFormated =
    !startConfirm || !endConfirm ? alert("Invalid Date format") : true;

  const daysConfirm = diffConfirm < 6 ? alert("Minimum chage = 7 days ") : true;

  return dateFormated && daysConfirm;
};
