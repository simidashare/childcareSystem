import { controller, loadAllergy, resetChildContent } from "./controller.js";

window.addEventListener("load", (e) => {
  loadAllergy();
});

(function () {
  let cid = document.getElementById("child_id");
  let cfn = document.getElementById("child_fname");
  let cln = document.getElementById("child_lname");
  let cdob = document.getElementById("child_dob");
  let cAlle = document.getElementById("childAllergy");
  let cgen = document.getElementsByName("child_gender");

  let addChild = document.getElementById("addChild");
  let removeChild = document.getElementById("removeChild");
  let viewAllChild = document.getElementById("viewAllChild");
  let updateChild = document.getElementById("updateChild");
  let searchChild = document.getElementById("searchChild");

  const validateChildId = (cid) => {
    if (!cid.value) {
      alert("Please enter child id");
      return false;
    }
    return true;
  };

  const validateOthers = (cfn, cln, cdob, gen) => {
    if (!cfn.value || !cln.value || !cdob.value || !gen) {
      alert(`Please enter the first name, last name, date of birth and gender`);
      return false;
    }
    return true;
  };
  const checkRadioButton = (ele) => {
    for (let i = 0; i < ele.length; i++) {
      if (ele[i].checked) {
        return ele[i].value;
      } //do not return false if there is no checked radio. otherwise will cause bug
    }
  };
  addChild.addEventListener("click", (e) => {
    e.preventDefault();
    document.getElementById("message").innerHTML = "";
    const gen = checkRadioButton(cgen);
    const chkArg = validateOthers(cfn, cln, cdob, gen);
    if (chkArg) {
      let obj = {
        child_fname: cfn.value,
        child_lname: cln.value,
        child_dob: cdob.value,
        child_gender: gen,
        alle_code: cAlle.value,
      };
      let url = "../auth/child-process.php?add=1&addAlle=1";
      controller(url, obj);
      loadAllergy();
      resetChildContent();
    }
  });

  viewAllChild.addEventListener("click", (e) => {
    e.preventDefault();
    document.getElementById("message").innerHTML = "";
    let url = "../auth/child-process.php?viewAll=1&viewAllAlle=1";
    controller(url);
    loadAllergy();
  });

  updateChild.addEventListener("click", (e) => {
    e.preventDefault();
    document.getElementById("message").innerHTML = "";
    const gen = checkRadioButton(cgen);
    const chkCid = validateChildId(cid);
    const chkArg = validateOthers(cfn, cln, cdob, gen);
    if (chkArg && chkCid) {
      let obj = {
        child_id: cid.value,
        child_fname: cfn.value,
        child_lname: cln.value,
        child_dob: cdob.value,
        child_gender: gen,
        alle_code: cAlle.value,
      };
      let url = "../auth/child-process.php?update=1";
      controller(url, obj);
      loadAllergy();
      resetChildContent();
    }
  });

  removeChild.addEventListener("click", (e) => {
    e.preventDefault();
    const chkCid = validateChildId(cid);
    if (chkCid) {
      let obj = {
        child_id: cid.value,
        alle_code: cAlle.value,
      };
      let url = "../auth/child-process.php?remove=1&removeAlle=1";
      controller(url, obj);
      loadAllergy();
      resetChildContent();
    }
  });

  searchChild.addEventListener("click", (e) => {
    e.preventDefault();
    const chkArg = validateChildId(cid);
    if (chkArg) {
      let obj = {
        child_id: cid.value,
      };
      let url = "../auth/child-process.php?search=1";
      controller(url, obj, true);
    }
  });
})();
