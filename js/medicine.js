import { ajaxHandler } from "./ajaxHandler.js";

let add = document.getElementById("add");
let remove = document.getElementById("remove");
let search = document.getElementById("search");
let update = document.getElementById("update");
let viewAll = document.getElementById("viewAll");

let mid = document.getElementById("med_id");
let mn = document.getElementById("med_name");
let mdo = document.getElementById("med_dosage");
let mds = document.getElementById("med_description");

search.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidMid = validateId(mid);
  if (chkValidMid) {
    let obj = {
      med_id: mid.value,
    };
    let url = "../auth/medicine-process.php?search=1";
    let searchResult = ajaxHandler(url, obj);
    searchResult.then((res) => {
      displaySearch(res);
    });
  }
});

remove.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidMid = validateId(mid);
  if (chkValidMid) {
    let obj = {
      med_id: mid.value,
    };
    let url = "../auth/medicine-process.php?remove=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

add.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidity = validateOthers(mn, mdo, mds);
  if (chkValidity) {
    let obj = {
      med_name: mn.value,
      med_dosage: mdo.value,
      med_description: mds.value,
    };
    let url = "../auth/medicine-process.php?add=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

update.addEventListener("click", (e) => {
  e.preventDefault();
  document.getElementById("message").innerHTML = "";
  const chkValidDid = validateId(mid);
  const chkValidity = validateOthers(mn, mdo, mds);
  if (chkValidity && chkValidDid) {
    let obj = {
      med_id: mid.value,
      med_name: mn.value,
      med_dosage: mdo.value,
      med_description: mds.value,
    };
    let url = "../auth/medicine-process.php?update=1";
    ajaxHandler(url, obj);
    clearContent();
  }
});

viewAll.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "../auth/medicine-process.php?viewAll=1";
  let viewAllMedicine = ajaxHandler(url);
  viewAllMedicine.then((res) => {
    medicineViewAll(res);
  });
  clearContent();
});

const displaySearch = (jsonObj) => {
  document.getElementById("med_id").value = jsonObj[0].med_id;
  document.getElementById("med_name").value = jsonObj[0].med_name;
  document.getElementById("med_dosage").value = jsonObj[0].med_dosage;
  document.getElementById("med_description").value = jsonObj[0].med_description;
};

const medicineViewAll = (jsonObj) => {
  let str;
  if (jsonObj.length === 0) {
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
    str += "<th scope='col'>Medicine ID</th>";
    str += "<th scope='col'>Medicine Name</th>";
    str += "<th scope='col'>Dosage</th>";
    str += "<th scope='col'>Description</th>";
    str += "</tr>";
    for (let i = 0; i < jsonObj.length; i++) {
      str += "<tr scope='row'>";
      str += "<td>" + jsonObj[i]["med_id"] + "</td>";
      str += "<td>" + jsonObj[i]["med_name"] + "</td>";
      str += "<td>" + jsonObj[i]["med_dosage"] + "</td>";
      str += "<td>" + jsonObj[i]["med_description"] + "</td>";
      str += "</tr>";
    }
  }

  document.getElementById("message").innerHTML = str;
};

const validateId = (mid) => {
  if (!mid.value) {
    alert("Please enter Medicine Id");
    return false;
  }
  return true;
};

const validateOthers = (mn, mdo, mds) => {
  if (!mn.value || !mdo.value || !mds.value) {
    alert(`Medicine name, dosage, description are required`);
    return false;
  }
  return true;
};

const clearContent = () => {
  document.getElementById("med_id").value = "";
  document.getElementById("med_name").value = "";
  document.getElementById("med_dosage").value = "";
  document.getElementById("med_description").value = "";
};
