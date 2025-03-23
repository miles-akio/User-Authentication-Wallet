import React, { useEffect, useState } from 'react';
import api from '../api';

const Dashboard = () => {
    const [walletBalance, setWalletBalance] = useState(0);
    const [depositAmount, setDepositAmount] = useState('');

    // Fetch wallet balance on component mount.
    useEffect(() => {
        const fetchBalance = async () => {
            try {
                const response = await api.get('/dashboard');
                setWalletBalance(response.data.wallet_balance);
            } catch (error) {
                alert('Error fetching wallet balance.');
            }
        };
        fetchBalance();
    }, []);

    // Handles deposit form submission and updates wallet balance.
    const handleDeposit = async () => {
        try {
            await api.post('/deposit', { amount: depositAmount });
            alert('Deposit successful!');
            setDepositAmount(''); // Clear input field after success.
        } catch (error) {
            alert('Deposit failed: ' + error.response.data.error);
        }
    };

    return (
        <div>
            <h2>Dashboard</h2>
            <p>Wallet Balance: ${walletBalance}</p>
            <input
                type="number"
                placeholder="Deposit Amount"
                value={depositAmount}
                onChange={(e) => setDepositAmount(e.target.value)}
            />
            <button onClick={handleDeposit}>Deposit</button>
        </div>
    );
};

export default Dashboard;
