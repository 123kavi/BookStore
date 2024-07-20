<!-- src/components/Header.vue -->
<template>
    <header class="header">
      <div class="header-content">
        <h1>Book App</h1>
        <nav>
          <router-link to="/">Home</router-link>
          <router-link to="/books">Books</router-link>
          <router-link v-if="!isLoggedIn" to="/login">Login</router-link>
          <router-link v-if="isLoggedIn" @click="logout">Logout</router-link>
        </nav>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    computed: {
      isLoggedIn() {
        return !!localStorage.getItem('token');
      }
    },
    methods: {
      logout() {
        localStorage.removeItem('token');
        this.$router.push('/login'); // Redirect to login page
      }
    }
  };
  </script>
  
  <style scoped>
  /* Basic styling for the header */
  .header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #333;
    color: white;
    padding: 10px 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
  }
  
  .header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  nav a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
  }
  
  nav a:hover {
    text-decoration: underline;
  }
  </style>
  