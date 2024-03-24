function printCheque() {
  // console.log(date_fsize);

  printSingleCheque(
    [],
    date_fsize,
    name_fsize,
    amnc_fsize,
    amw_fsize,
    crossing_fsize
  );
  /*let end_date = document.getElementById("input_cheque_end_date");
  let due_date = document.getElementById("input_cheque_date"); //start date
  if (end_date.value == "" || end_date == null) {
    //console.log("single print");
    printSingleCheque();
  } else {
    //multi print code
    // console.log("multi print");
    let dates = getDatesBetween(
      new Date(due_date.value),
      new Date(end_date.value)
    );
    printSingleCheque(dates);
  }*/
}
/*

*/
async function changeDate(mydate) {
  return new Promise((resolve, reject) => {
    console.log("stage1");

    document.getElementById("output_cheque_date").innerText = mydate;
    resolve();
  });
}
function printSingleCheque(
  dates_list = [],
  date_fsize,
  name_fsize,
  amnc_fsize,
  amw_fsize,
  crossing_fsize
) {
  let cells = document.querySelectorAll(".data_cell");
  let data = {
    date: [],
    rname: [],
    amountn: [],
    amountw: [],
    crossing: [],
  };
  data.date = [
    cells[0].getBoundingClientRect().x,
    cells[0].getBoundingClientRect().y,
  ];

  data.rname = [
    cells[1].getBoundingClientRect().x,
    cells[1].getBoundingClientRect().y,
  ];
  data.amountn = [
    cells[2].getBoundingClientRect().x,
    cells[2].getBoundingClientRect().y,
  ];
  data.amountw = [
    cells[3].getBoundingClientRect().x,
    cells[3].getBoundingClientRect().y,
  ];
  data.crossing = [
    cells[4].getBoundingClientRect().x,
    cells[4].getBoundingClientRect().y,
  ];

  let cssRule = setCSS(
    data,
    date_fsize,
    name_fsize,
    amnc_fsize,
    amw_fsize,
    crossing_fsize
  );
  if (dates_list.length == 0) {
    console.log(cssRule);
    printJS({
      printable: "warapper_data_cell",
      type: "html",
      style: cssRule,
    });
  }

  /*
  console.log("the date array is " + dates_list.length);
  if (dates_list.length == 0) {
  } else {
  }

  printJS({
    printable: "warapper_data_cell",
    type: "html",
    style: cssRule,
  });*/
}
/*
async function printAllCheque(data) {
  return new Promise(async (resolve, reject) => {
    console.log("stage2");
    let cssRule = setCSS(data);

    printJS({
      printable: "warapper_data_cell",
      type: "html",
      style: cssRule,
    });
    resolve();
  });
}
*/
function getDatesBetween(startDate, endDate) {
  let dates = [];

  while (startDate <= endDate) {
    const options = { month: "2-digit", day: "2-digit", year: "numeric" };
    dates.push(new Date(startDate).toLocaleDateString("en-US", options));
    startDate.setMonth(startDate.getMonth() + 1);
  }
  console.log(dates);

  return dates;
}
function getPosDimension() {
  let cells = document.querySelectorAll(".data_cell");

  console.log("=============DATE===============");
  console.log(cells[0].getBoundingClientRect().x);
  console.log(cells[0].getBoundingClientRect().y);

  console.log("============NAME================");
  console.log(cells[1].getBoundingClientRect().x);
  console.log(cells[1].getBoundingClientRect().y);

  console.log("==============AMOUNT N==============");
  console.log(cells[2].getBoundingClientRect().x);
  console.log(cells[2].getBoundingClientRect().y);

  console.log("==============AMOUNT W==============");
  console.log(cells[3].getBoundingClientRect().x);
  console.log(cells[3].getBoundingClientRect().y);
}

function setCSS(
  data,
  date_fsize,
  name_fsize,
  amnc_fsize,
  amw_fsize,
  crossing_fsize
) {
  //let conv = 0.06;
  console.log(data);
  //console.log(data.date[0] + " SS " + data.date[1]);
  //36,24 vw
  let bas_fsize = 18;
  var cssRule = `
      @media print {
        #warapper_data_cell{
          margin-left:36vw;
          margin-top:24vw;
          transform:rotate(1deg);
          width: 20cm;
          height: 7cm;
          font-size: ${bas_fsize}px;
        }

       .data_cell{
          margin:0;
          -webkit-transform: none;
          transform: none;
          position: absolute;
          font-size:1em;
        }
        #output_cheque_date {
            width: fit-content;
            font-size:${date_fsize * bas_fsize}px;
            transform: translate(${data.date[0]}px, ${data.date[1]}px);
        }
        #output_the_recipent_name {
            width: fit-content;
            font-size:${name_fsize * bas_fsize}px;

            transform: translate(${data.rname[0]}px, ${data.rname[1]}px);

        }
        #output_the_amount_numbers {
            font-size:${amnc_fsize * bas_fsize}px;

            transform: translate(${data.amountn[0]}px, ${data.amountn[1]}px);

            max-width: 8rem;
        }
        #output_the_amount_words {
            max-width: 18.5rem;
            font-size:${amw_fsize * bas_fsize}px;

            transform: translate(${data.amountw[0]}px, ${data.amountw[1]}px);
        }
        #output_crossing{
          border-top: 2px solid black;
          border-bottom: 2px solid black;
          font-size:${crossing_fsize * bas_fsize}px;

          transform: translate(${data.crossing[0]}px, 
            ${data.crossing[1]}px) rotate(-30deg);
        }


      }
      `;

  return cssRule;
}

/*
       
*/
