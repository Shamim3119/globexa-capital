import React, { createContext, useContext, useEffect, useState } from "react";
import api from "../api/api";
import { useAuth } from "./AuthContext";
import { useToast } from "./ToastContext";

const WithdrawContext = createContext(null);

export const WithdrawProvider = ({ children }) => {
 
    const { user, refreshUser } = useAuth();
    const { showToast } = useToast();

    const [withdraws, setWithdraws] = useState([]);
    const [accounts, setAccounts] = useState([]);

    const [loading, setLoading] = useState(false);
    const [accountsLoading, setAccountsLoading] = useState(false);

    const [selectedCurrency, setSelectedCurrency] = useState("");
    const [selectedRate, setSelectedRate] = useState(0);

    const [otpSent, setOtpSent] = useState(false);

    const [form, setForm] = useState({
        id: null,
        accountId: "",
        amount: "",
        otp: "",
    });

    /*
    |--------------------------------------------------------------------------
    | Load Accounts
    |--------------------------------------------------------------------------
    */

    const loadAccounts = async () => {
        if (!user?.id) return;

        setAccountsLoading(true);

        try {
            const response = await api.get(
                `/client-accounts?client_id=${user.id}`
            );

            setAccounts(response.data?.data || []);
        } catch (error) {
            console.error("Failed to load accounts:", error);

            showToast(
                error.response?.data?.message ||
                    "Failed to load withdrawal accounts.",
                "error"
            );
        } finally {
            setAccountsLoading(false);
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Load Withdraw History
    |--------------------------------------------------------------------------
    */

    const loadWithdraws = async () => {
        if (!user?.id) return;

        setLoading(true);

        try {
            const response = await api.get(
                `/withdraw?withdraw_by=${user.id}`
            );

            setWithdraws(response.data?.data || []);
        } catch (error) {
            console.error("Failed to load withdrawals:", error);

            showToast(
                error.response?.data?.message ||
                    "Failed to load withdrawal history.",
                "error"
            );
        } finally {
            setLoading(false);
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Initial Load
    |--------------------------------------------------------------------------
    */

    useEffect(() => {
        if (!user?.id) return;

        loadAccounts();
        loadWithdraws();
    }, [user?.id]);

    /*
    |--------------------------------------------------------------------------
    | Account Change
    |--------------------------------------------------------------------------
    */

    const handleAccountChange = (value) => {
        setForm((prev) => ({
            ...prev,
            accountId: value,
        }));

        const account = accounts.find(
            (item) => item.id === Number(value)
        );

        if (!account) {
            setSelectedCurrency("");
            setSelectedRate(0);
            return;
        }

        const currency =
            account.operator?.currency?.name?.toUpperCase() || "";

        setSelectedCurrency(currency);

        if (currency === "USD") {
            setSelectedRate(1);
        } else {
            setSelectedRate(
                Number(user?.withdraw_rate ?? 0)
            );
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Form Change
    |--------------------------------------------------------------------------
    */

    const handleChange = (field, value) => {
        setForm((prev) => ({
            ...prev,
            [field]: value,
        }));
    };

    /*
    |--------------------------------------------------------------------------
    | Send OTP
    |--------------------------------------------------------------------------
    */

    const sendOtp = async () => {
        if (!user) return false;

        if (!form.accountId) {
            showToast(
                "Select withdraw account.",
                "error"
            );

            return false;
        }

        if (!String(form.amount).trim()) {
            showToast(
                "Enter withdrawal amount.",
                "error"
            );

            return false;
        }

        const withdrawAmount = Number(form.amount);
        const incomeBalance = Number(
            user?.income_balance ?? 0
        );

        if (
            Number.isNaN(withdrawAmount) ||
            withdrawAmount <= 0
        ) {
            showToast(
                "Enter a valid amount.",
                "error"
            );

            return false;
        }

        if (withdrawAmount > incomeBalance) {
            showToast(
                "Withdrawal amount cannot exceed your Income Balance.",
                "error"
            );

            return false;
        }

        try {
            setLoading(true);

            await api.post("/withdraw/send-otp", {
                withdraw_by: user.id,
            });

            setOtpSent(true);

            showToast(
                "OTP sent to your email.",
                "success"
            );

            return true;
        } catch (error) {
            console.error("Send OTP error:", error);

            showToast(
                error.response?.data?.message ||
                    "Failed to send OTP.",
                "error"
            );

            return false;
        } finally {
            setLoading(false);
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Withdraw
    |--------------------------------------------------------------------------
    */

    const withdraw = async () => {
        if (!user) return false;

        if (!form.otp.trim()) {
            showToast(
                "Enter OTP.",
                "error"
            );

            return false;
        }

        try {
            setLoading(true);

            await api.post("/withdraw", {
                id: form.id,
                withdraw_by: user.id,
                account_id: Number(form.accountId),
                amount: Number(form.amount),
                otp: form.otp,
            });

            await refreshUser();

            showToast(
                form.id
                    ? "Withdraw updated successfully."
                    : "Withdraw request submitted successfully.",
                "success"
            );

            resetForm();

            await loadWithdraws();

            return true;
        } catch (error) {
            console.error("Withdraw error:", error);

            showToast(
                error.response?.data?.message ||
                    "Withdraw failed.",
                "error"
            );

            return false;
        } finally {
            setLoading(false);
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Edit Withdraw
    |--------------------------------------------------------------------------
    */

    const editWithdraw = (item) => {
        setForm({
            id: item.id,
            accountId: String(item.account_id),
            amount: String(item.amount),
            otp: "",
        });

        setOtpSent(false);

        const account = accounts.find(
            (acc) => acc.id === Number(item.account_id)
        );

        if (account) {
            const currency =
                account.operator?.currency?.name?.toUpperCase() || "";

            setSelectedCurrency(currency);

            if (currency === "USD") {
                setSelectedRate(1);
            } else {
                setSelectedRate(
                    Number(user?.withdraw_rate ?? 0)
                );
            }
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    const resetForm = () => {
        setForm({
            id: null,
            accountId: "",
            amount: "",
            otp: "",
        });

        setOtpSent(false);
        setSelectedCurrency("");
        setSelectedRate(0);
    };

    /*
    |--------------------------------------------------------------------------
    | Account Name
    |--------------------------------------------------------------------------
    */

    const accountName = (id) => {
        const account = accounts.find(
            (acc) => acc.id === Number(id)
        );

        if (!account) {
            return "Unknown";
        }

        return `${account.account_name} (${account.account_no})`;
    };

    /*
    |--------------------------------------------------------------------------
    | Calculated Withdraw Amount
    |--------------------------------------------------------------------------
    */

    const withdrawAmount =
        selectedCurrency === "USD"
            ? Number(form.amount || 0)
            : Number(form.amount || 0) * selectedRate;

    /*
    |--------------------------------------------------------------------------
    | Context
    |--------------------------------------------------------------------------
    */

    const value = {
        withdraws,
        accounts,

        loading,
        accountsLoading,

        form,
        setForm,

        selectedCurrency,
        selectedRate,
        withdrawAmount,

        otpSent,

        handleChange,
        handleAccountChange,

        sendOtp,
        withdraw,

        editWithdraw,
        resetForm,

        accountName,

        loadAccounts,
        loadWithdraws,
    };

    return (
        <WithdrawContext.Provider value={value}>
            {children}
        </WithdrawContext.Provider>
    );
};

export const useWithdraw = () => {
    const context = useContext(WithdrawContext);

    if (!context) {
        throw new Error(
            "useWithdraw must be used inside WithdrawProvider"
        );
    }

    return context;
};