/**
 * @param message
 * @returns {string}
 */
const messageToStr = (message) => {
  if (typeof message === 'string') return message

  let data = '<ul>'

  for (let i in message) {

    if (typeof message[i] === 'object') {

      message[i].forEach(function (item, index, array) {
        data += '<li>' + item + '</li>'
      })
    } else {
      data += '<li>' + message[i] + '</li>'
    }
  }
  data += '</ul>'

  return data
}

/**
 * @param message
 * @returns {string[]|*[]}
 */
const messageToArray = (message) => {
  if (typeof message === 'string') return [message]

  let data = []

  for (let i in message) {

    if (typeof message[i] === 'object') {

      message[i].forEach(function (item, index, array) {
        data.push(item)
      })
    } else {
      data.push(message[i])
    }
  }

  return data
}

export { messageToStr, messageToArray }