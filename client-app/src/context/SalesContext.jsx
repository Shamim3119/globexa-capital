import {
    createContext,
    useContext,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";


const SalesContext = createContext();


export function SalesProvider({ children }) {

    const { user } = useAuth();

    const today = new Date().toISOString().split("T")[0];


    const [startDate, setStartDate] = useState(
        new Date(new Date().getFullYear(), 0, 1)
            .toISOString()
            .split("T")[0]
    );

    const [endDate, setEndDate] = useState(today);

    // -1 = All, 0 = Active, 1 = Inactive
    const [inactive, setInactive] = useState("-1");

    const [clientId, setClientId] = useState("");

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");

    const [result, setResult] = useState(null);


    const statusOptions = [
        {
            label: "All",
            value: "-1",
        },
        {
            label: "Active",
            value: "0",
        },
        {
            label: "Inactive",
            value: "1",
        },
    ];


    const searchSales = async () => {

        if (!user?.id) {

            setError("User not found.");

            return {
                success: false,
                message: "User not found.",
            };

        }


        if (!startDate || !endDate) {

            const message = "Please select start and end dates.";

            setError(message);

            return {
                success: false,
                message,
            };

        }


        try {

            setLoading(true);
            setError("");


            const response = await api.get(
                `/client/${user.id}/network-investments`,
                {
                    params: {
                        start_date: startDate,
                        end_date: endDate,
                        inactive: inactive,
                        client_id: clientId || null,
                    },
                }
            );


            if (response.data?.success) {

                setResult(response.data);

                return {
                    success: true,
                    message: "Sales report loaded successfully.",
                };

            }


            const message =
                response.data?.message ||
                "Failed to load sales report.";


            setError(message);
            setResult(null);


            return {
                success: false,
                message,
            };


        } catch (error) {

            console.error(
                "Sales Report Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Failed to load sales report.";


            setError(message);
            setResult(null);


            return {
                success: false,
                message,
            };


        } finally {

            setLoading(false);

        }

    };


    const clearSales = () => {

        setResult(null);
        setError("");

    };


    return (

        <SalesContext.Provider
            value={{

                startDate,
                setStartDate,

                endDate,
                setEndDate,

                inactive,
                setInactive,

                clientId,
                setClientId,

                statusOptions,

                loading,
                error,

                result,

                searchSales,
                clearSales,

            }}
        >

            {children}

        </SalesContext.Provider>

    );

}


export function useSales() {

    const context = useContext(SalesContext);


    if (!context) {

        throw new Error(
            "useSales must be used inside SalesProvider"
        );

    }


    return context;

}