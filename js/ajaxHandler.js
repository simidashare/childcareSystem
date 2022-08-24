const ajaxHandler = (url, obj = null, search = null) => {
  let data = JSON.stringify({
    obj,
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
    .catch((error) => alert("[AjaxHandler] " + error));
};

export { ajaxHandler };
