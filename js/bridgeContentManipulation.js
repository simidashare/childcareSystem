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

const getSelectedOptionValues = (sel, jsonObj) => {
  let opt;
  for (let i = 0, len = sel.options.length; i < len; i++) {
    opt = sel.options[i];
    if (opt.value === jsonObj) {
      opt.selected = "selected";
      return opt;
    }
  }
};

const getArrValues = (sel) => {
  var result = [];
  var opt;
  for (var i = 0, len = sel.options.length; i < len; i++) {
    opt = sel.options[i];
    if (opt.selected) {
      result.push(opt.value || opt.text); // Make a remark here for debugging
      console.log(result);
    }
  }
  return result;
};

const getCheckBoxValues = (nl) => {
  let result = [];
  for (let i = 0, len = nl.length; i < len; i++) {
    if (nl[i].checked) {
      result.push(nl[i].value);
    }
  }
  return result;
};

const checkRadioButton = (ele) => {
  for (let i = 0; i < ele.length; i++) {
    if (ele[i].checked) {
      return ele[i].value;
    } //do not return false if there is no checked radio. otherwise will cause bug
  }
};

class paymentRelatedHandlers {
  constructor(start, end) {
    this.start = start;
    this.end = end;
  }

  startDateFormatCheck = () => {
    return moment(this.start, `YYYY-MM-DD`, true).isValid();
  };

  endDateFormatCheck = () => {
    return moment(this.end, `YYYY-MM-DD`, true).isValid();
  };

  dayChecker = () => {
    let startDate = new Date(this.start);
    let endDate = new Date(this.end);
    let dayDiff = 0;
    let days = 1000 * 60 * 60 * 24;

    dayDiff = endDate - startDate;
    let result = Math.floor(dayDiff / days);
    return result;
  };
}

export {
  getOptionValue,
  getArrValues,
  checkRadioButton,
  getCheckBoxValues,
  getSelectedOptionValues,
  paymentRelatedHandlers,
};
