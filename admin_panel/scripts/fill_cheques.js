function write_value(source_id, dest_id, currancy = "QAR") {
  source_ele = document.getElementById(source_id);
  dest_ele = document.getElementById(dest_id);
  let currancy_word = "";

  if (dest_id == "output_the_amount_numbers") {
    dest_ele.innerText = `##${source_ele.value}##`;

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
    output_div.innerText = words + " " + currancy_word + " Only";

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

function numberToWords(number) {
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

  // Function to convert a number less than 1000 to words
  function convertLessThanOneThousand(number) {
    if (number < 10) {
      return units[number];
    } else if (number < 20) {
      return teens[number - 10];
    } else if (number < 100) {
      return tens[Math.floor(number / 10)] + " " + units[number % 10];
    } else {
      return (
        units[Math.floor(number / 100)] +
        " Hundred " +
        convertLessThanOneThousand(number % 100)
      );
    }
  }

  // Function to convert a number to words
  function convert(number) {
    if (number === 0) {
      return "Zero";
    } else {
      let result = "";

      // Handle billions, millions, thousands
      if (Math.floor(number / 1000000000) > 0) {
        result +=
          convertLessThanOneThousand(Math.floor(number / 1000000000)) +
          " Billion ";
        number %= 1000000000;
      }
      if (Math.floor(number / 1000000) > 0) {
        result +=
          convertLessThanOneThousand(Math.floor(number / 1000000)) +
          " Million ";
        number %= 1000000;
      }
      if (Math.floor(number / 1000) > 0) {
        console.log(Math.floor(number / 1000));
        result +=
          convertLessThanOneThousand(Math.floor(number / 1000)) + " Thousand ";
        number %= 1000;
      }

      // Check if there's a remainder after handling thousands
      if (number > 0) {
        result += convertLessThanOneThousand(number);
      }

      return result.trim(); // Trim any extra spaces at the end
    }
  }

  // Call the convert function with the provided number
  return convert(number);
}
