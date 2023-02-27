function YmEc(options) {
    const self = this;

    let products = {};
    let cartItems = {};
    let detailProductId = null;
    let currency = null;
    let hasActiveVariation = false;
    let sentDetails = [];

    window.dataLayer = window.dataLayer || [];

    this.addData = function (data) {
        if (!data) {
            return;
        }

        if (data.products) {
            this.registerProducts(data.products);
        }

        if (data.cartItems) {
            this.registerCartItems(data.cartItems);
        }

        if (data.currency) {
            this.setCurrency(data.currency);
        }

        if (data.detailProductId) {
            this.setDetailProductId(data.detailProductId);
        }

        if (data.hasActiveVariation) {
            hasActiveVariation = true;
        }

        if (data.actions) {
            for (var index in data.actions) {
                var action = data.actions[index];
                this.send(action.type, action.data);
            }
        }

        if (data.purchase) {
            this.sendPurchase(data.purchase.actionField, data.purchase.products);
        }
    }

    //methods
    this.registerCartItem = function (hash, data) {
        cartItems[hash] = data;
    }

    this.registerProduct = function (id, data) {
        if (typeof data === 'string') {
            console.log(data);
            try {
                data = JSON.parse(data);
            } catch (e) {
                console.log('При регистрации товара произошла ошибка - неверная JSON строка');
                return;
            }
        }

        products[id] = data;
    }

    this.registerProducts = function (products) {
        for (var productId in products) {
            if (!products.hasOwnProperty(productId)) {
                continue;
            }
            self.registerProduct(productId, products[productId]);
        }
    }

    this.registerCartItems = function (cartItems) {
        for (var hash in cartItems) {
            if (!cartItems.hasOwnProperty(hash)) {
                continue;
            }
            self.registerCartItem(hash, cartItems[hash]);
        }
    }

    this.isDetail = function(){
        return !!detailProductId;
    }

    this.hasActiveVariation = function(){
        return hasActiveVariation;
    }

    this.setDetailProductId = function (productId) {
        detailProductId = productId;
    }

    this.setCurrency = function (currencyCode) {
        currency = currencyCode;
    }

    this.getCurrency = function () {
        return currency;
    }

    this.getDetailProductId = function () {
        return detailProductId;
    }

    this.getProduct = function (id) {
        return products[id] || null;
    }

    this.getProductByHash = function(hash){
        if (!cartItems.hasOwnProperty(hash)) {
            return null;
        }

        const productId = cartItems[hash].id;

        return products[productId] || null;
    }

    this.getProducts = function () {
        return products;
    }

    this.getCartItems = function(){
        return cartItems;
    }

    this.clearCartItems = function(){
        cartItems = {};
    }

    this.clearProducts = function(){
        products = {};
    }

    this.updateCartItems = function(newCartItems){
        //remove deleted products from carts
        for (let hash in cartItems) {
            const cartItem = cartItems[hash];

            if (typeof newCartItems[hash] === 'undefined') {
                this.send('remove', hash, {
                    quantity: cartItem.quantity
                });

                delete cartItems[hash];
            }
        }

        //update products quantity
        for (let hash in newCartItems) {
            const newCartItem = newCartItems[hash];
            const lastCartItem = cartItems[hash];

            const quantity = Math.abs(newCartItem.quantity - lastCartItem.quantity);
            const type = newCartItem.quantity > lastCartItem.quantity ? 'add' : 'remove';

            if (quantity > 0) {
                this.send(type, hash, {
                    quantity: quantity
                });
            }

            lastCartItem.quantity = newCartItem.quantity;
        }
    }

    this.send = function (type, product, additionalData) {
        if (['string', 'number'].indexOf(typeof product) > -1) {
            product = self.getProduct(product);
        }

        if (!product) {
            console.log('Не удалось найти данные товара для отправки в электронную коммерцию', product);
            return;
        }

        additionalData = additionalData || {};

        for (let key in additionalData) {
            if (!additionalData.hasOwnProperty(key)) {
                continue;
            }
            product[key] = additionalData[key];
        }


        const dataLayerData = {
            ecommerce: {}
        }


        dataLayerData.ecommerce[type] = {
            "products": [product]
        };

        if (currency) {
            dataLayerData['ecommerce']['currencyCode'] = currency;
        }

        window.dataLayer.push(dataLayerData);
    }

    this.sendPurchase = function(actionField, products){
        const dataLayerData = {
            ecommerce: {
                "purchase": {
                    "actionField": actionField,
                    "products": products
                }
            }
        }

        if (currency) {
            dataLayerData['ecommerce']['currencyCode'] = currency;
        }

        window.dataLayer.push(dataLayerData);
    }
}
