const loadAllergy = () => {
  fetch("child-process.php?loadAllergy=1")
    .then((response) => response.json())
    .then((response) => {
      displayContent(response);
    })
    .catch((error) => alert("x" + error));
};

function displayContent(arr) {
  let content = "";
  if (arr[0]["alle_code"]) {
    content += `<option value="-1">Please Select</option>`;
    arr.forEach((e) => {
      content += `<option value='${e.alle_code}' id='alle_code'>${e.alle_code} - ${e.alle_description}</option>`;
    });
    document.getElementById("childAllergy").innerHTML = content;
  }
}

const controller = (url, obj = null, search = null) => {
  let data = JSON.stringify({
    obj,
  });

  fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  })
    .then((response) => response.json())
    .then((response) => {
      if (!obj) {
        displayViewAll(response);
        resetChildContent();
        return;
      }
      if (search) {
        resetChildContent();
        document.getElementById("message").innerHTML = "";
        if (typeof response === "string") {
          document.getElementById("message").innerHTML = response;
        } else {
          displaySearch(response);
        }
        return;
      }
      document.getElementById("message").innerHTML = response;
      resetChildContent();
    })
    .catch((error) => alert("[Controller]] " + error));
};

const resetChildContent = () => {
  document.querySelector(".gender_male").checked = "";
  document.querySelector(".gender_female").checked = "";
  document.querySelector(".gender_others").checked = "";
  document.getElementById("child_id").value = "";
  document.getElementById("child_fname").value = "";
  document.getElementById("child_lname").value = "";
  document.getElementById("child_dob").value = "";
};

const displayViewAll = (jsonArr) => {
  let str;
  if (jsonArr.length == 0) {
    str = "Nothing in this table";
  } else {
    str = "<br/>";
    str += "<div class='table-responsive-sm'>";
    str += "<table class='table table-striped table-hover table-bordered'>";
    str += "<br/>";
    str += "<tr scope='row'>";
    str +=
      "<div class='form-control' style='font-size:1.5rem;color:blue; text-align:center'>View All</div>";
    str += "</tr>";
    str += "<tr scope='row'>";
    str += "<th scope='col'>ID</th>";
    str += "<th scope='col'>First Name</th>";
    str += "<th scope='col'>Last Name</th>";
    str += "<th scope='col'>Date of Birth</th>";
    str += "<th scope='col'>Gender</th>";
    str += "<th scope='col'>Allergy</th>";
    str += "</tr>";
    for (let i = 0; i < jsonArr.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonArr[i]["ID"] + "</td>";
      str += "<td>" + jsonArr[i]["First Name"] + "</td>";
      str += "<td>" + jsonArr[i]["Last Name"] + "</td>";
      str += "<td>" + jsonArr[i]["Date of Birth"] + "</td>";
      str += "<td>" + jsonArr[i]["Gender"] + "</td>";
      str += "<td>" + jsonArr[i]["Allergy"] + "</td>";
      str += "</tr>";
    }
  }
  document.getElementById("message").innerHTML = str;
};

const displaySearch = (jsonArr) => {
  if (jsonArr.length == 0) {
    document.getElementById("message").innerHTML = "No record found";
  } else {
    jsonArr.forEach((element) => {
      document.getElementById("child_id").value = element.child_id;
      document.getElementById("child_fname").value = element.child_fname;
      document.getElementById("child_lname").value = element.child_lname;
      document.getElementById("child_dob").value = element.child_dob;
      if (element.child_gender == "F") {
        document.querySelector(".gender_female").checked = "checked";
      } else if (element.child_gender == "M") {
        document.querySelector(".gender_male").checked = "checked";
      } else {
        document.querySelector(".gender_others").checked = "checked";
      }
      let sel = document.getElementById("childAllergy");
      getArrValues(sel, jsonArr);
    });
  }
};

const getArrValues = (sel, jsonArr) => {
  let alle_code = jsonArr[0]["alle_code"];
  let opt;
  for (let i = 0, len = sel.options.length; i < len; i++) {
    opt = sel.options[i];
    if (opt.value === alle_code) {
      // opt.setAttribute("selected","selected" )
      opt.selected = "selected";
      return opt;
    }
  }
};

export { controller, resetChildContent, loadAllergy };
