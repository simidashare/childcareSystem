function AddGuardian() {
  var guardianid = document.getElementById("guardian_id").value;
  var familyid = document.getElementById("family_id").value;
  if (guardianid == "") {
    alert("Guardian id is required");
  } else if (isNaN(guardianid)) {
    alert("Guardian id must be a number");
  } else if (familyid == "") {
    alert("Please key in the family id in the family input field");
  } else if (isNaN(familyid)) {
    alert("Family id must be a number");
  } else {
    let form = document.querySelector("#guardianform");
    const data = new FormData(form);
    fetch("guardian-process.php?add=1", {
      method: "POST",
      body: data,
    })
      .then((response) => response.text())
      .then((response) => {
        document.getElementById("message").innerHTML = response;
      })
      .catch((error) => console.log("x" + error));
  }
  return false;
}

function UpdateGuardian() {
  var guardianid = document.getElementById("guardian_id").value;
  var familyid = document.getElementById("family_id").value;
  if (guardianid == "") {
    alert("Guardian id is required");
  } else if (isNaN(guardianid)) {
    alert("Guardian id must be a number");
  } else if (familyid == "") {
    alert("Please key in the family id in the family input field");
  } else if (isNaN(familyid)) {
    alert("Family id must be a number");
  } else {
    let form = document.querySelector("#guardianform");
    const data = new FormData(form);
    fetch("guardian-process.php?update=1", {
      method: "POST",
      body: data,
    })
      .then((response) => response.text())
      .then((response) => {
        document.getElementById("message").innerHTML = response;
      })
      .catch((error) => console.log("x" + error));
  }
  return false;
}

function SearchGuardian() {
  var guardianid = document.getElementById("guardian_id").value;
  if (guardianid == "") {
    alert("Guardian id is required");
    return false;
  } else if (isNaN(guardianid)) {
    alert("Guardian id must be a number");
    return false;
  } else {
    fetch(
      "guardian-process.php?" +
        new URLSearchParams({
          search: "1",
          guardian_id: guardianid,
        })
    )
      .then((response) => response.json())
      .then((response) => {
        if (response.length != 0) {
          DisplaySearchGuardian(response);
          document.getElementById("message").innerHTML = "";
        } else {
          document.getElementById("message").innerHTML =
            "This Guardian does not exist";
          document.getElementById("guardian_fname").value = "";
          document.getElementById("guardian_lname").value = "";
          document.getElementById("guardian_address").value = "";
          document.getElementById("guardian_phone").value = "";
          document.getElementById("family_id").value = "";
        }
      })
      .catch((error) => console.log("x" + error));
  }
  return false;
}

function DeleteGuardian() {
  var guardianid = document.getElementById("guardian_id").value;
  if (guardianid == "") {
    alert("Guardian id is required");
    return false;
  } else if (isNaN(guardianid)) {
    alert("Guardian id must be a number");
    return false;
  } else {
    fetch(
      "guardian-process.php?" +
        new URLSearchParams({
          remove: "1",
          guardian_id: guardianid,
        })
    )
      .then((response) => response.text())
      .then((response) => {
        document.getElementById("message").innerHTML = response;
        document.getElementById("guardian_id").value = "";
        document.getElementById("guardian_fname").value = "";
        document.getElementById("guardian_lname").value = "";
        document.getElementById("guardian_address").value = "";
        document.getElementById("guardian_phone").value = "";
        document.getElementById("family_id").value = "";
      })
      .catch((error) => console.log("x" + error));
  }
  return false;
}
function ViewAll() {
  fetch("guardian-process.php?viewall=1")
    .then((response) => response.json())
    .then((response) => {
      DisplayGuardian(response);
    })
    .catch((error) => console.log("x" + error));
  return false;
}

function DisplaySearchGuardian(jsonArr) {
  jsonArr.forEach((element) => {
    document.getElementById("guardian_id").value = element.guardian_id;
    document.getElementById("guardian_fname").value = element.guardian_fname;
    document.getElementById("guardian_lname").value = element.guardian_lname;
    document.getElementById("guardian_address").value =
      element.guardian_address;
    document.getElementById("guardian_phone").value = element.guardian_phone;
    document.getElementById(
      "family_id"
    ).value = `${element.family_id} - ${element.family_name}`;
  });
}

function DisplayGuardian(jsonArr) {
  if (jsonArr.length == 0) {
    str = "There are no guardian";
  } else {
    var str = "<br/>";
    jsonArr.sort(ObjectArraySort("guardian_fname"));
    str += "<div class='table-responsive-sm'>";
    str += "<table class='table table-striped table-hover table-bordered'>";
    str += "<br/>";
    str += "<tr scope='row'>";
    str +=
      "<div class='form-control' style='font-size:1.5rem;color:blue; text-align:center'>List of Guardians</div>";
    str += "</tr>";
    str += "<tr scope='row'>";
    str += "<th scope='col'>Guardian ID</th>";
    str += "<th scope='col'>Guardian First Name</th>";
    str += "<th scope='col'>Guardian Last Name</th>";
    str += "<th scope='col'>Guardian Address</th>";
    str += "<th scope='col'>Guardian Phone</th>";
    str += "<th scope='col'>Family</th>";
    str += "</tr>";
    jsonArr.forEach((element) => {
      str += "<tr scope='row'>";
      str += "<td>" + element.guardian_id + "</td>";
      str += "<td>" + element.guardian_fname + "</td>";
      str += "<td>" + element.guardian_lname + "</td>";
      str += "<td>" + element.guardian_address + "</td>";
      str += "<td>" + element.guardian_phone + "</td>";
      str += `<td value="${element.family_id}">${element.family_id}- ${element.family_name} </td>`;
    });
  }
  document.getElementById("message").innerHTML = str;
}

function ObjectArraySort(key, order = "asc") {
  return function innerSort(a, b) {
    if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
      return 0;
    }
    const varA = typeof a[key] === "string" ? a[key].toUpperCase() : a[key];
    const varB = typeof b[key] === "string" ? b[key].toUpperCase() : b[key];

    let comparison = 0;

    if (varA > varB) {
      comparison = 1;
    } else if (varA < varB) {
      comparison = -1;
    }
    return order === "desc" ? comparison * -1 : comparison;
  };
}
