import { createRouter, createWebHistory } from "vue-router";
import AdminLayout from "@/components/layouts/AdminLayout.vue";
import Products from "@/components/views/Products.vue";

const routes = [
  {
    path: "/",
    component: AdminLayout,
    children: [
      { path: "products", component: Products },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
