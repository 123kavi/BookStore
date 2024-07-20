<template>
  <div id="app">
    <div class="content">
      <div class="login-wrapper">
        <div class="login-left">
          <!-- Optionally add a logo image here -->
        </div>
        <form class="login-right" @submit.prevent="handleLogin">
          <div class="h2">Login</div>
          <div class="form-group">
            <input type="text" id="username" placeholder="Username" v-model="email" />
            <label for="username"></label>
          </div>
          <div class="form-group">
            <input type="password" id="password" placeholder="Password" v-model="password" />
            <label for="password"></label>
          </div>
          <div class="checkbox-container">
            <input type="checkbox" v-model="rememberMe" />
            <div class="text-checkbox">Remember me</div>
          </div>
          <div class="button-area">
            <button class="btn btn-primary" type="submit">Login</button>
          </div>
        </form>
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      email: '',
      password: '',
      rememberMe: false,
    };
  },
  methods: {
    async handleLogin() {
      try {
        const response = await axios.post('http://localhost:8000/api/login', {
          email: this.email,
          password: this.password,
        });
        if (response.status === 200) {
          const { token, username } = response.data;
          localStorage.setItem('token', token);
          localStorage.setItem('name', username);
          this.$router.push('/mainpage');
          Swal.fire({
            icon: 'success',
            title: `${username} has been successfully logged in!`,
            timer: 2500,
            showConfirmButton: false,
          });
        }
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: "Email and Password don't match with registered users!",
          timer: 2000,
          showConfirmButton: false,
        });
        localStorage.removeItem('token');
      }
    },
  },
};
</script>

<style scoped>
/* Global styles */
html, body {
  height: 100%;
  margin: 0;
  background: linear-gradient(135deg, #4a90e2, #357ab7); /* Blue gradient background */
}

#app {
  min-height: 100%;
  display: flex;
  flex-direction: column;
}

.content {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.login-wrapper {
  width: 100%;
  max-width: 400px;
  padding: 20px;
  background-color: #fff; /* White background for the login form */
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
}

.login-left {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px; /* Space between logo and form */
}

.login-right {
  padding: 0;
}

.h2 {
  color: #333;
  font-size: 24px;
  font-weight: 600;
  text-align: center;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 600;
  color: #333;
}

input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
  box-sizing: border-box;
}

input:focus {
  border-color: #4a90e2;
  outline: none;
}

.checkbox-container {
  display: flex;
  align-items: center;
  margin-top: 20px;
}

.text-checkbox {
  color: #333;
  font-size: 16px;
  margin-left: 10px;
}

input[type="checkbox"] {
  cursor: pointer;
  margin: 0;
  height: 22px;
  width: 22px;
  -webkit-appearance: none;
  transition: all 180ms linear;
}

input[type="checkbox"]:before {
  border: 1px solid #aaa;
  background-color: #fff;
  content: "";
  width: 20px;
  height: 20px;
  display: block;
  border-radius: 2px;
  transition: all 180ms linear;
}

input[type="checkbox"]:checked:before {
  background: linear-gradient(198.08deg, #22bf64 45.34%, #e281e7 224.21%);
  border: 1px solid #22bf64;
}

input[type="checkbox"]:after {
  content: "";
  border: 2px solid #161212;
  border-right: 0;
  border-top: 0;
  display: block;
  height: 4px;
  left: 4px;
  opacity: 0;
  position: absolute;
  top: 6px;
  transform: rotate(-45deg);
  width: 12px;
  transition: all 180ms linear;
}

input[type="checkbox"]:checked:after {
  opacity: 1;
}

.button-area {
  margin-top: 20px;
}

.btn {
  font-family: inherit;
  background-color: transparent;
  border: none;
  border-radius: 4px;
  height: 40px;
  padding: 0 20px;
  cursor: pointer;
  font-size: 16px;
  text-transform: uppercase;
}

.btn-primary {
  color: #fff;
  background-color: #08305e;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

.btn-primary:hover,
.btn-primary:focus {
  background: linear-gradient(198.08deg, #1b984f 45.34%, #e281e7 224.21%);
}

/* Responsive Styles */
@media (max-width: 768px) {
  .login-wrapper {
    margin: 20px;
    padding: 15px;
  }

  .h2 {
    font-size: 20px;
  }

  input {
    font-size: 14px;
    padding: 8px;
  }

  .btn-primary {
    font-size: 14px;
    padding: 8px 15px;
  }
}

@media (max-width: 480px) {
  .login-wrapper {
    margin: 10px;
    padding: 10px;
  }

  .h2 {
    font-size: 18px;
  }

  input {
    font-size: 14px;
    padding: 6px;
  }

  .btn-primary {
    font-size: 14px;
    padding: 6px 10px;
  }

  .checkbox-container {
    flex-direction: column;
    align-items: flex-start;
  }

  .text-checkbox {
    margin-left: 0;
    margin-top: 5px;
  }
}
</style>
