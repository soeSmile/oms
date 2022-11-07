import { createStore } from 'vuex'
import user from './user'
import product from './product'

const store = createStore({
  modules: {
    user: user,
    product: product,
  },
})

export default store
