<template>
    <div>
      <h4>Search Books</h4>
      <div>
        <input
          type="text"
          placeholder="Search by title"
          v-model="title"
        />
        <input
          type="text"
          placeholder="Search by description"
          v-model="description"
        />
        <button @click="handleSearch">Search</button>
      </div>
      <div v-if="books.length">
        <div v-for="book in books" :key="book.id">
          <h5>{{ book.title }}</h5>
          <p>{{ book.description }}</p>
          <button @click="handleBorrow(book.id)">Borrow</button>
        </div>
      </div>
      <p v-else>No books found.</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        title: '',
        description: '',
        books: []
      };
    },
    methods: {
      async handleSearch() {
        try {
          const response = await axios.get('http://localhost:8000/api/books/search', {
            params: { title: this.title, description: this.description },
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          });
          this.books = response.data;
        } catch (error) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Error!',
            text: 'Failed to fetch books.',
            showConfirmButton: false,
            timer: 2000
          });
        }
      },
      async handleBorrow(id) {
        try {
          const response = await axios.post(
            `http://localhost:8000/api/books/borrow/${id}`,
            {},
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
              }
            }
          );
          if (response.status === 200) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Book Borrowed',
              showConfirmButton: false,
              timer: 2000
            });
          }
        } catch (error) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Error!',
            text: 'Failed to borrow book.',
            showConfirmButton: false,
            timer: 2000
          });
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>
  