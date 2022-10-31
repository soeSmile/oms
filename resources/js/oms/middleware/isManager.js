export default function isManager ({ next }) {
  if (user.isManager) {
    return next()
  }

  return next({ name: '404' })
}