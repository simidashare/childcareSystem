import { displayBridgeContent } from "./bridgeLoadDisplay.js";
const loadChild = (domReference) => {
  fetch("bridgeLoad-process.php?loadChild=1")
    .then((response) => response.json())
    .then((response) => {
      displayBridgeContent(response, null, null, null, domReference);
    })
    .catch((error) => console.log("x " + error));
};
const loadStaff = (domReference) => {
  if (domReference) {
    fetch("bridgeLoad-process.php?loadStaff=1")
      .then((response) => response.json())
      .then((response) => {
        displayBridgeContent(response, null, null, null, null, domReference);
      })
      .catch((error) => console.log("x " + error));
  }
};

const loadGuardian = (domReference) => {
  if (domReference) {
    fetch("bridgeLoad-process.php?loadGuardian=1")
      .then((response) => response.json())
      .then((response) => {
        displayBridgeContent(
          response,
          null,
          null,
          null,
          null,
          null,
          domReference
        );
      })
      .catch((error) => console.log("x bridgeLoad " + error));
  }
};

const loadAllergy = (domReference) => {
  fetch("bridgeLoad-process.php?loadAllergy=1")
    .then((response) => response.json())
    .then((response) => {
      displayBridgeContent(
        response,
        null,
        null,
        null,
        null,
        null,
        null,
        domReference
      );
    })
    .catch((error) => console.log("x " + error));
};

const loadFamily = (domReference) => {
  if (domReference) {
    fetch("bridgeLoad-process.php?loadFamily=1")
      .then((response) => response.json())
      .then((response) => {
        displayBridgeContent(
          response,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          domReference
        );
      })
      .catch((error) => console.log("x bridgeLoad " + error));
  }
};
const loadDoctor = (domReference) => {
  if (domReference) {
    fetch("bridgeLoad-process.php?loadDoctor=1")
      .then((response) => response.json())
      .then((response) => {
        displayBridgeContent(
          response,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          domReference
        );
      })
      .catch((error) => console.log("x bridgeLoad " + error));
  }
};

const loadMedicine = (domReference) => {
  if (domReference) {
    fetch("bridgeLoad-process.php?loadMedicine=1")
      .then((response) => response.json())
      .then((response) => {
        displayBridgeContent(
          response,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          domReference
        );
      })
      .catch((error) => console.log("x bridgeLoad " + error));
  }
};

const loadEnrolment = (domReference) => {
  if (domReference) {
    fetch("bridgeLoad-process.php?loadEnrolment=1")
      .then((response) => response.json())
      .then((response) => {
        // console.log(response);
        displayBridgeContent(
          response,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          domReference
        );
      })
      .catch((error) => console.log("x bridgeLoad " + error));
  }
};

export {
  loadChild,
  loadStaff,
  loadAllergy,
  loadGuardian,
  loadFamily,
  loadDoctor,
  loadMedicine,
  loadEnrolment,
};
