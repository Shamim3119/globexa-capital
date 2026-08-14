import {
    createContext,
    useContext,
    useEffect,
    useState
} from "react";

import api from "../api/api";

import { useAuth } from "./AuthContext";


const DashboardContext = createContext();


export function DashboardProvider({ children }) {

    const { user } = useAuth();

    const [dashboard, setDashboard] = useState(null);

    const [loading, setLoading] = useState(true);

    const [refreshing, setRefreshing] = useState(false);

    const [error, setError] = useState(null);


    useEffect(() => {

        if (user?.id) {

            loadDashboard();

        } else {

            setLoading(false);

        }

    }, [user]);


    const loadDashboard = async (isRefresh = false) => {

        if (!user?.id) {
            return;
        }


        try {

            if (isRefresh) {

                setRefreshing(true);

            } else {

                setLoading(true);

            }


            setError(null);


            const res = await api.get(
                "/dashboard-summary",
                {
                    params: {
                        user_id: user.id
                    }
                }
            );


            if (res.data.success !== false) {

                setDashboard(res.data);

            } else {

                setError(
                    res.data.message ||
                    "Unable to load dashboard."
                );

            }

        }
        catch (err) {

            console.error(
                "Dashboard API Error:",
                err
            );


            setError(
                err?.response?.data?.message ||
                "Unable to load dashboard. Please try again."
            );

        }
        finally {

            setLoading(false);

            setRefreshing(false);

        }

    };


    return (

        <DashboardContext.Provider

            value={{

                dashboard,

                loading,

                refreshing,

                error,

                loadDashboard

            }}

        >

            {children}

        </DashboardContext.Provider>

    );

}


export function useDashboard() {

    return useContext(DashboardContext);

}