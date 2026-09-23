import { useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";

import {
    IconShieldCheck,
    IconArrowRight,
    IconLoader2,
    IconArrowLeft,
} from "@tabler/icons-react";

import AuthLayout from "../../layouts/AuthLayout";
import api from "../../api/api";

import { useAuth } from "../../context/AuthContext";


export default function VerifyLoginDevice() {

    const navigate = useNavigate();

    const location = useLocation();

    const { login } = useAuth();


    /*
    |--------------------------------------------------------------------------
    | Login Device Information
    |--------------------------------------------------------------------------
    */

    const {
        userId,
        deviceId,
        email,
    } = location.state || {};


    const [otp, setOtp] = useState("");

    const [loading, setLoading] = useState(false);

    const [error, setError] = useState("");


    /*
    |--------------------------------------------------------------------------
    | Verify OTP
    |--------------------------------------------------------------------------
    */

    const verifyOtp = async (e) => {

        e.preventDefault();

        setError("");


        if (!userId || !deviceId) {

            setError(
                "Login session expired. Please login again."
            );

            return;
        }


        if (!otp.trim()) {

            setError(
                "Please enter the verification code."
            );

            return;
        }


        if (!/^\d{6}$/.test(otp)) {

            setError(
                "Verification code must be 6 digits."
            );

            return;
        }


        try {

            setLoading(true);


            const response = await api.post(
                "/verify-login-device",
                {
                    userid: userId,

                    device_id: deviceId,

                    otp: otp,

                    device_name: "Web Browser",

                    platform: "web",
                }
            );


            console.log(
                "Device Verification Response:",
                response.data
            );


            if (
                response.data?.success &&
                response.data?.token
            ) {

                /*
                |--------------------------------------------------------------------------
                | Save User + Sanctum Token
                |--------------------------------------------------------------------------
                */

                login({
                    ...response.data.user,
                    token: response.data.token,
                });


                /*
                |--------------------------------------------------------------------------
                | Go Dashboard
                |--------------------------------------------------------------------------
                */

                navigate(
                    "/dashboard",
                    {
                        replace: true,
                    }
                );


                return;
            }


            setError(
                response.data?.message ||
                "Verification failed."
            );


        } catch (error) {

            console.error(
                "Device Verification Error:",
                error
            );


            setError(
                error?.response?.data?.message ||
                "Unable to verify device."
            );


        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Back to Login
    |--------------------------------------------------------------------------
    */

    const backToLogin = () => {

        navigate(
            "/login",
            {
                replace: true,
            }
        );

    };


    return (

        <AuthLayout>


            <div className="text-center mb-4">

                <div className="mb-3">

                    <IconShieldCheck
                        size={52}
                        stroke={1.5}
                    />

                </div>


                <h2 className="mb-1 fw-bold">

                    Verify Your Device

                </h2>


                <p className="text-muted mb-0">

                    We detected a new device

                </p>

            </div>


            {
                error && (

                    <div className="alert alert-danger">

                        {error}

                    </div>

                )
            }


            <div className="alert alert-info">

                A 6-digit verification code has been
                sent to your registered email address.

                {
                    email && (

                        <div className="fw-bold mt-1">

                            {email}

                        </div>

                    )
                }

            </div>


            <form onSubmit={verifyOtp}>


                <div className="mb-4">

                    <label className="form-label">

                        Verification Code

                    </label>


                    <input
                        type="text"
                        className="form-control form-control-lg text-center"
                        placeholder="Enter 6-digit code"
                        value={otp}
                        onChange={(e) => {

                            const value =
                                e.target.value
                                    .replace(/\D/g, "")
                                    .slice(0, 6);

                            setOtp(value);

                        }}
                        inputMode="numeric"
                        maxLength={6}
                        autoFocus
                    />

                </div>


                <button
                    type="submit"
                    className="btn btn-primary w-100 btn-lg"
                    disabled={
                        loading ||
                        otp.length !== 6
                    }
                >

                    {
                        loading ?

                        <>

                            <IconLoader2
                                size={18}
                                className="spinner-border spinner-border-sm me-2"
                            />

                            Verifying...

                        </>

                        :

                        <>

                            <IconArrowRight
                                size={18}
                                className="me-2"
                            />

                            Verify & Login

                        </>

                    }

                </button>


                <div className="text-center mt-4">

                    <button
                        type="button"
                        className="btn btn-link text-decoration-none"
                        onClick={backToLogin}
                    >

                        <IconArrowLeft
                            size={18}
                            className="me-1"
                        />

                        Back to Login

                    </button>

                </div>


            </form>


        </AuthLayout>

    );
}