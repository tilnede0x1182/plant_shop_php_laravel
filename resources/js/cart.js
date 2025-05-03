window.Cart = {
    get() {
        try {
            return JSON.parse(localStorage.getItem("cart") || "{}");
        } catch (e) {
            console.error("Erreur JSON", e);
            return {};
        }
    },

    save(cart) {
        localStorage.setItem("cart", JSON.stringify(cart));
    },

    add(id, name, price, stock) {
        const cart = this.get();
        if (cart[id]) {
            cart[id].quantity += 1;
        } else {
            cart[id] = { id, name, price, quantity: 1, stock };
        }
        this.save(cart);
        this.updateNavbarCount();
    },

    update(id, newQty) {
        const qty = parseInt(newQty);
        if (isNaN(qty)) return;

        const cart = this.get();
        if (!cart[id]) return;

        const input = document.querySelector(
            "input[data-cart-id='" + id + "']"
        );
        const stock = parseInt(input.dataset.stock || "1");

        let correctedQty = qty;
        if (qty < 1) correctedQty = 1;
        if (qty > stock) correctedQty = stock;

        cart[id].quantity = correctedQty;
        input.value = correctedQty;

        this.save(cart);
        this.render();
    },

    delayedUpdate(id, inputElem) {
        clearTimeout(inputElem._cartTimer);
        inputElem._cartTimer = setTimeout(() => {
            this.update(id, inputElem.value);
        }, 300);
    },

    remove(id) {
        const cart = this.get();
        delete cart[id];
        this.save(cart);
        this.render();
    },

    clear() {
        localStorage.removeItem("cart");
        this.render();
    },

    updateNavbarCount() {
        const cart = this.get();
        let count = 0;
        for (const id in cart) {
            count += cart[id].quantity;
        }
        const link = document.getElementById("cart-link");
        if (link) {
            link.innerText =
                "Mon Panier" + (count > 0 ? " (" + count + ")" : "");
        }
    },

    render() {
        const container = document.getElementById("cart-container");
        if (!container) return;

        const cart = this.get();
        let html = "";
        let total = 0;

        if (Object.keys(cart).length === 0) {
            html = "<p class='alert alert-info'>Votre panier est vide.</p>";
        } else {
            html += `
        <table class="table">
          <thead class="table-dark">
            <tr><th>Plante</th><th>Quantité</th><th>Action</th></tr>
          </thead><tbody>`;

            for (const id in cart) {
                const item = cart[id];
                total += item.price * item.quantity;
                html += `
          <tr>
            <td><a href="/plants/${id}" class="text-decoration-none">${item.name}</a></td>
            <td><input type="number" min="1" class="form-control form-control-sm" style="max-width: 70px;"
              value="${item.quantity}" data-cart-id="${id}" data-stock="${item.stock}"
              oninput="Cart.delayedUpdate(${id}, this)"></td>
            <td><button class="btn btn-danger btn-sm" onclick="Cart.remove(${id})">Retirer</button></td>
          </tr>`;
            }

            html += `</tbody></table><p class="text-end fw-bold">Total : ${total} €</p>
        <div class="d-flex justify-content-between">
          <button class="btn btn-outline-secondary btn-sm" onclick="Cart.clear()">Vider le panier</button>
          <a href="/orders/create" class="btn btn-primary">Passer la commande</a>
        </div>`;
        }

        container.innerHTML = html;
    },

    renderOrderReview(
        containerId = "order-review-container",
        inputId = "order-items-input"
    ) {
        console.log(">>> Cart.renderOrderReview called");
        const container = document.getElementById(containerId);
        const input = document.getElementById(inputId);
        const cart = this.get();

        console.log("Container:", container);
        console.log("Input:", input);
        console.log("Cart content:", cart);

        // Eviter rendu si alert succès ou erreur affichée
        if (
            document.querySelector(".alert-success") ||
            document.querySelector(".alert-danger")
        ) {
            container.innerHTML = "";
            return;
        }
        if (!container || !input) return;

        if (Object.keys(cart).length === 0) {
            container.innerHTML =
                '<p class="alert alert-warning">Votre panier est vide.</p>';
            input.value = "";
            return;
        }

        console.log("Cart has content → render table");

        let total = 0;
        let html = `<table class="table shadow"><thead class="table-dark"><tr><th>Plante</th><th>Quantité</th><th>Total</th></tr></thead><tbody>`;
        const items = [];

        for (const id in cart) {
            const item = cart[id];
            const subtotal = item.quantity * item.price;
            total += subtotal;
            html += `<tr><td><a href="/plants/${item.id}" class="cart-plant-link">${item.name}</a></td><td>${item.quantity}</td><td>${subtotal} €</td></tr>`;
            items.push({ plant_id: parseInt(id), quantity: item.quantity });
        }

        html += `</tbody></table><p class="text-end fw-bold">Total : ${total} €</p>`;
        container.innerHTML = html;
        input.value = JSON.stringify(items);

        console.log("Panier affiché avec total:", total);
        console.log("Payload JSON envoyé:", input.value);
    },
};

function applyStockAdjustmentFromAlert() {
  const alert = document.querySelector("[data-stock-adjust]");
  if (!alert) return;

  try {
      const data = JSON.parse(alert.dataset.stockAdjust);
      const { id, available } = data;
      const cart = Cart.get();

      if (available > 0 && cart[id]) {
          cart[id].quantity = available;
          cart[id].stock = available;
      } else {
          delete cart[id];
      }

      Cart.save(cart);
      Cart.render();
      Cart.renderOrderReview();
  } catch (e) {
      console.error("Erreur ajustement stock :", e);
  }
}

document.addEventListener("DOMContentLoaded", function () {
    Cart.updateNavbarCount();
    Cart.render();
    Cart.renderOrderReview();
    applyStockAdjustmentFromAlert();
});
