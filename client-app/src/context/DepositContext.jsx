import {
    createContext,
    useContext,
    useEffect,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";

const DepositContext = createContext(null);

export function DepositProvider({ children }) {

    const { user } = useAuth();

    const [deposits, setDeposits] = useState([]);
    const [businessAccounts, setBusinessAccounts] = useState([]);

    const [depositRate, setDepositRate] = useState(1);

    const [accountId, setAccountId] = useState("");
    const [amount, setAmount] = useState("");
    const [trxid, setTrxid] = useState("");

    const [image, setImage] = useState(null);

    const [loading, setLoading] = useState(false);
    const [accountsLoading, setAccountsLoading] = useState(false);

    const [error, setError] = useState(null);


    /*
    |--------------------------------------------------------------------------
    | Selected Account
    |--------------------------------------------------------------------------
    */

    const selectedAccount = businessAccounts.find(
        account =>
            String(account.id) === String(accountId)
    );


    /*
    |--------------------------------------------------------------------------
    | Converted Amount
    |--------------------------------------------------------------------------
    */

    const getConvertedAmount = () => {

        if (!amount) {
            return "";
        }

        const value = parseFloat(amount);

        if (isNaN(value)) {
            return "";
        }

        let result = value;

        if (selectedAccount?.currency !== "USD") {

            result = value * depositRate;

        }

        return result.toFixed(2);
    };


    /*
    |--------------------------------------------------------------------------
    | Load Business Accounts
    |--------------------------------------------------------------------------
    */

    const loadBusinessAccounts = async () => {

        try {

            setAccountsLoading(true);
            setError(null);

            const res = await api.get(
                "/business-accounts"
            );

            const list = res.data.data || [];

            setBusinessAccounts(list);

            setDepositRate(
                parseFloat(res.data.deposit_rate) || 1
            );

            if (list.length > 0 && !accountId) {

                setAccountId(
                    String(list[0].id)
                );

            }

        } catch (error) {

            console.error(
                "Business Accounts Error:",
                error
            );

            setError(
                error.response?.data?.message ||
                "Unable to load payment accounts."
            );

        } finally {

            setAccountsLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Load Deposits
    |--------------------------------------------------------------------------
    */

    const loadDeposits = async () => {

        if (!user?.id) {
            return;
        }

        try {

            setLoading(true);
            setError(null);

            const res = await api.get(
                "/deposits",
                {
                    params: {
                        deposit_by: user.id
                    }
                }
            );

            setDeposits(
                res.data.data || []
            );

        } catch (error) {

            console.error(
                "Deposit History Error:",
                error
            );

            setError(
                error.response?.data?.message ||
                "Unable to load deposit history."
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

        if (!user?.id) {
            return;
        }

        loadBusinessAccounts();
        loadDeposits();

    }, [user?.id]);


    /*
    |--------------------------------------------------------------------------
    | Save Deposit
    |--------------------------------------------------------------------------
    */

    const saveDeposit = async () => {

        if (!user?.id) {
            return {
                success: false,
                message: "User not found."
            };
        }


        if (!amount.trim()) {

            return {
                success: false,
                message: "Amount is required."
            };

        }

        if (!accountId) {
            return {
                success: false,
                message: "Please select a payment account."
            };
        }


        if (!trxid.trim() && !image) {

            return {
                success: false,
                message:
                    "Please provide either a TRX ID or upload a deposit document."
            };

        }


        try {

            setLoading(true);
            setError(null);

            const formData = new FormData();


            formData.append(
                "deposit_by",
                String(user.id)
            );


            formData.append(
                "account_id",
                String(accountId)
            );


            formData.append(
                "amount",
                amount.trim()
            );


            formData.append(
                "trxid",
                trxid.trim()
            );


            if (image) {

                formData.append(
                    "deposit_doc",
                    image
                );

            }


            const res = await api.post(
                "/deposits",
                formData,
                {
                    headers: {
                        "Content-Type":
                            "multipart/form-data",
                    },
                }
            );


            await loadDeposits();


            resetForm();


            return {
                success: true,
                message:
                    res.data.message ||
                    "Deposit submitted successfully."
            };


        } catch (error) {

            console.error(
                "Deposit Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Unable to submit deposit.";


            setError(message);


            return {
                success: false,
                message
            };

        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    const resetForm = () => {

        setAmount("");
        setTrxid("");
        setImage(null);

        if (businessAccounts.length > 0) {

            setAccountId(
                String(businessAccounts[0].id)
            );

        } else {

            setAccountId("");

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    const formatDate = (dateString) => {

        if (!dateString) {
            return "";
        }

        const date = new Date(dateString);

        if (isNaN(date.getTime())) {
            return "";
        }

        return date.toLocaleString(
            "en-GB",
            {
                day: "2-digit",
                month: "short",
                year: "2-digit",
                hour: "2-digit",
                minute: "2-digit",
                hour12: true,
            }
        );

    };


    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    const getStatusText = (status) => {

        switch (Number(status)) {

            case 1:
                return "Pending";

            case 2:
                return "Success";

            case 3:
                return "Cancelled";

            default:
                return "Unknown";

        }

    };


    return (

        <DepositContext.Provider
            value={{

                deposits,
                businessAccounts,

                depositRate,

                accountId,
                setAccountId,

                amount,
                setAmount,

                trxid,
                setTrxid,

                image,
                setImage,

                selectedAccount,

                convertedAmount:
                    getConvertedAmount(),

                loading,
                accountsLoading,

                error,

                loadBusinessAccounts,
                loadDeposits,

                saveDeposit,
                resetForm,

                formatDate,
                getStatusText,

            }}
        >

            {children}

        </DepositContext.Provider>

    );

}


export function useDeposit() {

    return useContext(DepositContext);

}