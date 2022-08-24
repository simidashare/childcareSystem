const bridgeHandler = (
  url,
  childId = null,
  alleCode = null,
  guardianId = null,
  staffId = null,
  enrolmentId = null,
  enrolStatus = null,
  familyId = null,
  doctorId = null,
  medicineId = null,
  alleCode2 = null,
  guardianId2 = null
) => {
  let data = JSON.stringify({
    child_id: childId,
    alle_code: alleCode,
    guardian_id: guardianId,
    staff_id: staffId,
    enrolment_id: enrolmentId,
    enrolment_status: enrolStatus,
    family_id: familyId,
    doc_id: doctorId,
    med_id: medicineId,
    alle_code2: alleCode2,
    guardian_id2: guardianId2,
  });

  return fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  })
    .then((response) => {
      return response.json();
    })
    .then((response) => {
      if (typeof response === "string") {
        document.getElementById("message").innerHTML = response;
      } else {
        return response;
      }
    })
    .catch((error) => alert("[BridgeHandler] " + error));
};

export { bridgeHandler };
