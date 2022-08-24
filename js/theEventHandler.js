// addEvent = (el, filePath, ...arrData) => {
//   el.addEventListener("click", () => {
//     function fetchData() {
//       fetch(filePath)
//         .then((response) => response.json())
//         .then((response) => renderQuotes(data));
//     }
//     function renderQuotes(data) {
//       for (const q of data) {
//         //Find the container where we attach everything to      const quoteUL = document.querySelector('#quote-list');//Create all necessary elements      const quoteLi = document.createElement('li');
//         const blockQuote = document.createElement("blockquote");
//         const p = document.createElement("p");
//         const footer = document.createElement("footer");
//         const br = document.createElement("br");
//         const hr = document.createElement("hr"); //Add appropriate classes and ids. Grab data and insert if needed.      quoteLi.className = 'quote-card';          //for styling
//         blockQuote.className = "blockquote"; //for styling
//         p.className = "mb-0"; //for styling
//         footer.className = "blockquote-footer"; //for styling
//         quoteLi.dataset.id = q.id; //Grab data and insert it into created elements      p.innerHTML = q.quote;
//         footer.innerHTML = q.author; //Append everything to main container      blockQuote.append(p, footer, br, hr);
//         quoteLi.append(blockQuote);
//         quoteUL.append(quoteLi);
//       }
//     } //Call the function that will automatically run renderQuote() also    fetchData();
//   });
// };

export default async function handleFormSubmit(event) {
  event.preventDefault();
  const form = event.currentTarget;
  const submiteValue = event.value;
  const url = form.action;

  try {
    console.log("1");
    const formData = new FormData(form);
    formData.append(submiteValue, 1);
    const responseData = await postFormDataAsJson({ url, formData });
    document.getElementById("message").innerHTML = responseData;
  } catch (error) {
    console.error(error);
  }
}

async function postFormDataAsJson({ url, formData }) {
  const plainFormData = Object.fromEntries(formData.entries());
  const formDataJsonString = JSON.stringify();

  const fetchOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
    body: formDataJsonString,
  };
  const response = await fetch(url, fetchOptions);

  if (!response.ok) {
    const errorMessage = await response.json();
    throw new Error(errorMessage);
  }
  return response.json();
}
