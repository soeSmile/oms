export default function isAdmin ({ next }) {
  if (user.isAdmin) {
    return next()
  }

  return next({ name: '404' })
}