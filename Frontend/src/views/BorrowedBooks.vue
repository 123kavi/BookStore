<template>
  <div class="container">
    <!-- Search Section -->
    <div class="search-section">
      <div class="search-input-container">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search borrowed books by title or description"
          class="search-input"
        />
        <i @click="searchBorrowedBooks" class="fas fa-search search-icon"></i>
      </div>
    </div>

    <!-- Borrowed Books List -->
    <div class="borrowed-books-section">
      <h4>Borrowed Books</h4>
      <div v-if="filteredBorrowedBooks.length">
        <div v-for="borrowedBook in filteredBorrowedBooks" :key="borrowedBook.id" class="borrowed-book-item">
          <h5>{{ borrowedBook.book.title }}</h5>
          <p>{{ borrowedBook.book.description }}</p>
          <button @click="handleReturn(borrowedBook.book_id)" class="return-button">Return</button>
        </div>
      </div>
      <div v-else>
        <p>No borrowed books found.</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      borrowedBooks: [], // This will hold the list of borrowed books
      searchQuery: '',
      filteredBorrowedBooks: [] // This will hold the filtered list of borrowed books
    };
  },
  async created() {
    await this.fetchBorrowedBooks();
  },
  methods: {
    async fetchBorrowedBooks() {
      try {
        const response = await axios.get('http://localhost:8000/api/books/borrowed', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        });
        this.borrowedBooks = response.data;
        this.filteredBorrowedBooks = response.data; // Initialize filtered books
      } catch (error) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Error!',
          text: 'Failed to fetch borrowed books.',
          showConfirmButton: false,
          timer: 2000
        });
      }
    },
    async handleReturn(bookId) {
      try {
        const response = await axios.post(
          `http://localhost:8000/api/books/return/${bookId}`,
          {},
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          }
        );
        if (response.status === 200) {
          this.borrowedBooks = this.borrowedBooks.filter(book => book.book_id !== bookId);
          this.filteredBorrowedBooks = this.filteredBorrowedBooks.filter(book => book.book_id !== bookId);
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Book Returned',
            showConfirmButton: false,
            timer: 2000
          });
        }
      } catch (error) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Error!',
          text: 'Failed to return book.',
          showConfirmButton: false,
          timer: 2000
        });
      }
    },
    searchBorrowedBooks() {
      if (this.searchQuery.trim() === '') {
        this.filteredBorrowedBooks = this.borrowedBooks;
      } else {
        this.filteredBorrowedBooks = this.borrowedBooks.filter(book =>
          book.book.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          book.book.description.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }
    }
  }
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

/* Borrowed books section styling */
.borrowed-books-section {
  margin-top: 20px;
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 0 5px rgba(46, 41, 41, 0.3);
  background-color: hsl(0, 80%, 99%);
}

/* Style for each borrowed book item */
.borrowed-book-item {
  margin-bottom: 20px;
}

/* Return button styling */
.return-button {
  border: none;
  padding: 10px 20px;
  border-radius: 25px;
  background-color: #5a3461;
  color: white;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.return-button:hover {
  background-color: hsl(320, 6%, 82%);
}
</style>
