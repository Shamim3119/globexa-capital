import {
    createContext,
    useContext,
    useEffect,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";


const RefundContext = createContext(null);


export function RefundProvider({ children }) {

    const { user } = useAuth();


    const [investments, setInvestments] = useState([]);

    const [refundData, setRefundData] = useState(null);

    const [loading, setLoading] = useState(false);

    const [refundLoading, setRefundLoading] = useState(false);

    const [error, setError] = useState(null);


    /*
    |--------------------------------------------------------------------------
    | Load Investments
    |--------------------------------------------------------------------------
    */

    const loadInvestments = async () => {

        if (!user?.id) {
            setInvestments([]);
            return;
        }


        try {

            setLoading(true);
            setError(null);


            const response = await api.get(
                "/investment",
                {
                    params: {
                        client_id: user.id,
                    },
                }
            );


            setInvestments(
                response.data?.data || []
            );


        } catch (error) {

            console.error(
                "Investment Loading Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Failed to load investments.";


            setError(message);


        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Load Investments When User Changes
    |--------------------------------------------------------------------------
    */

    useEffect(() => {

        if (user?.id) {

            loadInvestments();

        }

    }, [user?.id]);


    /*
    |--------------------------------------------------------------------------
    | Open Refund
    |--------------------------------------------------------------------------
    */

    const openRefund = async (investmentId) => {

        if (!investmentId) {

            return {
                success: false,
                message: "Investment not found.",
            };

        }


        try {

            setRefundLoading(true);
            setError(null);


            const response = await api.get(
                "/refund",
                {
                    params: {
                        id: investmentId,
                    },
                }
            );


            if (response.data?.status) {

                setRefundData(
                    response.data.data
                );


                return {
                    success: true,
                    data: response.data.data,
                    message:
                        response.data.message ||
                        "Refund details loaded.",
                };

            }


            const message =
                response.data?.message ||
                "Unable to load refund details.";


            setError(message);


            return {
                success: false,
                message,
            };


        } catch (error) {

            console.error(
                "Refund Details Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Failed to load refund details.";


            setError(message);


            return {
                success: false,
                message,
            };


        } finally {

            setRefundLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Submit Refund
    |--------------------------------------------------------------------------
    */

    const submitRefund = async () => {

        if (!refundData?.investment?.id) {

            return {
                success: false,
                message: "Refund information not found.",
            };

        }


        try {

            setRefundLoading(true);
            setError(null);


            const response = await api.post(
                "/refund",
                {
                    investment_id:
                        refundData.investment.id,
                }
            );


            if (response.data?.status) {

                const message =
                    response.data.message ||
                    "Refund submitted successfully.";


                /*
                |--------------------------------------------------------------------------
                | Close Refund Details
                |--------------------------------------------------------------------------
                */

                setRefundData(null);


                /*
                |--------------------------------------------------------------------------
                | Refresh Investment List
                |--------------------------------------------------------------------------
                */

                await loadInvestments();


                return {
                    success: true,
                    message,
                };

            }


            const message =
                response.data?.message ||
                "Failed to submit refund.";


            setError(message);


            return {
                success: false,
                message,
            };


        } catch (error) {

            console.error(
                "Refund Submit Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Failed to submit refund.";


            setError(message);


            return {
                success: false,
                message,
            };


        } finally {

            setRefundLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Close Refund Details
    |--------------------------------------------------------------------------
    */

    const closeRefund = () => {

        setRefundData(null);

        setError(null);

    };


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    const formatDate = (dateString) => {

        if (!dateString) {
            return "-";
        }


        return new Date(
            dateString
        ).toLocaleDateString(
            "en-GB",
            {
                day: "2-digit",
                month: "short",
                year: "2-digit",
            }
        );

    };


    /*
    |--------------------------------------------------------------------------
    | Refund Button
    |--------------------------------------------------------------------------
    */

    const getRefundButton = (item) => {

        /*
        |--------------------------------------------------------------------------
        | Only Commission Plan ID 1 Can Be Refunded
        |--------------------------------------------------------------------------
        */

        if (
            Number(item?.commission_info?.id) !== 1
        ) {

            return {

                text: "Fixed Investment",

                className: "btn-danger",

                disabled: true,

            };

        }


        switch (
            Number(item?.refund_status)
        ) {

            case 1:

                return {

                    text: "Apply Refund",

                    className: "btn-warning",

                    disabled: true,

                };


            case 2:

                return {

                    text: "Refund Approved",

                    className: "btn-success",

                    disabled: true,

                };


            case 3:

                return {

                    text: "Refund Rejected",

                    className: "btn-danger",

                    disabled: false,

                };


            default:

                return {

                    text: "Refund",

                    className: "btn-primary",

                    disabled: false,

                };

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Context Value
    |--------------------------------------------------------------------------
    */

    const value = {

        investments,

        refundData,

        loading,

        refundLoading,

        error,

        loadInvestments,

        openRefund,

        submitRefund,

        closeRefund,

        formatDate,

        getRefundButton,

    };


    return (

        <RefundContext.Provider value={value}>

            {children}

        </RefundContext.Provider>

    );

}


/*
|--------------------------------------------------------------------------
| Hook
|--------------------------------------------------------------------------
*/

export function useRefund() {

    const context = useContext(
        RefundContext
    );


    if (!context) {

        throw new Error(
            "useRefund must be used inside RefundProvider"
        );

    }


    return context;

}