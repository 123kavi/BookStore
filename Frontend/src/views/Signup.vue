<template>
  <div class="signup-container">
    <h2>Register</h2>
    <form @submit.prevent="handleSignup">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" v-model="username" id="username" required />
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" v-model="email" id="email" required />
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" v-model="password" id="password" required />
      </div>
      <button type="submit" class="btn-register">Register</button>
    </form>
    <p class="login-link">Already registered? <router-link to="/">Login</router-link></p>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      username: '',
      email: '',
      password: '',
    };
  },
  methods: {
    async handleSignup() {
      try {
        const response = await axios.post('http://localhost:8000/api/register', {
          name: this.username,
          email: this.email,
          password: this.password,
        });
        if (response.status === 200) {
          Swal.fire({
            icon: 'success',
            title: 'You have been registered successfully',
            timer: 2500,
            showConfirmButton: false,
          });
          this.$router.push('/');
        }
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Enter valid email or password must contain minimum 4 characters',
          timer: 2000,
          showConfirmButton: false,
        });
      }
    },
  },
};
</script>

<style scoped>
.signup-container {
  width: 100%;
  max-width: 400px;
  margin: 0 auto;
  margin-top: 20px;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  color: #333;
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

button.btn-register {
  width: 100%;
  padding: 10px;
  background-color: #08305e;
  border: none;
  border-radius: 4px;
  color: white;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button.btn-register:hover {
  background-color: #357ab7;
}

.login-link {
  text-align: center;
  margin-top: 15px;
}

.login-link a {
  color: #4a90e2;
  text-decoration: none;
}

.login-link a:hover {
  text-decoration: underline;
}

/* Responsive Styles */
@media (max-width: 600px) {
  .signup-container {
    padding: 15px;
  }

  input {
    font-size: 14px;
    padding: 8px;
  }

  button.btn-register {
    font-size: 14px;
    padding: 8px;
  }
}
</style>
