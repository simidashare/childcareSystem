import {
  loadChild,
  loadAllergy,
  loadGuardian,
  loadStaff,
  loadEnrolmentID,
} from "./combinedLoad.js";

const add = (
  url,
  childId = null,
  alleCode = null,
  guardianId = null,
  staffId = null,
  enrolmentId = null,
  enrolStatus = null
) => {
  let data = JSON.stringify({
    child_id: childId,
    alle_code: alleCode,
    guardian_id: guardianId,
    staff_id: staffId,
    enrolment_id: enrolmentId,
    enrolment_status: enrolStatus,
  });

  fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  })
    .then((response) => response.text())
    .then((response) => {
      resetContent();
      document.getElementById("message").innerHTML = response;
    })
    .catch((error) => alert("[ADD]] " + error));
};

const resetContent = () => {
  document.querySelector(".enrolment_status_y").checked = "";
  document.querySelector(".enrolment_status_n").checked = "";
  document.getElementById("enrolment_id_load").innerHTML = "";
  document.getElementById("enrolment_id_load").setAttribute("value", "");
  document.getElementById("guardian_id_load").innerHTML = "";
  document.getElementById("message").innerHTML = "";
  loadChild();
  loadAllergy();
  loadGuardian();
  loadStaff();
};

export { add, resetContent };
