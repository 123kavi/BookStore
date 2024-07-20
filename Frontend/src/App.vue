<template>
  <div id="app">
    <header class="header">
      <div class="header-content">
        <h1>BoOk StOrE</h1>
        <div class="auth-buttons">
          <button v-if="!loggedIn" @click="goToSignIn" class="auth-button">
            <i class="fas fa-sign-in-alt"></i> Sign In
          </button>
          <button v-if="!loggedIn" @click="goToSignUp" class="auth-button">
            <i class="fas fa-user-plus"></i> Sign Up
          </button>
          <button v-if="loggedIn" @click="goToMyBooks" class="auth-button">
            <i class="fas fa-book-open"></i> View My Borrowed
          </button>
          <button v-if="loggedIn" @click="logout" class="auth-button">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </div>
      </div>
    </header>
    <router-view></router-view>
  </div>
</template>

<script lang="ts">
export default {
  name: 'App',
  data() {
    return {
      loggedIn: false, // Default state, assuming user is not logged in
    };
  },
  created() {
    this.checkLoginStatus(); // Check login status on component creation
  },
  methods: {
    goToSignIn() {
      this.$router.push('/login');
    },
    goToSignUp() {
      this.$router.push('/signup');
    },
    goToMyBooks() {
      this.$router.push('/mybooks'); // Navigate to My Books page
    },
    logout() {
      localStorage.removeItem('token');
      this.loggedIn = false;
      this.$router.push('/login'); // Redirect to login page after logout
    },
    checkLoginStatus() {
      this.loggedIn = !!localStorage.getItem('token'); // Set loggedIn based on token presence
    },
  },
  watch: {
    // Watch for changes in localStorage to update login state dynamically
    '$route'(to, from) {
      this.checkLoginStatus();
    },
  },
};
</script>

<style scoped>
/* Global styles */
html, body {
  height: 100%;
  margin: 0;
  background: #170d2c; /* Default background color */
  transition: background 0.5s ease;
}

#app {
  min-height: 100%;
  display: flex;
  flex-direction: column;
}

.header {
  background-color: rgb(10, 10, 10);
  padding: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  color: white;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.header h1 {
  margin: 0;
}

.auth-buttons {
  display: flex;
  gap: 10px;
}

.auth-button {
  background: transparent;
  border: none;
  color: white;
  font-size: 16px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 5px;
}

.auth-button i {
  font-size: 18px;
}

.auth-button:hover {
  color: #007bff; /* Change color on hover */
}

.content {
  flex: 1;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

/* Add any additional styles as needed */
</style>
