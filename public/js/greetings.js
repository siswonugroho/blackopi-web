const welcomeText = document.querySelector('#welcome-text');
const date = new Date();
let hours = date.getHours();

if (hours >= 3 && hours < 11) welcomeText.textContent = "Selamat Pagi";
else if (hours >= 11 && hours < 15) welcomeText.textContent = "Selamat Siang";
else if (hours >= 15 && hours < 19) welcomeText.textContent = "Selamat Sore";
else welcomeText.textContent = "Selamat Malam";