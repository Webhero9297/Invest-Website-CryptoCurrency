const cc = require('cryptocompare')

// Basic Usage:
cc.priceMulti(['BTC', 'ETH'], ['USD', 'EUR'])
    .then(function(prices) {
        console.log(prices)
    })
    .catch(console.error);

    cc.priceMulti('BTC', 'USD')
    .then(function(prices){
        console.log(prices)
    })
    .catch(console.error);