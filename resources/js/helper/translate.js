/**
 * @param key
 * @returns string
 */
const lang = (key) => {
  return trans[key] || key
}

export { lang }