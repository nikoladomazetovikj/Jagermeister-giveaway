$(function () {

  // clear hash
  let url = window.location.toString();
  let failed = $("#failed").text();
  if (url.indexOf("?") > 0) {
    let cleanUrl = url.substring(0, url.indexOf("?"));
    window.history.replaceState({}, document.title, cleanUrl);
  }

  // block user 
  if (failed === "0") {
    // calc 24h
    const expirationDuration = 1000 * 60 * 60 * 24;
    
    const prevAccepted = localStorage.getItem("error");
    const currentTime = new Date().getTime();

    const notAccepted = prevAccepted == undefined;
    const prevAcceptedExpired =
      prevAccepted != undefined &&
      currentTime - prevAccepted > expirationDuration;
    if (notAccepted || prevAcceptedExpired) {
      localStorage.setItem("error", currentTime + expirationDuration);
      $("#send").prop("disabled", true);
      $("#attmsg").text("");
      $("#blockmsg").text("You've been blocked for 24h!");
    }
  }
});

// on reload compare current time with timestampt in the localstorage
$(function () {
  if (localStorage.getItem("error") > new Date().getTime()) {
    $("#send").prop("disabled", true);
  } else {
    localStorage.removeItem("error");
    $("#send").prop("disabled", false);
  }
});
