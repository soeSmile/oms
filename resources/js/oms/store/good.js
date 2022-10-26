const good = {
  state: () => ({
    good: {},
  }),

  getters: {
    good: s => s.good,
    id: s => s.good.id,
  },

  mutations: {
    SET_GOOD (state, data = {}) {
      state.good = data
    },
  },

  actions: {
    setGood ({ commit }, good) {
      commit('SET_GOOD', good)
    },
  },
}

export default good