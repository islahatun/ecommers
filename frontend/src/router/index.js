// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('@/layouts/default/layoutsDefault.vue'),
    children: [
      {
        path: '',
        name: 'Home',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "home" */ '@/views/viewHome.vue'),
      },
      {
        path:'detail-product/:productId',
        name:'detail-product',
        component:()=>import('@/views/viewDetailProduct.vue'),
      },
      {
        path:'cart/:productId',
        name:'cart',
        component:()=>import('@/views/viewCartProduct.vue')
      }
    ],
  },
  {
    path:'/admin',
    component:()=>import('@/layouts/admin/AdminContent.vue'),
    children:[
      {
        path:'dashboard',
        name:'Dashboard Admin',
        component:()=>import('@/views/admin/viewAdminDashboard.vue')
      },
      {
        path:'users',
        name:'Users',
        component:()=>import('@/views/admin/viewAdminUsers.vue')
      },{
        path:'product',
        name:'Product',
        component:()=>import('@/views/admin/viewAdminProduct.vue')
      },
      {
        path:'complaint',
        name:'Complaint',
        component:()=>import('@/views/admin/viewAdminComplaint.vue')
      },
      {
        path:'orders',
        name:'Orders',
        component:()=>import('@/views/admin/viewAdminOrders.vue')
      },
      {
        path:'banks',
        name:'Banks',
        component:()=>import('@/views/admin/viewAdminBanks.vue')
      },
      {
        path:'categories',
        name:'Categories',
        component:()=>import('@/views/admin/viewAdminCategories.vue')
      },
      {
        path:'banners',
        name:'Banners',
        component:()=>import('@/views/admin/viewAdminBanners.vue')
      }
    ]
  }

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
