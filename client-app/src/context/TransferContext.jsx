import {
    createContext,
    useContext,
    useEffect,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";

const TransferContext = createContext(null);


export function TransferProvider({ children }) {

    const { user } = useAuth();


    // --------------------------------------------------
    // Transfer History
    // --------------------------------------------------

    const [transfers, setTransfers] = useState([]);

    const [historyLoading, setHistoryLoading] = useState(false);


    // --------------------------------------------------
    // Transfer Form
    // --------------------------------------------------

    const [amount, setAmount] = useState("");

    const [step, setStep] = useState(1);

    const [loading, setLoading] = useState(false);

    const [error, setError] = useState(null);


    // --------------------------------------------------
    // Balances
    // --------------------------------------------------

    const incomeBalance = Number(
        user?.income_balance ?? 0
    );

    const depositBalance = Number(
        user?.deposit_balance ?? 0
    );


    const transferAmount = Number(
        amount || 0
    );


    const afterIncomeBalance =
        incomeBalance - transferAmount;


    const afterDepositBalance =
        depositBalance + transferAmount;


    // --------------------------------------------------
    // Load Transfer History
    // --------------------------------------------------

    const loadTransfers = async () => {

        if (!user?.id) {
            return;
        }


        try {

            setHistoryLoading(true);
            setError(null);


            const response = await api.get(
                "/transfer",
                {
                    params: {
                        client_id: user.id,
                    },
                }
            );


            /*
             * Depending on your Laravel API response,
             * data may be directly an array or inside
             * response.data.data.
             */

            const data =
                response.data?.data ??
                response.data ??
                [];


            setTransfers(
                Array.isArray(data)
                    ? data
                    : []
            );


        } catch (error) {

            console.error(
                "Transfer History Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Failed to load transfer history.";


            setError(message);

        } finally {

            setHistoryLoading(false);

        }

    };


    // --------------------------------------------------
    // Load History When User Changes
    // --------------------------------------------------

    useEffect(() => {

        if (user?.id) {

            loadTransfers();

        } else {

            setTransfers([]);

        }

    }, [user?.id]);


    // --------------------------------------------------
    // Validate Transfer
    // --------------------------------------------------

    const verifyTransfer = () => {

        setError(null);


        // Amount empty

        if (!String(amount).trim()) {

            return {
                success: false,
                message: "Amount is required.",
            };

        }


        const value = Number(amount);


        // Invalid amount

        if (
            Number.isNaN(value) ||
            value <= 0
        ) {

            return {
                success: false,
                message: "Please enter a valid amount.",
            };

        }


        // Insufficient income balance

        if (value > incomeBalance) {

            return {
                success: false,
                message:
                    "Transfer amount cannot exceed your Income Balance.",
            };

        }


        // Everything is valid

        setStep(2);


        return {
            success: true,
        };

    };


    // --------------------------------------------------
    // Confirm Transfer
    // --------------------------------------------------

    const confirmTransfer = async () => {

        if (!user?.id) {

            return {
                success: false,
                message: "User not found.",
            };

        }


        const value = Number(amount);


        if (
            Number.isNaN(value) ||
            value <= 0
        ) {

            return {
                success: false,
                message: "Please enter a valid amount.",
            };

        }


        if (value > incomeBalance) {

            return {
                success: false,
                message:
                    "Transfer amount cannot exceed your Income Balance.",
            };

        }


        try {

            setLoading(true);
            setError(null);


            // --------------------------------------------------
            // Submit Transfer
            // --------------------------------------------------

            const response = await api.post(
                "/transfer",
                {
                    id: null,

                    client_id: user.id,

                    amount: value,
                }
            );


            // --------------------------------------------------
            // Reload Transfer History
            // --------------------------------------------------

            await loadTransfers();


            // --------------------------------------------------
            // Reset Form
            // --------------------------------------------------

            resetForm();


            return {
                success: true,

                message:
                    response.data?.message ||
                    "Transfer completed successfully.",
            };


        } catch (error) {

            console.error(
                "Transfer Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Unable to complete transfer.";


            setError(message);


            return {
                success: false,
                message,
            };

        } finally {

            setLoading(false);

        }

    };


    // --------------------------------------------------
    // Reset Transfer Form
    // --------------------------------------------------

    const resetForm = () => {

        setAmount("");

        setStep(1);

        setError(null);

    };


    // --------------------------------------------------
    // Format Date
    // --------------------------------------------------

    const formatDate = (date) => {

        if (!date) {
            return "-";
        }


        const parsedDate = new Date(date);


        if (Number.isNaN(parsedDate.getTime())) {
            return "-";
        }


        return parsedDate.toLocaleString(
            "en-GB",
            {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            }
        );

    };


    // --------------------------------------------------
    // Context
    // --------------------------------------------------

    const value = {

        // History
        transfers,
        loadTransfers,
        historyLoading,

        // Form
        amount,
        setAmount,

        step,
        setStep,

        loading,

        error,

        // Balances
        incomeBalance,
        depositBalance,

        transferAmount,

        afterIncomeBalance,
        afterDepositBalance,

        // Actions
        verifyTransfer,
        confirmTransfer,
        resetForm,

        // Helpers
        formatDate,

    };


    return (

        <TransferContext.Provider value={value}>

            {children}

        </TransferContext.Provider>

    );

}


// --------------------------------------------------
// Hook
// --------------------------------------------------

export function useTransfer() {

    const context =
        useContext(TransferContext);


    if (!context) {

        throw new Error(
            "useTransfer must be used inside TransferProvider"
        );

    }


    return context;

}