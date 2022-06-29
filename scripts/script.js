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
function toggleImageForm() {
  var img = $('.profile-pic-container .profile-pic').attr("src");
  $('.image-upload-form .profile-pic').attr('src', img);
  $(".image-upload-overlay").fadeToggle(100,"swing");
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

function resetProfilePicture() {
  $('.image-upload-form .profile-pic').attr('src', "assets/images/profile-default.png");
  $(".image-upload-form").trigger("reset");
  $('.save-image-button').prop('disabled', false);
}

// Edit profile in settings
$(document).ready(function(){
	$('.profile-edit').click(function(){
    enableEditAccountInfo();
    $(".profile-username").select();
	});
  $('.profile-username').dblclick(function(){
    enableEditAccountInfo();
	});
  $('.profile-email').dblclick(function(){
    enableEditAccountInfo();
	});

  $('.personal-edit').click(function(){
    enableEditPersonalInfo();
    $(".personal-firstname").select();
	});
  $(".personal-info-form input").dblclick(function(){
    enableEditPersonalInfo();
	});

  function enableEditAccountInfo() {
    $(".profile-edit").hide();
    $(".account-info-form input").attr("readonly", false);
    $(".account-info-form input").css("border", "2px solid #cccccc");
  }
  function saveEditAccountInfo() {
    $(".account-info-form input").css("border", "transparent");
    $(".account-info-form input").attr("readonly", true);
    $(".save-account-edit").click();
  }

  function enableEditPersonalInfo() {
    $(".personal-edit").hide();
    $(".personal-info-form input").attr("readonly", false);
    $(".personal-info-form input").css("border", "2px solid #cccccc");
  }
  function saveEditPersonalInfo() {
    $(".personal-info-form input").css("border", "transparent");
    $(".personal-info-form input").attr("readonly", true);
    $(".save-profile-edit").click();
  }

	$('input.input-account[type="text"]').blur(function() {
    // if ($.trim(this.value) == ''){
    //   this.value = (this.defaultValue ? this.defaultValue : '');
    // }
    saveEditAccountInfo();
  });
  $('input.input-personal[type="text"]').blur(function() {
    // if ($.trim(this.value) == ''){
    //   this.value = (this.defaultValue ? this.defaultValue : '');
    // }
    saveEditPersonalInfo();
  });

  $('input.input-account[type="text"]').keypress(function(event) {
    if (event.keyCode == '13') {
      // if ($.trim(this.value) == ''){
      //   this.value = (this.defaultValue ? this.defaultValue : '');
      // }
      saveEditAccountInfo();
    }
  });
  $('input.input-personal[type="text"]').keypress(function(event) {
    if (event.keyCode == '13') {
      // if ($.trim(this.value) == ''){
      //   this.value = (this.defaultValue ? this.defaultValue : '');
      // }
      saveEditPersonalInfo();
    }
  });

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
