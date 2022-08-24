import { add, resetContent } from "./combinedFunctions.js";
import { loadEnrolmentID } from "./combinedLoad.js";
import {
  loadChild,
  loadStaff,
  loadAllergy,
  loadGuardian,
} from "./bridgeLoad.js";
import { bridgeHandler } from "./bridgeHandler.js";

(function () {
  let child_id_load = document.getElementById("child_id_load");
  let alle_code_load = document.getElementById("alle_code_load");
  let guardian_id_load = document.getElementById("guardian_id_load");
  let staff_id_load = document.getElementById("staff_id_load");
  let enrolment_id_load = document.getElementById("enrolment_id_load");
  let enrolStatus = document.getElementsByName("enrolment_status");
  let addAllergy = document.getElementById("addAllergy");
  let addGuardian = document.getElementById("addGuardian");
  let addEnrolment_status = document.getElementById("addEnrolment_status");
  let addStaff = document.getElementById("addStaff");
  let removeAllergy = document.getElementById("removeAllergy");
  let removeGuardian = document.getElementById("removeGuardian");
  let removeStaff = document.getElementById("removeStaff");

  window.addEventListener("load", (e) => {
    loadChild("child_id_load");
    loadAllergy("alle_code_load");
    loadGuardian("guardian_id_load");
    loadStaff("staff_id_load");
  });

  const getOptionValue = (sel) => {
    let opt;
    for (let i = 0, len = sel.options.length; i < len; i++) {
      opt = sel.options[i];
      if (opt.selected) {
        break;
      }
    }
    return opt;
  };

  const getArrValues = (sel) => {
    var result = [];
    var opt;
    for (var i = 0, len = sel.options.length; i < len; i++) {
      opt = sel.options[i];
      if (opt.selected) {
        result.push(opt.value || opt.text); // Make a remark here for debugging
      }
    }
    return result;
  };

  const checkRadioButton = (ele) => {
    for (let i = 0; i < ele.length; i++) {
      if (ele[i].checked) {
        return ele[i].value;
      } //do not return false if there is no checked radio. otherwise will cause bug
    }
  };

  child_id_load.addEventListener("change", (e) => {
    e.preventDefault();
    if (child_id_load.value !== 0) {
      let cid, child_id;
      cid = getOptionValue(child_id_load);
      child_id = cid.value;
      loadEnrolmentID(child_id);
    }
  });

  removeAllergy.addEventListener("click", (e) => {
    e.preventDefault();
    let cid, acd, child_id, alle_code;
    cid = getOptionValue(child_id_load);
    acd = getOptionValue(alle_code_load);
    child_id = cid.value;
    alle_code = acd.value;
    if (!child_id || !alle_code) {
      alert("Please select Child ID and Allergy ID");
      return false;
    }
    let url = "../auth/combinedDelete-process.php?removeAllergy=1";
    bridgeHandler(url, child_id, alle_code);
    loadChild("child_id_load");
    loadAllergy("alle_code_load");
  });

  removeGuardian.addEventListener("click", (e) => {
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
    let url = "../auth/combinedDelete-process.php?removeGuardian=1";
    bridgeHandler(url, child_id, null, guardian_id);
    loadChild("child_id_load");
    loadGuardian("guardian_id_load");
  });

  removeStaff.addEventListener("click", (e) => {
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
    let url = "../auth/combinedDelete-process.php?removeStaff=1";
    bridgeHandler(url, child_id, null, null, staff_id);
    loadChild("child_id_load");
    loadStaff("staff_id_load");
  });

  addAllergy.addEventListener("click", (e) => {
    e.preventDefault();
    let cid, acd, child_id, alle_code;
    cid = getOptionValue(child_id_load);
    acd = getOptionValue(alle_code_load);
    child_id = cid.value;
    alle_code = acd.value;
    let url = "../auth/combinedAdd-process.php?addAllergy=1";
    add(url, child_id, alle_code);
  });

  addGuardian.addEventListener("click", (e) => {
    e.preventDefault();
    let cid, child_id, guardian_id;
    guardian_id;
    cid = getOptionValue(child_id_load);
    child_id = cid.value;
    guardian_id = getArrValues(guardian_id_load);
    guardian_id[0] === "" ? guardian_id.shift() : guardian_id;
    let url = "../auth/combinedAdd-process.php?addGuardian=1";
    add(url, child_id, null, guardian_id);
  });

  addStaff.addEventListener("click", (e) => {
    e.preventDefault();
    let cid, sid, child_id, staff_id;
    cid = getOptionValue(child_id_load);
    sid = getOptionValue(staff_id_load);
    child_id = cid.value;
    staff_id = sid.value;
    let url = "../auth/combinedAdd-process.php?addStaff=1";
    add(url, child_id, null, null, staff_id);
  });

  addEnrolment_status.addEventListener("click", (e) => {
    e.preventDefault();
    let cid, enrolment_id;
    let enrolment_status = checkRadioButton(enrolStatus);
    cid = getOptionValue(child_id_load);

    if (!cid.value) {
      alert("Please select Child ID");
      return false;
    }
    if (enrolment_status) {
      enrolment_status = enrolment_status.toUpperCase();
    } else {
      alert("Please select Enrolment Status");
      return false;
    }
    let url = "../auth/combinedAdd-process.php?addEnrolment_status=1";
    enrolment_id = enrolment_id_load.getAttribute("value");
    if (enrolment_id) {
      add(url, null, null, null, null, enrolment_id, enrolment_status);
      resetContent();
    } else {
      //  loadChild();
      //  document.querySelector(".enrolment_status_y").checked = "";
      //  document.querySelector(".enrolment_status_n").checked = "";
      resetContent();
      alert("No Enrolment record found");
    }
  });
})();
