import uiButton from './buttom/button.vue'

const components = {
  uiButton,
}

const ui = {
  install (Vue) {
    for (let name in components) {
      Vue.component(name, components[name])
    }
  },
}

export default ui



