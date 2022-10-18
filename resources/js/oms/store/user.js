const user = {
  state: () => ({
    user: {},
  }),

  getters: {
    user: s => s.user,
  },

  mutations: {
    SET_USER (state, data = {}) {
      state.user = data.user
    },
  },

  actions: {},
}

export default user