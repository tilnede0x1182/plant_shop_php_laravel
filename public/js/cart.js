class Cart {
    /**
     * Récupère le panier depuis localStorage.
     * @returns {Object} contenu du panier
     */
    get() {
        try {
            return JSON.parse(localStorage.getItem("cart") || "{}");
        } catch (e) {
            console.error("Erreur JSON", e);
            return {};
        }
    }

    /**
     * Sauvegarde le panier dans localStorage.
     * @param {Object} cart contenu à enregistrer
     */
    save(cart) {
        localStorage.setItem("cart", JSON.stringify(cart));
    }

    /**
     * Ajoute un article au panier.
     * @param {number} id identifiant
     * @param {string} name nom
     * @param {number} price prix
     * @param {number} stock disponible
     */
    add(id, name, price, stock) {
        const cart = this.get();
        if (cart[id]) {
            cart[id].quantity += 1;
        } else {
            cart[id] = { id, name, price, quantity: 1, stock };
        }
        this.save(cart);
        this.updateNavbarCount();
    }

    /**
     * Met à jour une quantité.
     * @param {number} id identifiant
     * @param {number|string} newQty quantité cible
     */
    update(id, newQty) {
        const qty = parseInt(newQty);
        if (isNaN(qty)) return;

        const cart = this.get();
        if (!cart[id]) return;

        const input = document.querySelector(`input[data-cart-id="${id}"]`);
        const stock = parseInt(input?.dataset?.stock) || 1;

        let correctedQty = Math.max(1, Math.min(qty, stock));
        cart[id].quantity = correctedQty;
        if (input) input.value = correctedQty;

        this.save(cart);
        this.render();
    }

    /**
     * Met à jour avec temporisation.
     * @param {number} id identifiant
     * @param {HTMLInputElement} inputElem champ quantité
     */
    delayedUpdate(id, inputElem) {
        clearTimeout(inputElem._cartTimer);
        inputElem._cartTimer = setTimeout(() => {
            this.update(id, inputElem.value);
        }, 300);
    }

    /**
     * Supprime un article.
     * @param {number} id identifiant
     */
    remove(id) {
        const cart = this.get();
        delete cart[id];
        this.save(cart);
        this.render();
    }

    /**
     * Vide complètement le panier.
     */
    clear() {
        localStorage.removeItem("cart");
        this.render();
    }

    /**
     * Met à jour le compteur dans la navbar.
     */
    updateNavbarCount() {
        // console.log("updateNavbarCount");
        const cart = this.get();
        const count = Object.values(cart).reduce(
            (sum, item) => sum + item.quantity,
            0,
        );
        const link = document.getElementById("cart-link");
        if (link) {
            link.innerText = `Mon Panier${count > 0 ? ` (${count})` : ""}`;
        }
    }

    /**
     * Rendu du panier complet.
     */
    render() {
        const container = document.getElementById("cart-container");
        if (!container) return;

        const cart = this.get();
        container.innerHTML = "";

        this.updateNavbarCount();

        if (Object.keys(cart).length === 0) {
            const alert = document.createElement("p");
            alert.className = "alert alert-info";
            alert.textContent = "Votre panier est vide.";
            container.appendChild(alert);
            return;
        }

        const table = document.createElement("table");
        table.className = "table";

        const thead = document.createElement("thead");
        thead.className = "table-dark";
        const headerRow = document.createElement("tr");
        ["Plante", "Quantité", "Action"].forEach((text) => {
            const th = document.createElement("th");
            th.textContent = text;
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement("tbody");
        let total = 0;

        for (const id in cart) {
            const item = cart[id];
            total += item.price * item.quantity;

            const row = document.createElement("tr");

            const tdName = document.createElement("td");
            const link = document.createElement("a");
            link.href = `/plants/${id}`;
            link.className = "text-decoration-none";
            link.textContent = item.name;
            tdName.appendChild(link);

            const tdQty = document.createElement("td");
            const input = document.createElement("input");
            input.type = "number";
            input.min = "1";
            input.className = "form-control form-control-sm";
            input.style.maxWidth = "70px";
            input.value = item.quantity;
            input.dataset.cartId = id;
            input.dataset.stock = item.stock;
            input.oninput = () => this.delayedUpdate(id, input);
            tdQty.appendChild(input);

            const tdAction = document.createElement("td");
            const btn = document.createElement("button");
            btn.className = "btn btn-danger btn-sm";
            btn.textContent = "Retirer";
            btn.onclick = () => this.remove(id);
            tdAction.appendChild(btn);

            row.appendChild(tdName);
            row.appendChild(tdQty);
            row.appendChild(tdAction);
            tbody.appendChild(row);
        }

        table.appendChild(tbody);
        container.appendChild(table);

        const totalEl = document.createElement("p");
        totalEl.className = "text-end fw-bold";
        totalEl.textContent = `Total : ${total} €`;
        container.appendChild(totalEl);

        const actionsDiv = document.createElement("div");
        actionsDiv.className = "d-flex justify-content-between";

        const clearBtn = document.createElement("button");
        clearBtn.className = "btn btn-outline-secondary btn-sm";
        clearBtn.textContent = "Vider le panier";
        clearBtn.onclick = () => this.clear();

        const checkoutLink = document.createElement("a");
        checkoutLink.href = "/orders/create";
        checkoutLink.className = "btn btn-primary";
        checkoutLink.textContent = "Passer la commande";

        actionsDiv.appendChild(clearBtn);
        actionsDiv.appendChild(checkoutLink);
        container.appendChild(actionsDiv);
    }

    /**
     * Affiche le récapitulatif de commande.
     * @param {string} containerId ID du conteneur
     * @param {string} inputId ID du champ input
     */
    renderOrderReview(
        containerId = "order-review-container",
        inputId = "order-items-input",
    ) {
        const container = document.getElementById(containerId);
        const input = document.getElementById(inputId);
        if (
            !container ||
            !input ||
            document.querySelector(".alert-success") ||
            document.querySelector(".alert-danger")
        )
            return;
        const cart = this.get();

        if (
            document.querySelector(".alert-success") ||
            document.querySelector(".alert-danger")
        ) {
            container.innerHTML = "";
            return;
        }

        if (!container || !input) return;

        if (Object.keys(cart).length === 0) {
            const alert = document.createElement("p");
            alert.className = "alert alert-warning";
            alert.textContent = "Votre panier est vide.";
            container.innerHTML = "";
            container.appendChild(alert);
            input.value = "";
            return;
        }

        const table = document.createElement("table");
        table.className = "table shadow";
        const thead = document.createElement("thead");
        thead.className = "table-dark";
        const headerRow = document.createElement("tr");
        ["Plante", "Quantité", "Total"].forEach((text) => {
            const th = document.createElement("th");
            th.textContent = text;
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement("tbody");
        let total = 0;
        const items = [];

        for (const id in cart) {
            const item = cart[id];
            const subtotal = item.price * item.quantity;
            total += subtotal;

            const row = document.createElement("tr");

            const tdName = document.createElement("td");
            const link = document.createElement("a");
            link.href = `/plants/${item.id}`;
            link.className = "cart-plant-link";
            link.textContent = item.name;
            tdName.appendChild(link);

            const tdQty = document.createElement("td");
            tdQty.textContent = item.quantity;

            const tdTotal = document.createElement("td");
            tdTotal.textContent = `${subtotal} €`;

            row.appendChild(tdName);
            row.appendChild(tdQty);
            row.appendChild(tdTotal);

            tbody.appendChild(row);

            items.push({ plant_id: parseInt(id), quantity: item.quantity });
        }

        table.appendChild(tbody);
        container.innerHTML = "";
        container.appendChild(table);

        const totalEl = document.createElement("p");
        totalEl.className = "text-end fw-bold";
        totalEl.textContent = `Total : ${total} €`;
        container.appendChild(totalEl);

        input.value = JSON.stringify(items);
    }
}

/**
 * Ajuste le stock suite à une alerte serveur.
 */
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

document.addEventListener("DOMContentLoaded", () => {
    window.Cart = new Cart();
    if (document.querySelector("[data-clear-cart]")) {
        window.Cart.clear();
    }
    window.Cart.updateNavbarCount();
    window.Cart.render();
    window.Cart.renderOrderReview();
    applyStockAdjustmentFromAlert();
});
