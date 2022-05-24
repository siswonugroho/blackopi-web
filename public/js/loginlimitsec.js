document.addEventListener('DOMContentLoaded', function (e) {
  const loginAlertElement = document.querySelector('.alert');
  const alertCloseBtn = loginAlertElement.querySelector('button.btn-close');
  let loginRetrySec = loginAlertElement.querySelector('span.login-retry-sec');
  let i = parseInt(loginRetrySec.textContent);

  const timer = setInterval(() => {
    loginRetrySec.textContent = i--;
    if (i < 0) {
      clearInterval(timer);
      alertCloseBtn.click();
    }
  }, 1000);
});