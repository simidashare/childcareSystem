window.addEventListener("load", (e) => {
  fetch("family-process.php?loadId=1")
    .then((response) => response.json())
    .then((response) => {
      displayFamilyId(response);
    })
    .catch((error) => alert("x" + error));
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

function displayFamilyId(arr) {
  var content = "";
  content += "<option value>Select Family Id</option>";
  arr.forEach((e) => {
    content += `<option value="${e.family_id}">${e.family_id} - ${e.family_name}</option>`;
  });
  document.getElementById("family_id_load").innerHTML = content;
}

function ViewAll() {
  fetch("family-process.php?viewAll=1")
    .then((response) => response.json())
    .then((response) => {
      Displayfamily(response);
    })
    .catch((error) => alert("viewAll" + error));
  return false;
}

function AddFamily() {
  var family_name = document.getElementById("family_name").value;
  if (family_name === "") {
    alert("Family name fields must not be blank");
  } else {
    let form = document.querySelector("#familyform");
    const data = new FormData(form);
    fetch("family-process.php?add=1", {
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

function UpdateFamily() {
  var family_id = document.getElementById("family_id_load").value;
  var family_name = document.getElementById("family_name").value;
  if (family_id === "") {
    alert("family Id is required");
    return false;
  } else if (family_name === "") {
    alert("Family name is required");
    return false;
  } else {
    let form = document.querySelector("#familyform");
    const data = new FormData(form);
    fetch("family-process.php?update=1", {
      method: "POST",
      body: data,
    })
      .then((response) => response.text())
      .then((response) => {
        document.getElementById("message").innerHTML = response;
        document.getElementById("family_name").value = "";
        document.getElementById("family_id_load").value = "";
      })
      .catch((error) => console.log("x" + error));
  }
  return false;
}

function SearchFamily() {
  var familyId = document.getElementById("family_id_load").value;
  if (familyId === "") {
    alert("Family id is required");
    return false;
  } else {
    let form = document.querySelector("#familyform");
    const data = new FormData(form);
    fetch("family-process.php?search=1", {
      method: "POST",
      body: data,
    })
      .then((response) => response.json())
      .then((response) => {
        if (typeof response == "string") {
          document.getElementById("message").innerHTML = response;
          return false;
        }
        DisplaySearchfamily(response);
        document.getElementById("message").innerHTML = "";
        return false;
      })
      .catch((error) => alert("x" + error));
  }
  return false;
}

function Deletefamily() {
  var familyId = document.getElementById("family_id_load").value;
  if (familyId == "") {
    alert("family id is required");
    return false;
  } else if (isNaN(familyId)) {
    alert("family id must be a number");
    return false;
  } else {
    let form = document.querySelector("#familyform");
    const data = new FormData(form);
    fetch("family-process.php?remove=1", {
      method: "POST",
      body: data,
    })
      .then((response) => response.text())
      .then((response) => {
        document.getElementById("message").innerHTML = response;
        document.getElementById("family_name").value = "";
        document.getElementById("family_id_load").value = "";
      })
      .catch((error) => alert("x" + error));
  }
  return false;
}

function DisplaySearchfamily(jsonArr) {
  document.getElementById("family_id_load").value = "";
  document.getElementById("family_name").value = "";
  jsonArr.forEach((element) => {
    document.getElementById("family_id_load").value = element.family_id;
    document.getElementById("family_name").value = element.family_name;
  });
}

function Displayfamily(arr) {
  if (arr.length == 0) {
    str = "There are no family";
  } else {
    var str = "<br/>";
    str += "<div class='table-responsive-sm'>";
    str += "<table class='table table-striped table-hover table-bordered'>";
    str += "<br/>";
    str += "<tr scope='row'>";
    str +=
      "<div class='form-control' style='font-size:1.5rem;color:blue; text-align:center'>List of Family</div>";
    str += "</tr>";
    str += "<tr scope='row'>";
    str += "<th scope='col'>Family ID</th>";
    str += "<th scope='col'>Family Name</th>";
    str += "</tr>";
    arr.forEach((element) => {
      str += "<tr scope='row'>";
      str += "<td>" + element.family_id + "</td>";
      str += "<td>" + element.family_name + "</td>";
      str += "</tr>";
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
