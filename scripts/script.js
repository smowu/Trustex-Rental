// Goes to the top of the page
function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// Set a line indicator on the active navigation menu
let links = document.querySelectorAll(".nav-links li");
let bodyId = document.body.id;

for (let link of links) {
  if (link.dataset.active == bodyId) {
    link.classList.add("active");
  }
}


function checkUsernameFormat() {

}

function checkEmailFormat() {

}

function checkPasswordFormat() {

}

function checkPasswordConfirmation() {

}