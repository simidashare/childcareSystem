const wrapper = document.querySelector('div[id="content-wrapper"]');
const form = document.querySelector('form[name="contact-form"]');
const thankYou = document.querySelector(".thank-you");
const fnameInput = document.querySelector('input[name="fname"]');
const lnameInput = document.querySelector('input[name="lname"]');
const emailInput = document.querySelector('input[name="email"]');
const messageInput = document.querySelector('textarea[name="message"]');

fnameInput.isValid = () => fnameInput.value;
lnameInput.isValid = () => lnameInput.value;
emailInput.isValid = () => isValidEmail(emailInput.value);
messageInput.isValid = () => messageInput.value;

const inputFields = [fnameInput, lnameInput, emailInput, messageInput];

const isValidEmail = (email) => {
  const re =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
};

let shouldValidate = false;
let isFormValid = false;

const validateInputs = () => {
  if (!shouldValidate) return;
  isFormValid = true;
  inputFields.forEach((input) => {
    input.classList.remove("invalid");
    input.nextElementSibling.classList.add("hide");

    if (!input.isValid()) {
      input.classList.add("invalid");
      isFormValid = false;
      input.nextElementSibling.classList.remove("hide");
    }
  });
};
inputFields.forEach((input) => input.addEventListener("input", validateInputs));

let redirectionUrl = () => window.location.replace("../../workon/index.php");
const redicrection = () => setTimeout(redirectionUrl, 5000);
const stopRedicrection = () => {
  redirectionUrl = window.location.replace("../../workon/contact.php");
  clearTimeout(redirectionUrl);
};

form.addEventListener("submit", (e) => {
  e.preventDefault();
  shouldValidate = true;
  validateInputs();
  if (isFormValid) {
    let test = inputFields.map((input) => input.value);
    let dbParam = JSON.stringify(test);
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        responseObj = JSON.parse(this.responseText);

        document.getElementById("result").innerHTML = responseObj;
      }
    };
    xmlhttp.open("POST", "contact-process.php", true);
    xmlhttp.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    xmlhttp.send(dbParam);
    wrapper.remove();
    thankYou.classList.remove("hide");
    redicrection();
  }
});
