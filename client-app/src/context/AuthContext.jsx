import { createContext, useContext, useEffect, useState } from "react";


const AuthContext = createContext(null);


export function AuthProvider({ children }) {

    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);


    useEffect(() => {

        const savedUser = localStorage.getItem("user");

        if (savedUser) {
            setUser(JSON.parse(savedUser));
        }

        setLoading(false);

    }, []);



    const login = (userData) => {

        localStorage.setItem(
            "user",
            JSON.stringify(userData)
        );

        setUser(userData);

    };



    const logout = () => {

        localStorage.removeItem("user");

        setUser(null);

    };



    return (

        <AuthContext.Provider
            value={{
                user,
                login,
                logout,
                loading
            }}
        >

            {children}

        </AuthContext.Provider>

    );

}



// IMPORTANT: Login.jsx uses this export
export function useAuth() {

    return useContext(AuthContext);

}