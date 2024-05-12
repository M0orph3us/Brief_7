export function deleteMessage() {
  const success = document.querySelectorAll(".success");
  const arraySuccess = [...success];

  const error = document.querySelectorAll(".error");
  const arrayError = [...error];
  if (success) {
    arraySuccess.forEach((element) => {
      setTimeout(function () {
        element.remove();
      }, 5000);
    });
  }

  if (error) {
    arrayError.forEach((element) => {
      setTimeout(function () {
        element.remove();
      }, 3000);
    });
  }
}
