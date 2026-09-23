import {
    createContext,
    useContext,
    useEffect,
    useState,
} from "react";

import api from "../api/api";


const AuthContext = createContext(null);


export function AuthProvider({ children }) {

    const [user, setUser] = useState(null);

    const [loading, setLoading] = useState(true);


    /*
    |--------------------------------------------------------------------------
    | Refresh User From Laravel
    |--------------------------------------------------------------------------
    */

    const refreshUser = async (userId = null) => {

        const id = userId || user?.id;

        if (!id) {
            return {
                success: false,
                message: "User ID not found.",
            };
        }


        try {

            const response = await api.get(
                "/get-profile",
                {
                    params: {
                        id: id,
                    },
                }
            );


            const profileUser =
                response.data?.user;


            if (!profileUser) {

                return {
                    success: false,
                    message: "Unable to load user profile.",
                };

            }


            /*
             * IMPORTANT:
             *
             * /get-profile does not return every login field.
             * Therefore merge the new profile data with
             * the existing user data.
             *
             * This keeps:
             * id
             * name
             * photo
             * etc.
             *
             * while updating:
             * investment_balance
             * deposit_balance
             * income_balance
             * aCount
             * bCount
             * rates
             */

            setUser((currentUser) => {

                const updatedUser = {
                    ...(currentUser || {}),
                    ...profileUser,
                    id: currentUser?.id || id,
                };


                localStorage.setItem(
                    "user",
                    JSON.stringify(updatedUser)
                );


                return updatedUser;

            });


            return {
                success: true,
                user: profileUser,
            };


        } catch (error) {

            console.error(
                "Refresh User Error:",
                error.response?.data || error
            );


            return {
                success: false,
                message:
                    error.response?.data?.message ||
                    "Unable to refresh user profile.",
            };

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Load Saved User
    |--------------------------------------------------------------------------
    */

    useEffect(() => {

        const initializeUser = async () => {

            const savedUser =
                localStorage.getItem("user");


            if (!savedUser) {

                setLoading(false);

                return;

            }


            try {

                const parsedUser =
                    JSON.parse(savedUser);


                /*
                 * First show saved data immediately
                 */

                setUser(parsedUser);


                /*
                 * Then get fresh balances from Laravel
                 */

                await refreshUser(parsedUser.id);


            } catch (error) {

                console.error(
                    "Initialize User Error:",
                    error
                );

                localStorage.removeItem("user");

                setUser(null);

            } finally {

                setLoading(false);

            }

        };


        initializeUser();

    }, []);


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    const login = (userData) => {

        localStorage.setItem(
            "user",
            JSON.stringify(userData)
        );


        setUser(userData);

    };


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    const logout = () => {

        localStorage.removeItem("user");

        setUser(null);

    };


    /*
    |--------------------------------------------------------------------------
    | Context
    |--------------------------------------------------------------------------
    */

    return (

        <AuthContext.Provider
            value={{
                user,
                login,
                logout,
                loading,
                refreshUser,
            }}
        >

            {children}

        </AuthContext.Provider>

    );

}


/*
|--------------------------------------------------------------------------
| Hook
|--------------------------------------------------------------------------
*/

export function useAuth() {

    return useContext(AuthContext);

}