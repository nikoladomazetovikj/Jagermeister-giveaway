$(function () {
  // all checkoboxes
  let pendingR = $("#pendingR");
  let approvedR = $("#approvedR");
  let declinedR = $("#declinedR");
  let receiptR = $("#receiptsR");
  let maybeReceiptsR = $("#maybeReceiptsR");
  let all = $("#allCards");
  let random = $("#random");

  // classes
  let pending = $(".pending");
  let approved = $(".approved");
  let declined = $(".declined");
  let receipt = $(".receipt");
  let maybeReceipt = $(".maybeReceipt");

  // show/hide on click functions

  pendingR.on("click", function () {
    pending.removeClass("hide").addClass("show");
    approved.removeClass("show").addClass("hide");
    declined.removeClass("show").addClass("hide");
    random.removeClass("hide").addClass("show");
  });

  approvedR.on("click", function () {
    pending.removeClass("show").addClass("hide");
    approved.removeClass("hide").addClass("show");
    declined.removeClass("show").addClass("hide");
    random.removeClass("show").addClass("hide");
  });

  declinedR.on("click", function () {
    pending.removeClass("show").addClass("hide");
    approved.removeClass("show").addClass("hide");
    declined.removeClass("hide").addClass("show");
    random.removeClass("show").addClass("hide");
  });

  receiptR.on("click", function () {
    pending.removeClass("hide");
    approved.removeClass("hide");
    declined.removeClass("hide");
    receipt.removeClass("hide").addClass("show");
    maybeReceipt.removeClass("show").addClass("hide");
    random.removeClass("show").addClass("hide");
  });

  maybeReceiptsR.on("click", function () {
    pending.removeClass("hide");
    approved.removeClass("hide");
    declined.removeClass("hide");
    receipt.removeClass("show").addClass("hide");
    maybeReceipt.removeClass("hide").addClass("show");
    random.removeClass("show").addClass("hide");
  });

  all.on("click", function () {
    random.removeClass("show").addClass("hide");
    pending.removeClass("hide");
    approved.removeClass("hide");
    declined.removeClass("hide");
    receipt.removeClass("hide");
    maybeReceipt.removeClass("hide");
  });
});
