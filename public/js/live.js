/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 37);
/******/ })
/************************************************************************/
/******/ ({

/***/ 37:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(38);


/***/ }),

/***/ 38:
/***/ (function(module, exports, __webpack_require__) {

var cc = __webpack_require__(43);

// Basic Usage:
cc.priceMulti(['BTC', 'ETH'], ['USD', 'EUR']).then(function (prices) {
    console.log(prices);
}).catch(console.error);

cc.priceMulti('BTC', 'USD').then(function (prices) {
    console.log(prices);
}).catch(console.error);

/***/ }),

/***/ 43:
/***/ (function(module, exports, __webpack_require__) {

"use strict";

/* global fetch */

const baseUrl = 'https://min-api.cryptocompare.com/data/'

function fetchJSON (url) {
  return fetch(url)
    .then(res => {
      if (!res.ok) {
        throw new Error(`${res.status} ${res.statusText}`)
      }
      return res.json()
    })
    .then(body => {
      if (body.Response === 'Error') throw body.Message
      return body
    })
}

function coinList () {
  const url = `${baseUrl}all/coinlist`
  return fetchJSON(url)
}

function exchangeList () {
  const url = `${baseUrl}all/exchanges`
  return fetchJSON(url)
}

function price (fsym, tsyms, options) {
  options = options || {}
  let url = `${baseUrl}price?fsym=${fsym}&tsyms=${tsyms}`
  if (options.exchanges) url += `&e=${options.exchanges}`
  if (options.tryConversion === false) url += '&tryConversion=false'
  return fetchJSON(url)
}

function priceMulti (fsyms, tsyms, options) {
  options = options || {}
  let url = `${baseUrl}pricemulti?fsyms=${fsyms}&tsyms=${tsyms}`
  if (options.exchanges) url += `&e=${options.exchanges}`
  if (options.tryConversion === false) url += '&tryConversion=false'
  return fetchJSON(url)
}

function priceFull (fsyms, tsyms, options) {
  options = options || {}
  let url = `${baseUrl}pricemultifull?fsyms=${fsyms}&tsyms=${tsyms}`
  if (options.exchanges) url += `&e=${options.exchanges}`
  if (options.tryConversion === false) url += '&tryConversion=false'
  // We want the RAW data, not the DISPLAY data:
  return fetchJSON(url).then(result => result.RAW)
}

function priceHistorical (fsym, tsyms, time, options) {
  options = options || {}
  time = dateToTimestamp(time)
  let url = `${baseUrl}pricehistorical?fsym=${fsym}&tsyms=${tsyms}&ts=${time}`
  if (options.exchanges) url += `&e=${options.exchanges}`
  if (options.tryConversion === false) url += '&tryConversion=false'
  // The API returns json with an extra layer of nesting, so remove it
  return fetchJSON(url).then(result => result[fsym])
}

function generateAvg (fsym, tsym, e, tryConversion) {
  let url = `${baseUrl}generateAvg?fsym=${fsym}&tsym=${tsym}&e=${e}`
  if (tryConversion === false) url += '&tryConversion=false'
  return fetchJSON(url).then(result => result.RAW)
}

function topPairs (fsym, limit) {
  let url = `${baseUrl}top/pairs?fsym=${fsym}`
  if (limit) url += `&limit=${limit}`
  return fetchJSON(url).then(result => result.Data)
}

function topExchanges (fsym, tsym, limit) {
  let url = `${baseUrl}top/exchanges?fsym=${fsym}&tsym=${tsym}`
  if (limit) url += `&limit=${limit}`
  return fetchJSON(url).then(result => result.Data)
}

function histoDay (fsym, tsym, options) {
  options = options || {}
  if (options.timestamp) options.timestamp = dateToTimestamp(options.timestamp)
  let url = `${baseUrl}histoday?fsym=${fsym}&tsym=${tsym}`
  if (options.exchange) url += `&e=${options.exchange}`
  if (options.limit === 'none') url += '&allData=true'
  else if (options.limit) url += `&limit=${options.limit}`
  if (options.tryConversion === false) url += '&tryConversion=false'
  if (options.aggregate) url += `&aggregate=${options.aggregate}`
  if (options.timestamp) url += `&toTs=${options.timestamp}`
  return fetchJSON(url).then(result => result.Data)
}

function histoHour (fsym, tsym, options) {
  options = options || {}
  if (options.timestamp) options.timestamp = dateToTimestamp(options.timestamp)
  let url = `${baseUrl}histohour?fsym=${fsym}&tsym=${tsym}`
  if (options.exchange) url += `&e=${options.exchange}`
  if (options.limit) url += `&limit=${options.limit}`
  if (options.tryConversion === false) url += '&tryConversion=false'
  if (options.aggregate) url += `&aggregate=${options.aggregate}`
  if (options.timestamp) url += `&toTs=${options.timestamp}`
  return fetchJSON(url).then(result => result.Data)
}

function histoMinute (fsym, tsym, options) {
  options = options || {}
  if (options.timestamp) options.timestamp = dateToTimestamp(options.timestamp)
  let url = `${baseUrl}histominute?fsym=${fsym}&tsym=${tsym}`
  if (options.exchange) url += `&e=${options.exchange}`
  if (options.limit) url += `&limit=${options.limit}`
  if (options.tryConversion === false) url += '&tryConversion=false'
  if (options.aggregate) url += `&aggregate=${options.aggregate}`
  if (options.timestamp) url += `&toTs=${options.timestamp}`
  return fetchJSON(url).then(result => result.Data)
}

function dateToTimestamp (date) {
  if (!(date instanceof Date)) throw new Error('timestamp must be an instance of Date.')
  return Math.floor(date.getTime() / 1000)
}

module.exports = {
  coinList,
  exchangeList,
  price,
  priceMulti,
  priceFull,
  priceHistorical,
  generateAvg,
  topPairs,
  topExchanges,
  histoDay,
  histoHour,
  histoMinute
}


/***/ })

/******/ });