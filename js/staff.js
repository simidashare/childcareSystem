import {
  checkRadioButton,
  getCheckBoxValues,
} from "./bridgeContentManipulation.js";
import { ajaxHandler } from "./ajaxHandler.js";

let add = document.getElementById("add");
let remove = document.getElementById("remove");
let search = document.getElementById("search");
let update = document.getElementById("update");
let viewAll = document.getElementById("viewAll");

let rk = document.getElementById("registration_key");
let sm = document.getElementById("staff_mobile");
let swp = document.getElementById("staff_workPhone");
let shp = document.getElementById("staff_homePhone");
let sg = document.getElementsByName("staff_gender");

let sln = document.getElementById("staff_lname");
let sfn = document.getElementById("staff_fname");
let sid = document.getElementById("staff_id");
let od = document.querySelectorAll("input[name='on_duty']");

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidSid = validateId(sid);
  if (chkValidSid) {
    let obj = {
      staff_id: sid.value,
    };
    let url = "../auth/staff-process.php?search=1";
    let searchResult = ajaxHandler(url, obj);
    searchResult.then((res) => {
      displaySearch(res);
    });
  }
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  const chkValidDid = validateId(sid);
  if (chkValidDid) {
    let obj = {
      staff_id: sid.value,
    };
    let url = "../auth/staff-process.php?remove=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

add.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let odArr = getCheckBoxValues(od);
  let sgen = checkRadioButton(sg);
  const chkValidity = validateOthers(sfn, sln, sgen, shp, swp, sm, rk);
  if (chkValidity) {
    let obj = {
      staff_fname: sfn.value,
      staff_lname: sln.value,
      staff_gender: sgen,
      staff_homePhone: shp.value,
      staff_workPhone: swp.value,
      staff_mobile: sm.value,
      registration_key: rk.value,
      on_duty: odArr,
    };

    let url = "../auth/staff-process.php?add=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

update.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidSid = validateId(sid);
  let odArr = getCheckBoxValues(od);
  let sgen = checkRadioButton(sg);
  const chkValidity = validateOthers(sfn, sln, sgen, shp, swp, sm, rk);
  if (chkValidity && chkValidSid) {
    let obj = {
      staff_id: sid.value,
      staff_fname: sfn.value,
      staff_lname: sln.value,
      staff_gender: sgen,
      staff_homePhone: shp.value,
      staff_workPhone: swp.value,
      staff_mobile: sm.value,
      registration_key: rk.value,
      on_duty: odArr,
    };
    let url = "../auth/staff-process.php?update=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  let url = "../auth/staff-process.php?viewAll=1";
  let viewAllStaff = ajaxHandler(url);
  viewAllStaff.then((res) => {
    staffViewAll(res);
  });
  clearContent();
});

const displaySearch = (jsonObj) => {
  document.getElementById("staff_id").value = jsonObj[0].staff_id;
  document.getElementById("staff_fname").value = jsonObj[0].staff_fname;
  document.getElementById("staff_lname").value = jsonObj[0].staff_lname;
  document.getElementById("staff_homePhone").value = jsonObj[0].staff_homePhone;
  document.getElementById("staff_workPhone").value = jsonObj[0].staff_workPhone;
  document.getElementById("staff_mobile").value = jsonObj[0].staff_mobile;
  document.getElementById("registration_key").value =
    jsonObj[0].registration_key;
  if (jsonObj[0].staff_gender === "M") {
    document.getElementById("staff_gender_m").checked = "checked";
  } else if (jsonObj[0].staff_gender === "F") {
    document.getElementById("staff_gender_f").checked = "checked";
  } else {
    document.getElementById("staff_gender_o").checked = "checked";
  }
  if (jsonObj[0].monday === "1") {
    document.getElementById("monday").checked = "checked";
  }
  if (jsonObj[0].tuesday === "1") {
    document.getElementById("tuesday").checked = "checked";
  }
  if (jsonObj[0].wednesday === "1") {
    document.getElementById("wednesday").checked = "checked";
  }
  if (jsonObj[0].thursday === "1") {
    document.getElementById("thursday").checked = "checked";
  }
  if (jsonObj[0].friday === "1") {
    document.getElementById("friday").checked = "checked";
  }
  if (jsonObj[0].saturday === "1") {
    document.getElementById("saturday").checked = "checked";
  }
};

const staffViewAll = (jsonObj) => {
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
    str += "<th scope='col'>Staff ID</th>";
    str += "<th scope='col'>First Name</th>";
    str += "<th scope='col'>Last Name</th>";
    str += "<th scope='col'>Gender</th>";
    str += "<th scope='col'>Home Phone</th>";
    str += "<th scope='col'>Work Phone</th>";
    str += "<th scope='col'>Mobile</th>";
    str += "<th scope='col'>Registration_Key</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["staff_id"] + "</td>";
      str += "<td>" + jsonObj[i]["staff_fname"] + "</td>";
      str += "<td>" + jsonObj[i]["staff_lname"] + "</td>";
      str += "<td>" + jsonObj[i]["staff_gender"] + "</td>";
      str += "<td>" + jsonObj[i]["staff_homePhone"] + "</td>";
      str += "<td>" + jsonObj[i]["staff_workPhone"] + "</td>";
      str += "<td>" + jsonObj[i]["staff_mobile"] + "</td>";
      str += "<td>" + jsonObj[i]["registration_key"] + "</td>";
      str += "</tr>";
    }
  }
  document.getElementById("message").innerHTML = str;
};

const validateId = (sid) => {
  if (!sid.value) {
    alert("Please enter Staff Id");
    return false;
  }
  return true;
};

const validateOthers = (sfn, sln, sgen, shp, swp, sm, rk, odArr, empty) => {
  if (
    !sfn.value ||
    !sln.value ||
    !sgen ||
    !shp.value ||
    !swp.value ||
    !sm.value ||
    !rk.value
  ) {
    alert(
      `Staff First Name, Last Name, Gender, Home Phone, Work Phone, Mobile, Registration Key are required`
    );
    return false;
  }
  return true;
};

const validatePostcode = (sln) => {
  const reg = /^\d{4}$/;
  let result = reg.test(sln.value);
  if (!result) {
    alert(`Postcode must be numeric and 4-digits`);
    return false;
  }
  return true;
};

const clearContent = () => {
  document.getElementById("staff_mobile").value = "";
  document.getElementById("staff_workPhone").value = "";
  document.getElementById("staff_homePhone").value = "";
  document.getElementById("staff_lname").value = "";
  document.getElementById("staff_fname").value = "";
  document.getElementById("staff_id").value = "";
  document.getElementById("registration_key").value = "";
  document.getElementById("staff_gender_f").checked = "";
  document.getElementById("staff_gender_o").checked = "";
  document.getElementById("staff_gender_m").checked = "";
  document.getElementById("monday").checked = "";
  document.getElementById("tuesday").checked = "";
  document.getElementById("wednesday").checked = "";
  document.getElementById("thursday").checked = "";
  document.getElementById("friday").checked = "";
  document.getElementById("saturday").checked = "";
};
