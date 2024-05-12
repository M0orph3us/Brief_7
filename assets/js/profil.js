const userProfilContainer = document.querySelector("#user-profil-container");
const userSales = document.querySelector("#user-sales");
const toSale = document.querySelector("#to-sale");

const btnProfil = document.querySelector("#profil");
btnProfil.addEventListener("click", () => {
  userProfilContainer.style.display = "block";
  userSales.style.display = "none";
  toSale.style.display = "none";
});

const btnMySales = document.querySelector("#my-sales");
btnMySales.addEventListener("click", () => {
  userProfilContainer.style.display = "none";
  userSales.style.display = "block";
  toSale.style.display = "none";
});

const btnSell = document.querySelector("#sell");
btnSell.addEventListener("click", () => {
  userProfilContainer.style.display = "none";
  userSales.style.display = "none";
  toSale.style.display = "block";
});
