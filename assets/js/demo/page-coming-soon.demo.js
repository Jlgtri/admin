var handleRenderCountdownTimer = function () {
  var newYear = new Date();
  newYear = new Date(newYear.getFullYear() + 1, 1 - 1, 1);
  $("#timer").countdown({ until: newYear });
};
$(document).ready(function () {
  handleRenderCountdownTimer();
});
