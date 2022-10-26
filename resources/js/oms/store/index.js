import { createStore } from 'vuex'
import user from './user'
import good from './good'

const store = createStore({
  modules: {
    user: user,
    good: good,
  },
})

export default store
