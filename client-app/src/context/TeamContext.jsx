import {
    createContext,
    useContext,
    useEffect,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";

const TeamContext = createContext();


export function TeamProvider({ children }) {

    const { user } = useAuth();

    const [summary, setSummary] = useState({
        team_a: 0,
        team_b: 0,
        total: 0,

        left_balance: "0.00",
        right_balance: "0.00",
        total_balance: "0.00",

        left_tree: [],
        right_tree: [],
    });

    const [loading, setLoading] = useState(true);

    const [error, setError] = useState(null);


    useEffect(() => {

        if (user?.id) {

            loadTeam();

        } else {

            setLoading(false);

        }

    }, [user?.id]);


    const loadTeam = async () => {

        if (!user?.id) {
            return;
        }


        try {

            setLoading(true);
            setError(null);


            const res = await api.get(
                "/team-summary",
                {
                    params: {
                        id: user.id,
                    },
                }
            );


            setSummary({

                team_a: res.data?.team_a ?? 0,

                team_b: res.data?.team_b ?? 0,

                total: res.data?.total ?? 0,

                left_balance:
                    res.data?.left_balance ?? "0.00",

                right_balance:
                    res.data?.right_balance ?? "0.00",

                total_balance:
                    res.data?.total_balance ?? "0.00",

                left_tree:
                    Array.isArray(res.data?.left_tree)
                        ? res.data.left_tree
                        : [],

                right_tree:
                    Array.isArray(res.data?.right_tree)
                        ? res.data.right_tree
                        : [],

            });


        } catch (error) {

            console.error(
                "Team Error:",
                error.response?.data || error
            );


            setError(
                error.response?.data?.message ||
                "Unable to load team information."
            );

        } finally {

            setLoading(false);

        }

    };


    return (

        <TeamContext.Provider
            value={{
                summary,
                loading,
                error,
                loadTeam,
            }}
        >

            {children}

        </TeamContext.Provider>

    );

}


export function useTeam() {

    return useContext(TeamContext);

}