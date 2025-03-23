import React, { useState } from 'react';
import api from '../api';

const Signup = () => {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');

    // Handles signup form submission and API call.
    const handleSignup = async () => {
        try {
            await api.post('/signup', { username, password });
            alert('Signup successful! Please login.');
        } catch (error) {
            alert('Signup failed: ' + error.response.data.error);
        }
    };

    return (
        <div>
            <h2>Signup</h2>
            <input type="text" placeholder="Username" value={username} onChange={(e) => setUsername(e.target.value)} />
            <input type="password" placeholder="Password" value={password} onChange={(e) => setPassword(e.target.value)} />
            <button onClick={handleSignup}>Signup</button>
        </div>
    );
};

export default Signup;
