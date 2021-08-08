const numberFormatters = {}

function getOrCreateNumberFormat(currency) {
  if (!(currency in numberFormatters)) {
    numberFormatters[currency] = new Intl.NumberFormat(undefined, {
      currency,
      style: "currency",
      currencyDisplay: "symbol",
    })
  }

  return numberFormatters[currency]
}

export function formatMoney(currency, money) {
  return getOrCreateNumberFormat(currency).format(money)
}
