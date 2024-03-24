function write_value(source_id, dest_id, currancy = "QAR") {
  source_ele = document.getElementById(source_id);
  dest_ele = document.getElementById(dest_id);
  let currancy_word = "";

  if (dest_id == "output_cheque_date") {
    const options = { month: "2-digit", day: "2-digit", year: "numeric" };
    let formated_date = new Date(source_ele.value).toLocaleDateString(
      "en-US",
      options
    );

    dest_ele.innerText = formated_date;
  } else if (dest_id == "output_the_amount_numbers") {
    dest_ele.innerText = `#${source_ele.value}#`;

    let mynumber = source_ele.value;
    console.log(mynumber);
    const words = numberToWords(mynumber);
    console.log(words);
    let output_div = document.getElementById("output_the_amount_words");
    let input_amount_words = document.getElementById("input_amount_words");
    if (currancy == "QAR") {
      currancy_word = "Qatari Riyals";
    }
    if (currancy == "USD") {
      currancy_word = "American Dollar";
    }
    output_div.innerText = "#" + words + " " + currancy_word + " Only#";

    input_amount_words.value = words;
  } else {
    dest_ele.innerText = source_ele.value;
  }
}

function reset_data() {
  let form = document.getElementById("cheque_data_form");
  form.reset();
  let cells = document.querySelectorAll(".data_cell");
  cells.forEach((cell) => {
    cell.innerText = "";
  });
}

function numberToWords(amount) {
  // Define arrays for words representation
  const units = [
    "",
    "One",
    "Two",
    "Three",
    "Four",
    "Five",
    "Six",
    "Seven",
    "Eight",
    "Nine",
  ];
  const teens = [
    "",
    "Eleven",
    "Twelve",
    "Thirteen",
    "Fourteen",
    "Fifteen",
    "Sixteen",
    "Seventeen",
    "Eighteen",
    "Nineteen",
  ];
  const tens = [
    "",
    "Ten",
    "Twenty",
    "Thirty",
    "Forty",
    "Fifty",
    "Sixty",
    "Seventy",
    "Eighty",
    "Ninety",
  ];
  const scales = ["", "Thousand", "Million", "Billion"];

  function toWords(num) {
    if (num === 0) return "Zero";
    let words = "";
    for (let i = 0; i < scales.length; i++) {
      if (num % 1000 !== 0) {
        words = `${parseHundreds(num % 1000)} ${scales[i]} ${words}`;
      }
      num = Math.floor(num / 1000);
    }
    return words.trim();
  }

  function parseHundreds(num) {
    let words = "";
    const hundreds = Math.floor(num / 100);
    const tensUnits = num % 100;
    if (hundreds !== 0) {
      words += `${units[hundreds]} Hundred `;
    }
    if (tensUnits !== 0) {
      if (tensUnits < 10) {
        words += `${units[tensUnits]} `;
      } else if (tensUnits < 20) {
        words += `${teens[tensUnits - 10]} `;
      } else {
        words += `${tens[Math.floor(tensUnits / 10)]} ${
          units[tensUnits % 10]
        } `;
      }
    }
    return words.trim();
  }

  // Split amount into integer and fractional parts
  const parts = amount.toString().split(".");
  let result = toWords(parseInt(parts[0])) + " dollars";

  if (parts.length === 2) {
    // Deal with fractional part
    const cents = parseInt(parts[1]);
    let centsWords = "";
    if (cents !== 0) {
      if (cents < 10) {
        centsWords = `${units[cents]} cents`;
      } else if (cents < 20) {
        centsWords = `${teens[cents - 10]} cents`;
      } else {
        centsWords = `${tens[Math.floor(cents / 10)]} ${
          units[cents % 10]
        } cents`;
      }
    }
    result += ` and ${centsWords}`;
  }

  // Call the convert function with the provided number
  return result;
}
