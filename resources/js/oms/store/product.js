const product = {
  state: () => ({
    product: {},
  }),

  getters: {
    product: s => s.product,
    id: s => s.product.id,
  },

  mutations: {
    SET_GOOD (state, data = {}) {
      state.product = data
    },
  },

  actions: {
    setProduct ({ commit }, product) {
      commit('SET_GOOD', product)
    },
  },
}

export default product