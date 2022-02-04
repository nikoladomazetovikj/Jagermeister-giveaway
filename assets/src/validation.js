$(function () {
  let send = $("#send");
  let emailCheck = $("#emailCheck");
  let enter = $("#enter");

  // validate email
  function validMail(email) {
    const regex =
      /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    return regex.test(email);
  }

  enter.click(function () {
    $("#progressBar").hide();
  });

  // form validate
  send.click(function (e) {
    let email = $("#Email").val();
    let img = $("#receiptImg");
    // check for email errors
    if (email.length <= 0) {
      emailCheck.text("This field is required");
      $(".form-control").addClass("border-red");
      e.preventDefault();
    } else if (!validMail(email)) {
      emailCheck.text("Invalid E-mail address");
      $(".form-control").addClass("border-red");
      e.preventDefault();
    } else {
      emailCheck.text("");
      $(".form-control").removeClass("border-red");
    }

    // check uploaded image extension and size
    let allowed = ["png", "jpg", "jpeg"];
    let extension = img.val().split(".").pop().toLowerCase();
    if (img.get(0).files.length === 0) {
      $("#fileExtension").text("This field is required");
      e.preventDefault();
    } else if ($.inArray(extension, allowed) == -1) {
      $("#fileExtension").text(
        "Invalid file extension, only " + allowed.join(" , ") + " are allowed"
      );
      e.preventDefault();
    } else if (img[0].files[0].size > 2097152) {
      $("#fileExtension").text("Image size should not be greater than 2MB");
      e.preventDefault();
    } else {
      $("#fileExtension").text("");
      if (validMail(email)) {
        // show loader
        let curr = 0;
        let interval = setInterval(function () {
          $("#popUp").hide();
          $("#progressBar").show();
          curr += 10;
          $("#loader")
            .css("width", curr + "%")
            .attr("aria-valuenow", curr)
            .text(curr + "%");
          if (curr >= 100) {
            clearInterval(interval);
          }
        }, 150);
      }
    }
  });
});
