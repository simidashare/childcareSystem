import { checkRadioButton } from "./bridgeContentManipulation.js";
import { ajaxHandler } from "./ajaxHandler.js";

let add = document.getElementById("add");
let remove = document.getElementById("remove");
let search = document.getElementById("search");
let update = document.getElementById("update");
let viewAll = document.getElementById("viewAll");

let dphone = document.getElementById("doc_phone");
let dpc = document.getElementById("doc_postCode");
let dsta = document.getElementById("doc_state");
let dsub = document.getElementById("doc_suburb");
let dstr = document.getElementById("doc_street");
let dln = document.getElementById("doc_lname");
let dfn = document.getElementById("doc_fname");
let did = document.getElementById("doc_id");

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidDid = validateId(did);
  if (chkValidDid) {
    let obj = {
      doc_id: did.value,
    };
    let url = "../auth/doctor-process.php?search=1";
    let searchResult = ajaxHandler(url, obj);
    searchResult.then((res) => {
      displaySearch(res);
    });
  }
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  const chkValidDid = validateId(did);
  if (chkValidDid) {
    let obj = {
      doc_id: did.value,
    };
    let url = "../auth/doctor-process.php?remove=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});
add.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidity = validateOthers(dsta, dpc, dphone, dsub, dstr, dln, dfn);
  const chkValidPostcode = validatePostcode(dpc);
  if (chkValidity && chkValidPostcode) {
    let obj = {
      doc_state: dsta.value,
      doc_postCode: dpc.value,
      doc_phone: dphone.value,
      doc_suburb: dsub.value,
      doc_street: dstr.value,
      doc_lname: dln.value,
      doc_fname: dfn.value,
    };
    let url = "../auth/doctor-process.php?add=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

update.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidDid = validateId(did);
  const chkValidity = validateOthers(dsta, dpc, dphone, dsub, dstr, dln, dfn);
  const chkValidPostcode = validatePostcode(dpc);
  if (chkValidity && chkValidDid && chkValidPostcode) {
    let obj = {
      doc_id: did.value,
      doc_state: dsta.value,
      doc_postCode: dpc.value,
      doc_phone: dphone.value,
      doc_suburb: dsub.value,
      doc_street: dstr.value,
      doc_lname: dln.value,
      doc_fname: dfn.value,
    };
    let url = "../auth/doctor-process.php?update=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let url = "../auth/doctor-process.php?viewAll=1";
  let viewAllDoctor = ajaxHandler(url);
  viewAllDoctor.then((res) => {
    doctorViewAll(res);
  });
  clearContent();
});

const displaySearch = (jsonObj) => {
  document.getElementById("doc_id").value = jsonObj[0].doc_id;
  document.getElementById("doc_postCode").value = jsonObj[0].doc_postCode;
  document.getElementById("doc_state").value = jsonObj[0].doc_state;
  document.getElementById("doc_suburb").value = jsonObj[0].doc_suburb;
  document.getElementById("doc_street").value = jsonObj[0].doc_street;
  document.getElementById("doc_lname").value = jsonObj[0].doc_lname;
  document.getElementById("doc_fname").value = jsonObj[0].doc_fname;
  document.getElementById("doc_phone").value = jsonObj[0].doc_phone;
};

const doctorViewAll = (jsonObj) => {
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
    str += "<th scope='col'>Doctor ID</th>";
    str += "<th scope='col'>First Name</th>";
    str += "<th scope='col'>Last Name</th>";
    str += "<th scope='col'>Street</th>";
    str += "<th scope='col'>Suburb</th>";
    str += "<th scope='col'>State</th>";
    str += "<th scope='col'>Postcode</th>";
    str += "<th scope='col'>Phone</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["doc_id"] + "</td>";
      str += "<td>" + jsonObj[i]["doc_fname"] + "</td>";
      str += "<td>" + jsonObj[i]["doc_lname"] + "</td>";
      str += "<td>" + jsonObj[i]["doc_street"] + "</td>";
      str += "<td>" + jsonObj[i]["doc_suburb"] + "</td>";
      str += "<td>" + jsonObj[i]["doc_state"] + "</td>";
      str += "<td>" + jsonObj[i]["doc_postCode"] + "</td>";
      str += "<td>" + jsonObj[i]["doc_phone"] + "</td>";
      str += "</tr>";
    }
  }

  document.getElementById("message").innerHTML = str;
};

const validateId = (did) => {
  if (!did.value) {
    alert("Please enter Doctor Id");
    return false;
  }
  return true;
};

const validateOthers = (dsta, dpc, dphone, dsub, dstr, dln, dfn) => {
  if (
    !dsta.value ||
    !dpc.value ||
    !dphone.value ||
    !dsub.value ||
    !dstr.value ||
    !dln.value ||
    !dfn.value
  ) {
    alert(
      `Doctor First Name, Last Name, Street, Suburb, State, Postcode, Phone are required`
    );
    return false;
  }
  return true;
};

const validatePostcode = (dpc) => {
  const reg = /^\d{4}$/;
  let result = reg.test(dpc.value);
  if (!result) {
    alert(`Postcode must be numeric and 4-digits`);
    return false;
  }
  return true;
};

const clearContent = () => {
  document.getElementById("doc_phone").value = "";
  document.getElementById("doc_postCode").value = "";
  document.getElementById("doc_state").value = "";
  document.getElementById("doc_suburb").value = "";
  document.getElementById("doc_street").value = "";
  document.getElementById("doc_lname").value = "";
  document.getElementById("doc_fname").value = "";
  document.getElementById("doc_id").value = "";
};
