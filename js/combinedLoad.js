const loadChild = () => {
  fetch("combinedAdd-process.php?loadChild=1")
    .then((response) => response.json())
    .then((response) => {
      displayContent(response);
    })
    .catch((error) => alert("x" + error));
};
const loadAllergy = () => {
  fetch("combinedAdd-process.php?loadAllergy=1")
    .then((response) => response.json())
    .then((response) => {
      displayContent(response);
    })
    .catch((error) => alert("x" + error));
};
const loadGuardian = () => {
  fetch("combinedAdd-process.php?loadGuardian=1")
    .then((response) => response.json())
    .then((response) => {
      displayContent(response);
    })
    .catch((error) => alert("x" + error));
};
const loadStaff = () => {
  fetch("combinedAdd-process.php?loadStaff=1")
    .then((response) => response.json())
    .then((response) => {
      displayContent(response);
    })
    .catch((error) => alert("x" + error));
};

const loadEnrolmentID = (childId) => {
  let data = JSON.stringify({ child_id: childId });
  fetch("combinedAdd-process.php?loadEnrolmentID=1", {
    method: "POST",
    body: data,
  })
    .then((response) => response.json())
    .then((response) => {
      displayContent(response);
    })
    .catch((error) => {
      console.log("[loadEnrolmentID]" + error);
      document.getElementById("enrolment_id_load").setAttribute("value", "");
    });
};

function displayContent(arr) {
  let content = "";
  if (arr[0]["child_id"]) {
    content += `<option value="">Please Select</option>`;
    arr.forEach((e) => {
      content += `<option value='${e.child_id}' id='child_id'>${e.child_id} - ${e.child_name}</option>`;
    });
    document.getElementById("child_id_load").innerHTML = content;
  }
  if (arr[0]["alle_code"]) {
    content += `<option value="">Please Select</option>`;
    arr.forEach((e) => {
      content += `<option value='${e.alle_code}' id='alle_code'>${e.alle_description}</option>`;
    });
    document.getElementById("alle_code_load").innerHTML = content;
  }
  if (arr[0]["guardian_id"]) {
    content += `<option value="0">Please Select</option>`;
    arr.forEach((e) => {
      content += `<option value='${e.guardian_id}' id='guardian_id'>${e.guardian_id} - ${e.guardian_name}</option>`;
    });

    document.getElementById("guardian_id_load").innerHTML = content;
  }
  if (arr[0]["staff_id"]) {
    content += `<option value="">Please Select</option>`;
    arr.forEach((e) => {
      content += `<option value='${e.staff_id}' id='staff_id'>${e.staff_id} - ${e.staff_name}</option>`;
    });
    document.getElementById("staff_id_load").innerHTML = content;
  }
  if (arr[0]["enrolment_id"]) {
    arr.forEach((e) => {
      if (e.enrolment_id) {
        content += e.enrolment_id; //only show one
        document.getElementById("enrolment_id_load").innerText = content;
        document
          .getElementById("enrolment_id_load")
          .setAttribute("value", content);
      } else {
        document.getElementById("enrolment_id_load").setAttribute("value", "");
      }
    });
  } else {
    document.getElementById("enrolment_id_load").setAttribute("value", "");
    document.getElementById("enrolment_id_load").innerText = "";
  }
}

export { loadChild, loadAllergy, loadGuardian, loadStaff, loadEnrolmentID };
