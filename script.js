function showMessage() {
  alert("Welcome to Rithika's Portfolio 🚀");
}

function validateForm() {
  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;

  if (name === "" || email === "") {
    alert("Please fill all fields");
    return false;
  }

  alert("Form submitted successfully!");
  return true;
}

console.log("Portfolio loaded successfully");
