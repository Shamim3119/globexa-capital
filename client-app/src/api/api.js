import axios from "axios";

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL,

    headers: {
        Accept: "application/json",
        // "Content-Type": "application/json",
    },

    timeout: 30000,
});



api.interceptors.request.use(
    (config) => {

        const savedUser =
            localStorage.getItem("user");

        if (savedUser) {

            try {

                const user =
                    JSON.parse(savedUser);

                if (user?.token) {

                    config.headers.Authorization =
                        `Bearer ${user.token}`;

                }

            } catch (error) {

                console.error(
                    "Failed to read auth token:",
                    error
                );

            }

        }

        return config;

    },

    (error) => Promise.reject(error)
);

export default api;