const displayBridgeContent = (
  arr,
  searchRequirement = null,
  multiOne = null,
  multiTwo = null,
  childIdLoad = null,
  staffIdLoad = null,
  guardianIdLoad = null,
  alleCodeLoad = null,
  enrolmentIdLoad = null,
  familyIdLoad = null,
  doctorIdLoad = null,
  medicineIdLoad = null
) => {
  let content = "";
  let multiArr;
  arr.length > 1 ? (multiArr = true) : (multiArr = false);
  if (arr[0]["child_id"]) {
    if (searchRequirement) {
      if (multiArr && multiOne) {
        content = "";
        arr.forEach((e) => {
          content += `<option value='${e.child_id}' id='child_id'>${e.child_id} - ${e.child_name}</option>`;
        });
      } else {
        content = `<option value='${arr[0].child_id}' id='child_id'>${arr[0].child_id} - ${arr[0].child_name}</option>`;
      }
    } else {
      content += `<option value>Please Select</option>`;
      arr.forEach((e) => {
        content += `<option value='${e.child_id}' id='child_id'>${e.child_id} - ${e.child_name}</option>`;
      });
    }
    document.getElementById(childIdLoad).innerHTML = content;
  }
  if (arr[0]["staff_id"]) {
    if (searchRequirement) {
      // if (multiArr) {
      //   content = "";
      //   arr.forEach((e) => {
      //     content += `<option value='${e.staff_id}' id='staff_id'>${e.staff_id} - ${e.staff_name}</option>`;
      //   });
      // } else {
      content = `<option value='${arr[0].staff_id}' id='staff_id'>${arr[0].staff_id} - ${arr[0].staff_name}</option>`;
      // }
    } else {
      content += `<option value>Please Select</option>`;
      arr.forEach((e) => {
        content += `<option value='${e.staff_id}' id='staff_id'>${e.staff_id} - ${e.staff_name}</option>`;
      });
    }
    document.getElementById(staffIdLoad).innerHTML = content;
  }
  if (arr[0]["alle_code"]) {
    if (searchRequirement) {
      if (multiArr && multiTwo) {
        content = "";
        arr.forEach((e) => {
          content += `<option value='${e.alle_code}' id='alle_code'>${e.alle_code} - ${e.alle_description}</option>`;
        });
      } else {
        content = `<option value='${arr[0].alle_code}' id='alle_code'>${arr[0].alle_code} - ${arr[0].alle_description}</option>`;
      }
    } else {
      content += `<option value>Please Select</option>`;
      arr.forEach((e) => {
        content += `<option value='${e.alle_code}' id='alle_code'>${e.alle_code} - ${e.alle_description}</option>`;
      });
    }
    document.getElementById(alleCodeLoad).innerHTML = content;
  }

  if (arr[0]["guardian_id"]) {
    if (searchRequirement) {
      if (multiArr) {
        //no other renders in my webpage other than multilple display condition, so I make a note here, incase other users wanna add additional display condition to other page. can change it to "multiArr && multiOne"
        content = "";
        arr.forEach((e) => {
          content += `<option value='${e.guardian_id}' id='guardian_id'>${e.guardian_id} - ${e.guardian_name}</option>`;
        });
      } else {
        content = `<option value='${arr[0].guardian_id}' id='guardian_id'>${arr[0].guardian_id} - ${arr[0].guardian_name}</option>`;
      }
    } else {
      content += `<option value>Please Select</option>`;
      arr.forEach((e) => {
        content += `<option value='${e.guardian_id}' id='guardian_id'>${e.guardian_id} - ${e.guardian_name}</option>`;
      });
    }

    document.getElementById(guardianIdLoad).innerHTML = content;
  }

  if (arr[0]["family_id"]) {
    if (searchRequirement) {
      if (multiArr && multiOne) {
        content = "";
        arr.forEach((e) => {
          content += `<option value='${e.family_id}' id='family_id'>${e.family_id} - ${e.family_name}</option>`;
        });
      } else {
        content = `<option value='${arr[0].family_id}' id='family_id'>${arr[0].family_id} - ${arr[0].family_name}</option>`;
      }
    } else {
      content += `<option value>Please Select</option>`;
      arr.forEach((e) => {
        content += `<option value='${e.family_id}' id='family_id'>${e.family_id} - ${e.family_name}</option>`;
      });
    }
    document.getElementById(familyIdLoad).innerHTML = content;
  }

  if (arr[0]["doc_id"]) {
    if (searchRequirement) {
      if (multiArr) {
        content = "";
        arr.forEach((e) => {
          content += `<option value='${e.doc_id}' id='doc_id'>${e.doc_id} - ${e.doc_name}</option>`;
        });
      } else {
        content = "";
        content = `<option value='${arr[0].doc_id}' id='doc_id'>${arr[0].doc_id} - ${arr[0].doc_name}</option>`;
      }
    } else {
      content += `<option value>Please Select</option>`;
      arr.forEach((e) => {
        content += `<option value='${e.doc_id}' id='doc_id'>${e.doc_id} - ${e.doc_name}</option>`;
      });
    }

    document.getElementById(doctorIdLoad).innerHTML = content;
  }

  if (arr[0]["med_id"]) {
    if (searchRequirement) {
      if (multiArr) {
        content = "";
        arr.forEach((e) => {
          content += `<option value='${e.med_id}' id='med_id'>${e.med_id} - ${e.med_name}</option>`;
        });
      } else {
        content = `<option value='${arr[0].med_id}' id='med_id'>${arr[0].med_id} - ${arr[0].med_name}</option>`;
      }
    } else {
      content += `<option value>Please Select</option>`;
      arr.forEach((e) => {
        content += `<option value='${e.med_id}' id='med_id'>${e.med_id} - ${e.med_name}</option>`;
      });
    }
    document.getElementById(medicineIdLoad).innerHTML = content;
  }

  if (arr[0]["enrolment_id"]) {
    if (searchRequirement) {
      if (multiArr) {
        content = "";
        arr.forEach((e) => {
          content += `<option value='${e.enrolment_id}' id='enrolment_id'>${e.enrolment_id}</option>`;
        });
      } else {
        content = `<option value='${arr[0].enrolment_id}' id='enrolment_id'>${arr[0].enrolment_id}</option>`;
      }
    } else {
      content += `<option value>Please Select</option>`;
      arr.forEach((e) => {
        content += `<option value='${e.enrolment_id}' id='enrolment_id'>${e.enrolment_id} -  (Child Id ${e.cid})</option>`;
      });
    }
    document.getElementById(enrolmentIdLoad).innerHTML = content;
  }
};

export { displayBridgeContent };
