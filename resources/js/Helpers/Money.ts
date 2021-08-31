const numberFormatters: Record<string, Intl.NumberFormat> = {}

function getOrCreateNumberFormat(currency: string) {
  if (!(currency in numberFormatters)) {
    numberFormatters[currency] = new Intl.NumberFormat(undefined, {
      currency,
      style: "currency",
      currencyDisplay: "symbol",
    })
  }

  return numberFormatters[currency]
}

export function formatMoney(currency: string, money: number | bigint) {
  return getOrCreateNumberFormat(currency).format(money)
}
