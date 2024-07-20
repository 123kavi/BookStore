<template>
  <div class="container">
  

    <!-- Search Section -->
    <div class="search-section">
      <div class="search-input-container">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search by title, description, or genre"
          class="search-input"
        />
        <i @click="searchBooks" class="fas fa-search search-icon"></i>
      </div>
    </div>

    <!-- Books List -->
    <div v-if="books.data.length">
      <ul>
        <li v-for="book in books.data" :key="book.id" class="book-item">
          <img :src="book.image_url" :alt="book.title" class="book-image" />
          <p class="title"> {{ book.title }}</p>
          <p class="description">Description: {{ book.description }}</p>
          <p>Genre: {{ book.genre }}</p>
          <p class="price">Price: {{ book.price }}</p>
          <button @click="borrowBook(book.id)" class="rounded-button">Borrow</button>
        </li>
      </ul>
    </div>
    <div v-else>
      <p>No books available.</p>
    </div>

    <!-- Pagination Controls -->
    <div class="pagination">
      <button
        @click="fetchBooks(books.prev_page_url)"
        :disabled="!books.prev_page_url"
        class="rounded-button"
      >
        Previous
      </button>
      <span>Page {{ books.current_page }} of {{ books.last_page }}</span>
      <button
        @click="fetchBooks(books.next_page_url)"
        :disabled="!books.next_page_url"
        class="rounded-button"
      >
        Next
      </button>
    </div>
  </div>
</template>


<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import Header from '../views/Header.vue'; // Import the Header component

export default {
  components: {
    Header
  },
  data() {
    return {
      books: { data: [], prev_page_url: null, next_page_url: null, current_page: 1, last_page: 1 },
      searchQuery: '',
    };
  },
  async created() {
    await this.fetchBooks();
  },
  methods: {
    async fetchBooks(url = 'http://localhost:8000/api/books') {
      try {
        const response = await axios.get(url, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.books = response.data;
      } catch (error) {
        console.error("There was an error fetching the books:", error);
      }
    },
    async searchBooks() {
      try {
        const response = await axios.get('http://localhost:8000/api/books/search', {
          params: { query: this.searchQuery },
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.books = response.data;
      } catch (error) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Error!',
          text: 'Failed to fetch books.',
          showConfirmButton: false,
          timer: 2000,
        });
      }
    },
    async borrowBook(bookId) {
      try {
        const response = await axios.post(
          `http://localhost:8000/api/books/borrow/${bookId}`,
          {},
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          }
        );
        if (response.status === 200) {
          await this.fetchBooks();
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Book Borrowed',
            showConfirmButton: false,
            timer: 2000,
          });
        }
      } catch (error) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Error!',
          text: 'Failed to borrow book.',
          showConfirmButton: false,
          timer: 2000,
        });
      }
    },
  },
};
</script>

<style scoped>
/* Container for the entire component */
.container {
  padding: 20px;
  border-radius: 0px; /* Optional: Add slight rounding to corners */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  background-color: #fffefe;
}

/* Search section styling */
.search-section {
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

/* Rounded button styling */
.rounded-button {
  border: none;
  padding: 10px 20px;
  border-radius: 25px;
  background-color: #5a3461;
  color: white;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.rounded-button:hover {
  background-color: hsl(320, 6%, 82%);
}

/* Flexbox container for the book list */
ul {
  display: flex;
  flex-wrap: wrap;
  list-style-type: none;
  padding: 0;
  margin: 0;
  gap: 10px;
}

/* Style for each book item */
.book-item {
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 8px; /* Rounded corners */
  box-shadow: 0 0 5px rgba(46, 41, 41, 0.3);
  background-color: hsl(0, 80%, 99%);
  flex: 1 1 calc(25% - 20px); /* Adjust size of the book box */
  margin-bottom: 20px;
  box-sizing: border-box;
}

/* Ensure the book title does not have top margin */
.book-item h2 {
  margin-top: 0;
}

/* Style for the book image */
.book-image {
  width: 100%; /* Adjust as needed */
  height: auto;
  border-radius: 5px;
  margin-bottom: 10px;
}

/* Add margin to the button inside book items */
.book-item button {
  margin-top: 10px;
  border-radius: 25px;
}

/* Price in red color */
.book-item .price {
  color: red;
  font-weight: bold;
}

/* Description in pink color */
.book-item .description {
  color: rgb(238, 11, 216);
}
.book-item .title {
  color: rgb(71, 3, 65);
  font-family: 'Arial', sans-serif; /* Example sans-serif font-family */
  font-style: italic; /* Italic font style */
  font-weight: bold; /* Bold font style */
}

/* Pagination styling */
.pagination {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.pagination button {
  margin: 0 10px;
  padding: 10px 20px;
  border: none;
  border-radius: 25px;
  background-color: hsla(309, 100%, 50%, 0.426);
  color: white;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.pagination button:disabled {
  background-color: #ffffff;
  cursor: not-allowed;
}

.pagination button:hover {
  background-color: #0056b3;
}

/* Search input styling */
.search-input {
  padding: 10px;
  border: 1px solid #6b2121; /* Updated border color */
  border-radius: 25px;
  width: 100%;
  box-sizing: border-box;
  font-size: 16px;
  font-family: 'Arial', sans-serif; /* Example sans-serif font-family */
  font-style: italic; /* Italic font style */
  font-weight: bold; /* Bold font style */
}

.search-input-container {
  position: relative;
}

.search-icon {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #007bff;
  font-size: 18px;
}

.search-icon:hover {
  color: #0056b3;
}

.search-input:focus {
  border-color: #007bff;
  outline: none;
}

</style>
