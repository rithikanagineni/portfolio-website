function showMessage() {
  alert("Welcome to Rithika's Portfolio 🚀");
}

function validateForm() {
  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;
  let message = document.getElementById("message").value;

  if (name === "" || email === "" || message === "") {
    alert("Please fill all fields");
    return false;
  }

  alert("Form submitted successfully!");
  return true;
}

console.log("Portfolio loaded successfully");
