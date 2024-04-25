export function profil() {
  const btnProfil = document.querySelectorAll(".fa-user");

  const profilContainer = document.querySelector("#profil-container");

  const allBtnProfil = [...btnProfil];
  allBtnProfil.forEach((profil) => {
    profil.addEventListener("click", () => {
      const display = window.getComputedStyle(profilContainer).display;
      if (display === "none") {
        profilContainer.style.display = "flex";
      } else if (display === "flex") {
        profilContainer.style.display = "none";
      }
    });
  });
}

export function navbarMobile() {
  const menuBurgerContainer = document.querySelector("#menu-burger-container");

  const menuBurger = document.querySelector("#open-menu-burger");
  menuBurger.addEventListener("click", () => {
    menuBurgerContainer.style.display = "block";
  });
  const xmark = document.querySelector("#close-menu-burger");
  xmark.addEventListener("click", () => {
    console.log("hello");
    menuBurgerContainer.style.display = "none";
  });
}
