import { useState } from "react";
import { useNavigate } from "react-router-dom";

import {
    IconLock,
    IconUser,
    IconArrowRight,
    IconLoader2,
    IconArrowLeft,
} from "@tabler/icons-react";

import AuthLayout from "../../layouts/AuthLayout";
import api from "../../api/api";
 
import { useAuth } from "../../context/AuthContext";


export default function Login() {

    const navigate = useNavigate();

     const { login } = useAuth();

    const [loginId, setLoginId] = useState("");
    const [password, setPassword] = useState("");

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");


    const submit = async (e) => {

        e.preventDefault();

        setError("");

        if (!loginId || !password) {

            setError(
                "Please enter Login ID and Password"
            );

            return;
        }


        try {

            setLoading(true);


            const response = await api.post(
                "/client-login",
                {
                    userid: loginId,
                    password: password,
                }
            );


            console.log(
                "Login Response:",
                response.data
            );


            if (response.data.success) {

                login(response.data.user);

                navigate("/dashboard");

            } else {

                setError(
                    response.data.message ||
                    "Invalid Login"
                );

            }


        } catch (error) {


            console.log(error);


            setError(
                error?.response?.data?.message ||
                "Server Error"
            );


        } finally {

            setLoading(false);

        }

    };


    return (

        <AuthLayout>


            <h2 className="mb-1 fw-bold">
                Welcome Back
            </h2>


            <p className="text-muted mb-4">
                Sign in to your account
            </p>



            {
                error && (

                    <div className="alert alert-danger">

                        {error}

                    </div>

                )
            }



            <form onSubmit={submit}>


                <div className="mb-3">


                    <label className="form-label">

                        Login ID

                    </label>


                    <div className="input-icon">


                        <span className="input-icon-addon">

                            <IconUser size={18}/>

                        </span>



                        <input

                            type="number"

                            className="form-control"

                            placeholder="Enter Login ID"

                            value={loginId}

                            onChange={
                                e =>
                                setLoginId(
                                    e.target.value
                                )
                            }

                        />


                    </div>


                </div>




                <div className="mb-3">


                    <label className="form-label">

                        Password

                    </label>


                    <div className="input-icon">


                        <span className="input-icon-addon">

                            <IconLock size={18}/>

                        </span>



                        <input

                            type="password"

                            className="form-control"

                            placeholder="Password"

                            value={password}

                            onChange={
                                e =>
                                setPassword(
                                    e.target.value
                                )
                            }

                        />


                    </div>


                </div>


                <div className="d-flex justify-content-between align-items-center mb-4">

                    <label className="form-check mb-0">

                        <input
                            className="form-check-input"
                            type="checkbox"
                        />

                        <span className="form-check-label">
                            Remember me
                        </span>

                    </label>


                    <button
                        type="button"
                        className="btn btn-link p-0"
                        onClick={() => navigate("/forgot-password")}
                    >
                        Forgot Password?
                    </button>

                </div>


                <button

                    className="btn btn-primary w-100 btn-lg"

                    disabled={loading}

                >


                    {
                        loading ?

                        <>
                            <IconLoader2
                                className="spinner-border spinner-border-sm me-2"
                            />

                            Please wait...

                        </>

                        :

                        <>
                            <IconArrowRight
                                size={18}
                                className="me-2"
                            />

                            Sign In

                        </>

                    }


                </button>

                <div className="text-center mt-3">
                    <a
                        href="https://globexacapital.com"
                        className="text-decoration-none"
                    >
                        <IconArrowLeft size={18} className="me-1" />
                        Back to Website
                    </a>
                </div>


            </form>


        </AuthLayout>

    );
}