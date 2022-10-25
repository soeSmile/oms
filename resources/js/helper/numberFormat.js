/**
 * @param number
 * @returns {string}
 */
function numberFormat (number) {
  let n = typeof number === 'string' ? parseFloat(number) : number

  if (n === null || n === undefined) {
    n = 0.00
  }

  return Math.floor(n).toLocaleString()
}

/**
 * @param number
 * @returns {string}
 */
function returnFloat (number) {
  let n = typeof number === 'string' ? parseFloat(number) : number

  if (n === null || n === undefined) {
    n = 0.00
  }

  let result = n.toFixed(2)

  if (n > 999) {
    let arr = result.split('.')
    let space = 0
    let number = ''

    for (let i = arr[0].length - 1; i >= 0; i--) {
      if (space === 3) {
        number = ' ' + number
        space = 0
      }
      number = arr[0].charAt(i) + number
      space++
    }

    result = number + '.' + arr[1]
  }

  return result
}

export { numberFormat, returnFloat }

