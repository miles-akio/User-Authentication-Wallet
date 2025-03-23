import axios from 'axios';

// Create an Axios instance with a base URL and JWT token included in headers for authentication.
const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
    },
});

export default api;
