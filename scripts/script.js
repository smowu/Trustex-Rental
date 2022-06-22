// Goes to the top of the page
function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// Focus on location search bar
document.addEventListener('DOMContentLoaded', function() {
  if (location.hash === "#listing-body") {
    focusSearch(600);
  }
}, false);

function focusSearch(time) {
  setTimeout(function () {
    document.getElementById("listing-search-bar").focus();
  }, time);
}

// Set a line indicator on the active navigation menu
let links = document.querySelectorAll(".nav-links li");
let bodyId = document.body.id;

for (let link of links) {
  if (link.dataset.active == bodyId) {
    link.classList.add("active");
  }
}

// User menu show/hide functions
$(document).ready( function() {
  $(".profile-icon").click( function() {
    $(".user-menu").fadeToggle(100,"swing");
  });
});

$(document).mouseup(function(e) {
    var menu = $(".user-menu");
    var icon = $(".profile-icon");
    if (!menu.is(e.target) && menu.has(e.target).length == 0 &&
        !icon.is(e.target) && icon.has(e.target).length == 0) {
        menu.fadeOut(100,"swing");
    }
});

// Check sign up infos

function isSignupFormFilled() {

}

function checkUsernameFormat() {

}

function checkEmailFormat() {

}

function checkPasswordFormat() {

}

function checkPasswordConfirmation() {

}

// Check login infos

function isLoginFormFilled() {

}

// Property calculations

function calcPricePerSqf() {

}

// Date calculations

function calcBookingDaysLeft() {

}

// Payment calculations

function calcTotalRentPrice() {

}
