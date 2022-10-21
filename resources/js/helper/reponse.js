import { ElMessage } from 'element-plus'
import { messageToStr } from './serialazeError'

/**
 * @param message
 * @param func
 */
const success = (message, func) => {
  ElMessage({
    message: message ?? 'Success',
    type: 'success',
  })

  if (func) {
    func()
  }
}

const error = (e, message, func) => {
  if (e.response.data.errors) {
    message = messageToStr(e.response.data.errors)
  }

  ElMessage({
    dangerouslyUseHTMLString: true,
    message: message ?? 'Error',
    type: 'error',
  })

  if (func) {
    func()
  }
}

export { success, error }