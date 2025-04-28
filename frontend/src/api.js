import axios from 'axios';

let csrfTokenFetched = false;

const api = axios.create({
  baseURL: 'http://localhost:8000', // Laravel backend endpoint ( /api )
  withCredentials: true, // Ensures cookies are sent automatically
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

export default api;
