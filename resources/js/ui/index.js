import uiButton from './buttom/button.vue'
import uiDialog from './dialog/dialog.vue'

const components = {
  uiButton,
  uiDialog,
}

const ui = {
  install (Vue) {
    for (let name in components) {
      Vue.component(name, components[name])
    }
  },
}

export default ui



