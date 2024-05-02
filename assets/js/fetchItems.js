import { Card } from "./class/Card.js";
const selectCategory = document.querySelector("#select-category");

selectCategory.addEventListener("change", () => {
  const paginationItems = document.querySelector("#pagination-items");
  if (paginationItems) {
    paginationItems.style.display = "none";
  }

  const linkCard = document.querySelectorAll(".link-card");
  const arrayLinkCard = [...linkCard];
  arrayLinkCard.forEach((element) => {
    element.remove();
  });
  const url = "/items/" + selectCategory.value;
  const fetchData = async (url) => {
    try {
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error("Erreur de réseau : " + response.status);
      }
      const data = await response.json();

      for (const key in data) {
        if (Object.hasOwnProperty.call(data, key)) {
          const element = data[key];
          const card = new Card(element);
        }
      }
    } catch (error) {
      console.error("Erreur lors de la requête :", error);
    }
  };

  fetchData(url);
});
