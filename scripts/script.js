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

// Toggle image upload form
function toggleImageForm(original) {
  $(".image-upload-overlay").fadeToggle(100,"swing");
  if (onerror != null) {
    $('.image-upload-form .profile-pic').attr('src', original);
  }
  
}

$(document).mouseup(function(e) {
  var uploadform = $(".image-upload-form");
  var container = $(".image-upload-overlay");
  if (!uploadform.is(e.target) && uploadform.has(e.target).length == 0) {
    container.fadeOut(100,"swing");
    $('.save-image-button').prop('disabled', true);
    $(".image-upload-form").trigger("reset");
  }
});

// Preview image to upload
function readImageURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('.image-upload-form .profile-pic').attr('src', e.target.result);
      $('.save-image-button').prop('disabled', false);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

// Reset image
function removeImage() {
  $('.image-upload-form .profile-pic').attr('src', "assets/images/profile-default.png");
  $(".image-upload-form").trigger("reset");
  $('.save-image-button').prop('disabled', false);
}

// Edit profile in settings

function enableEdit() {

}


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
