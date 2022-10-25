/**
 * @param name
 * @returns {string}
 */
function getCookie (name) {
  const map = new Map(document.cookie.split('; ').
    map(v => v.split(/=(.*)/s).map(decodeURIComponent)))

  return map.get(name)
}

export { getCookie }