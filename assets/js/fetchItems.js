import { Card } from "./class/Card.js";
const selectCategory = document.querySelector("#select-category");
selectCategory.addEventListener("change", () => {
  const url = "/items/" + selectCategory.value;
  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur de réseau : " + response.status);
      }
      return response.json();
    })
    .then((data) => {
      const paginationItems = document.querySelector("#pagination-items");
      const linkCard = document.querySelectorAll(".link-card");
      const arrayLinkCard = [...linkCard];
      arrayLinkCard.forEach((element) => {
        element.remove();
      });
      paginationItems.style.display = "none";
      for (const key in data) {
        if (Object.hasOwnProperty.call(data, key)) {
          const element = data[key];
          const card = new Card(element);
        }
      }
    })
    .catch((error) => {
      console.error("Erreur lors de la requête :", error);
    });
});
