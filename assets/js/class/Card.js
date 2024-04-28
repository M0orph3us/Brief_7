export class Card {
  constructor(data) {
    this.id = data.id;
    this.name = data.name;
    this.stock = data.stock;
    this.price = data.price;
    this.status = data.status_id;
    this.url = "test";

    this.createCard();
  }

  createCard() {
    const itemsCardsContainerTarget = document.querySelector(
      "#items-cards-container"
    );
    const cardLink = document.createElement("a");
    cardLink.classList.add("link-card");
    cardLink.href = this.url + this.id;

    const createCardContainer = document.createElement("div");
    createCardContainer.classList.add("item-card");

    const createTitle = document.createElement("h2");
    createTitle.textContent = this.name;

    const createStock = document.createElement("p");
    createStock.textContent = "stock : " + this.stock;

    const createPrice = document.createElement("p");
    createPrice.textContent = "price : " + this.price + "€";

    const createStatus = document.createElement("p");

    fetch("items/status/" + this.status)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur de réseau : " + response.status);
        }
        return response.json();
      })
      .then((data) => {
        createStatus.textContent = "status : " + data;
      })
      .catch((error) => {
        console.error("Erreur lors de la requête :", error);
      });
    cardLink.append(createCardContainer);
    createCardContainer.append(
      createTitle,
      createStock,
      createPrice,
      createStatus
    );
    itemsCardsContainerTarget.append(cardLink);
  }
}
