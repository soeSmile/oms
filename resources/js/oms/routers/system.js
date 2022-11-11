import userIndex from '../pages/users/userIndex.vue'
import isAdmin from '../middleware/isAdmin'
import userPage from '../pages/users/userPage.vue'
import eventIndex from '../pages/event/eventIndex.vue'

const system = [
  {
    path: '/oms/user',
    component: userIndex,
    name: 'userIndex',
    meta: {
      middleware: [isAdmin],
    },
  },
  {
    path: '/oms/user/:id',
    component: userPage,
    name: 'userPage',
    meta: {
      middleware: [isAdmin],
    },
  },
  {
    path: '/oms/event',
    component: eventIndex,
    name: 'eventIndex',
    meta: {
      middleware: [isAdmin],
    },
  },
]

export default system