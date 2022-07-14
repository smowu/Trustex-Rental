// Fixes Form Resubmission
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

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
  $(".propic-icon-container").click( function() {
    $(".user-menu").fadeToggle(100,"swing");
  });
});

$(document).mouseup(function(e) {
    var menu = $(".user-menu");
    var icon = $(".propic-icon-container");
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

// Input type number
function inc(element,max) {
  let el = document.querySelector( `[name="${element}"]`);
  if (parseInt(el.value) < max) {
    el.value = parseInt(el.value) + 1;
    $(el).trigger('change');
  }
}

function dec(element,min) {
  let el = document.querySelector(`[name="${element}"]`);
  if (parseInt(el.value) > min) {
    el.value = parseInt(el.value) - 1;
    $(el).trigger('change');
  }
}

// Reset propic
function resetProfilePicture() {
  $('.image-upload-form .profile-pic').attr('src', "assets/images/profile-default.png");
  $(".image-upload-form").trigger("reset");
  $('.save-image-button').prop('disabled', false);
  
}

// Edit profile in settings
$(document).ready(function(){

  $(".save-button").hide();
  $(".cancel-button").hide();
  $(".radio-gender").hide();

	$('.profile-section .edit-button').click(function(){
    $(".personal-details .cancel-button").click();
    enableEditAccountInfo();
    $(".profile-username").select();
	});

  $('.personal-details .edit-button').click(function(){
    $(".profile-section .cancel-button").click();
    enableEditPersonalInfo();
    $(".personal-firstname").select();
	});

  $('.profile-section .save-button').click(function(){
    saveAccountInfo();
	});
  $('.personal-details .save-button').click(function(){
    savePersonalInfo();
	});

  function enableEditAccountInfo() {
    $(".profile-section .edit-button").hide();
    $(".profile-section .save-button").show();
    $(".profile-section .cancel-button").show();
    $(".account-info-form input").attr("readonly", false);
    $(".account-info-form input").css("border", "2px solid #cccccc");
  }
  function saveAccountInfo() {
    $(".account-info-form input").css("border", "transparent");
    $(".account-info-form input").attr("readonly", true);
    $(".save-account-edit").click();
  }

  function enableEditPersonalInfo() {
    $(".personal-details .edit-button").hide();
    $(".personal-details .save-button").show();
    $(".personal-details .cancel-button").show();
    $(".personal-gender").hide();
    $(".radio-gender").show();
    $(".personal-info-form input").attr("readonly", false);
    $(".personal-info-form input").css("border", "2px solid #cccccc");
  }
  function savePersonalInfo() {
    $(".personal-info-form input").css("border", "transparent");
    $(".personal-info-form input").attr("readonly", true);
    $(".save-profile-edit").click();
  }

  $('.profile-section .cancel-button').click(function(){
    cancelEditAccountInfo();
	});
  $('.personal-details .cancel-button').click(function(){
    cancelEditPersonalInfo();
	});

  function cancelEditAccountInfo() {
    $(".profile-section .edit-button").show();
    $(".profile-section .save-button").hide();
    $(".profile-section .cancel-button").hide();
    $(".account-info-form input").attr("readonly", true);
    $(".account-info-form input").css("border", "transparent");
  }

  function cancelEditPersonalInfo() {
    $(".personal-details .edit-button").show();
    $(".personal-details .save-button").hide();
    $(".personal-details .cancel-button").hide();
    $(".radio-gender").hide();
    $(".personal-gender").show();
    $(".personal-info-form input").attr("readonly", true);
    $(".personal-info-form input").css("border", "transparent");
  }

});
