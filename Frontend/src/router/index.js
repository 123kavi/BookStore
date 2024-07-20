import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Login from '../views/Login.vue';
import Register from '../views/Signup.vue';
import MainPage from '../views/MainPage.vue';
import BorrowedBooks from '../views/BorrowedBooks.vue';
const routes = [
  { path: '/', component: Home },
  { path: '/mainpage', component: MainPage },

  { path: '/login', component: Login },
  { path: '/signup', component: Register },
  { path: '/mybooks', component: BorrowedBooks },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
