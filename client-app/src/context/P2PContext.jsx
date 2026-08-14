import {
    createContext,
    useContext,
    useEffect,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";

const P2PContext = createContext(null);

export function P2PProvider({ children }) {

    const { user } = useAuth();

    const [p2ps, setP2ps] = useState([]);

    const [toId, setToId] = useState("");
    const [amount, setAmount] = useState("");

    const [step, setStep] = useState(1);
    const [receiver, setReceiver] = useState(null);

    const [loading, setLoading] = useState(false);
    const [historyLoading, setHistoryLoading] = useState(false);

    const [error, setError] = useState(null);


    /*
    |--------------------------------------------------------------------------
    | Load P2P History
    |--------------------------------------------------------------------------
    */

    const loadP2P = async () => {

        if (!user?.id) {
            return;
        }

        try {

            setHistoryLoading(true);
            setError(null);

            const response = await api.get(
                `/p2p?both_id=${user.id}`
            );

            setP2ps(response.data?.data || []);

        } catch (error) {

            console.error(
                "P2P History Error:",
                error.response?.data || error
            );

            const message =
                error.response?.data?.message ||
                "Failed to load P2P records.";

            setError(message);

        } finally {

            setHistoryLoading(false);

        }
    };


    /*
    |--------------------------------------------------------------------------
    | Verify Receiver
    |--------------------------------------------------------------------------
    */

    const verifyReceiver = async () => {

        setError(null);


        if (!toId.trim()) {

            return {
                success: false,
                message: "Receiver ID is required.",
            };

        }


        if (!amount.trim()) {

            return {
                success: false,
                message: "Amount is required.",
            };

        }


        const transferAmount = Number(amount);

        const depositBalance = Number(
            user?.deposit_balance ?? 0
        );


        if (
            Number.isNaN(transferAmount) ||
            transferAmount <= 0
        ) {

            return {
                success: false,
                message: "Enter a valid amount.",
            };

        }


        if (transferAmount > depositBalance) {

            return {
                success: false,
                message:
                    "Transfer amount cannot exceed your Deposit Balance.",
            };

        }


        try {

            setLoading(true);


            const response = await api.get(
                `/client?id=${toId.trim()}`
            );


            const receiverData =
                response.data?.data;


            if (!receiverData) {

                return {
                    success: false,
                    message: "Receiver not found.",
                };

            }


            setReceiver(receiverData);

            setStep(2);


            return {
                success: true,
                message: "Receiver verified.",
                receiver: receiverData,
            };


        } catch (error) {

            console.error(
                "Receiver Verification Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Receiver not found.";


            setError(message);


            return {
                success: false,
                message,
            };

        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Confirm Transfer
    |--------------------------------------------------------------------------
    */

    const confirmTransfer = async () => {

        if (!user?.id) {

            return {
                success: false,
                message: "User not found.",
            };

        }


        try {

            setLoading(true);
            setError(null);


            await api.post("/p2p", {

                id: null,

                from_id: user.id,

                to_id: Number(toId),

                amount: Number(amount),

            });


            /*
            |--------------------------------------------------------------------------
            | Refresh P2P History
            |--------------------------------------------------------------------------
            */

            await loadP2P();


            /*
            |--------------------------------------------------------------------------
            | Reset Form
            |--------------------------------------------------------------------------
            */

            resetForm();


            return {
                success: true,
                message:
                    "Transfer completed successfully.",
            };


        } catch (error) {

            console.error(
                "P2P Transfer Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Transfer failed.";


            setError(message);


            return {
                success: false,
                message,
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

        setToId("");

        setAmount("");

        setReceiver(null);

        setStep(1);

        setError(null);

    };


    /*
    |--------------------------------------------------------------------------
    | Back to Step 1
    |--------------------------------------------------------------------------
    */

    const backToForm = () => {

        setReceiver(null);

        setStep(1);

    };


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    const formatDate = (date) => {

        if (!date) {
            return "-";
        }

        return new Date(date).toLocaleString(
            "en-GB",
            {
                day: "2-digit",
                month: "short",
                year: "2-digit",
                hour: "2-digit",
                minute: "2-digit",
            }
        );

    };


    /*
    |--------------------------------------------------------------------------
    | Load History When User Is Available
    |--------------------------------------------------------------------------
    */

    useEffect(() => {

        if (user?.id) {
            loadP2P();
        }

    }, [user?.id]);


    return (

        <P2PContext.Provider
            value={{

                p2ps,

                toId,
                setToId,

                amount,
                setAmount,

                step,
                receiver,

                loading,
                historyLoading,

                error,

                verifyReceiver,
                confirmTransfer,

                resetForm,
                backToForm,

                loadP2P,
                formatDate,

            }}
        >

            {children}

        </P2PContext.Provider>

    );

}


export function useP2P() {

    const context = useContext(P2PContext);

    if (!context) {

        throw new Error(
            "useP2P must be used inside P2PProvider"
        );

    }

    return context;

}