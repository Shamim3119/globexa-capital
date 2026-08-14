import {
    createContext,
    useContext,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";


const IncomeContext = createContext();


export function IncomeProvider({ children }) {

    const { user } = useAuth();

    const [incomeType, setIncomeType] = useState("All");

    const [fromDate, setFromDate] = useState(
        new Date().toISOString().split("T")[0]
    );

    const [toDate, setToDate] = useState(
        new Date().toISOString().split("T")[0]
    );

    const [rows, setRows] = useState([]);

    const [total, setTotal] = useState(0);

    const [reportType, setReportType] = useState("");

    const [loading, setLoading] = useState(false);

    const [error, setError] = useState(null);


    const incomeTypes = [
        {
            label: "ALL",
            value: "All",
        },
        {
            label: "Investment Income",
            value: "Daily Income",
        },
        {
            label: "Reference Income",
            value: "References Income",
        },
        {
            label: "Generation Income",
            value: "Generation Income",
        },
        {
            label: "Salary Income",
            value: "Salaries Income",
        },
        {
            label: "IB Income",
            value: "IBS Income",
        },
    ];


    const searchIncome = async () => {

        if (!user?.id) {

            setError("User not found.");

            return {
                success: false,
                message: "User not found.",
            };

        }


        if (!incomeType) {

            setError("Please select income type.");

            return {
                success: false,
                message: "Please select income type.",
            };

        }


        if (!fromDate || !toDate) {

            setError("Please select both dates.");

            return {
                success: false,
                message: "Please select both dates.",
            };

        }


        try {

            setLoading(true);
            setError(null);


            const response = await api.get(
                "/incomes",
                {
                    params: {
                        client_id: user.id,
                        type: incomeType,
                        from_date: fromDate,
                        to_date: toDate,
                    },
                }
            );


            setRows(
                response.data?.data || []
            );


            setTotal(
                response.data?.total || 0
            );


            setReportType(
                response.data?.type || ""
            );


            return {
                success: true,
                message: "Income loaded successfully.",
            };


        } catch (error) {

            console.error(
                "Income Search Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Failed to load income.";


            setError(message);


            setRows([]);
            setTotal(0);


            return {
                success: false,
                message,
            };


        } finally {

            setLoading(false);

        }

    };


    const formatDisplayDate = (dateString) => {

        if (!dateString) {
            return "-";
        }


        const date = new Date(dateString);


        if (Number.isNaN(date.getTime())) {
            return "-";
        }


        return date.toLocaleDateString(
            "en-GB",
            {
                day: "2-digit",
                month: "short",
                year: "2-digit",
            }
        );

    };


    const formatAmount = (amount) => {

        return Number(
            amount || 0
        ).toFixed(5);

    };


    const formatTotal = (amount) => {

        return Number(
            amount || 0
        ).toFixed(2);

    };


    const clearIncome = () => {

        setRows([]);
        setTotal(0);
        setReportType("");
        setError(null);

    };


    return (

        <IncomeContext.Provider
            value={{

                incomeType,
                setIncomeType,

                fromDate,
                setFromDate,

                toDate,
                setToDate,

                rows,
                total,
                reportType,

                loading,
                error,

                incomeTypes,

                searchIncome,

                formatDisplayDate,
                formatAmount,
                formatTotal,

                clearIncome,

            }}
        >

            {children}

        </IncomeContext.Provider>

    );

}


export function useIncome() {

    const context = useContext(
        IncomeContext
    );


    if (!context) {

        throw new Error(
            "useIncome must be used inside IncomeProvider"
        );

    }


    return context;

}