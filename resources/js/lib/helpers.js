/* Converts 5 to 5.00 or 4.4656 to 4.46  */
function formatVal(value) {
    let val = (value/1).toFixed(2).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

/* Custom round */
function roundFloat (number) {
    return Math.round( Math.round( number * 1000 ) / 10 ) / 100;
}

/* Format integer to money format */
function moneyFormatter(val) {
    return new Intl.NumberFormat('uk-UA', {
        style: 'currency',
        currency: 'UAH',
        minimumFractionDigits: 0
    }).format(Math.ceil(val));
}

window.moment = require('moment-business-days');
moment.locale('uk');

function getNextDateByDay(day) {
    return moment().businessAdd(day).format('dd, L')
}

export { formatVal, roundFloat, moneyFormatter, getNextDateByDay };
