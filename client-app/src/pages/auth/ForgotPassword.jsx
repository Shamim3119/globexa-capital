import { useState } from "react";
import { useNavigate } from "react-router-dom";

import {
    IconArrowLeft,
    IconArrowRight,
    IconEye,
    IconEyeOff,
    IconLoader2,
    IconLock,
    IconUser,
    IconShieldCheck,
} from "@tabler/icons-react";

import AuthLayout from "../../layouts/AuthLayout";
import api from "../../api/api";


export default function ForgotPassword() {

    const navigate = useNavigate();


    const [step, setStep] = useState(1);

    const [userId, setUserId] = useState("");
    const [otp, setOtp] = useState("");

    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");

    const [showPassword, setShowPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");


    /*
    |--------------------------------------------------------------------------
    | STEP 1
    | Check User ID
    |--------------------------------------------------------------------------
    */

    const submitUserID = async (e) => {

        e.preventDefault();

        setError("");
        setSuccess("");


        if (!userId.trim()) {

            setError("User ID is required.");

            return;

        }


        try {

            setLoading(true);


            const response = await api.post(
                `/check-id?userid=${encodeURIComponent(userId)}`
            );


            console.log(
                "Check ID Response:",
                response.data
            );


            if (response.data.success) {

                setStep(2);

            } else {

                setError(
                    response.data.message ||
                    "User ID not found."
                );

            }


        } catch (error) {

            console.error(
                "Check ID Error:",
                error
            );


            setError(
                error?.response?.data?.message ||
                "Something went wrong."
            );

        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | STEP 2
    | Verify OTP
    |--------------------------------------------------------------------------
    */

    const submitOtp = async (e) => {

        e.preventDefault();

        setError("");
        setSuccess("");


        if (!otp.trim()) {

            setError("OTP is required.");

            return;

        }


        try {

            setLoading(true);


            const response = await api.post(
                `/check-otp?userid=${encodeURIComponent(
                    userId
                )}&otp=${encodeURIComponent(otp)}`
            );


            console.log(
                "Check OTP Response:",
                response.data
            );


            if (response.data.success) {

                setStep(3);

            } else {

                setError(
                    response.data.message ||
                    "Invalid OTP."
                );

            }


        } catch (error) {

            console.error(
                "Check OTP Error:",
                error
            );


            setError(
                error?.response?.data?.message ||
                "Something went wrong."
            );

        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | STEP 3
    | Reset Password
    |--------------------------------------------------------------------------
    */

    const submitReset = async (e) => {

        e.preventDefault();

        setError("");
        setSuccess("");


        if (!password.trim()) {

            setError("Password is required.");

            return;

        }


        if (!confirmPassword.trim()) {

            setError(
                "Confirm Password is required."
            );

            return;

        }


        if (password !== confirmPassword) {

            setError(
                "Passwords do not match."
            );

            return;

        }


        try {

            setLoading(true);


            const response = await api.post(
                `/reset?userid=${encodeURIComponent(
                    userId
                )}&otp=${encodeURIComponent(
                    otp
                )}&password=${encodeURIComponent(
                    password
                )}`
            );


            console.log(
                "Reset Password Response:",
                response.data
            );


            if (response.data.success) {

                setSuccess(
                    response.data.message ||
                    "Password reset successful."
                );


                setTimeout(() => {

                    navigate("/");

                }, 2000);


            } else {

                setError(
                    response.data.message ||
                    "Password reset failed."
                );

            }


        } catch (error) {

            console.error(
                "Reset Password Error:",
                error
            );


            setError(
                error?.response?.data?.message ||
                "Something went wrong."
            );

        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Back
    |--------------------------------------------------------------------------
    */

    const goBack = () => {

        if (step === 1) {

            navigate("/");

            return;

        }


        setError("");
        setSuccess("");

        setStep(step - 1);

    };


    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    return (

        <AuthLayout>


            {/* Header */}

            <div className="text-center mb-4">

                <div
                    className="avatar avatar-lg rounded-circle bg-primary-lt mb-3"
                    style={{
                        margin: "0 auto",
                    }}
                >

                    {step === 1 && (
                        <IconUser size={28} />
                    )}

                    {step === 2 && (
                        <IconShieldCheck size={28} />
                    )}

                    {step === 3 && (
                        <IconLock size={28} />
                    )}

                </div>


                <h2 className="mb-1 fw-bold">

                    {step === 1 && "Forgot Password"}

                    {step === 2 && "OTP Verification"}

                    {step === 3 && "Reset Password"}

                </h2>


                <p className="text-muted mb-0">

                    {step === 1 &&
                        "Enter your Login ID to continue."}

                    {step === 2 &&
                        "Enter the OTP sent to your account."}

                    {step === 3 &&
                        "Create a new password for your account."}

                </p>

            </div>


            {/* Step Indicator */}

            <div className="row mb-4">

                <div className="col">

                    <div
                        className={
                            step >= 1
                                ? "progress progress-sm"
                                : "progress progress-sm"
                        }
                    >

                        <div
                            className="progress-bar"
                            style={{
                                width:
                                    step === 1
                                        ? "33%"
                                        : step === 2
                                        ? "66%"
                                        : "100%",
                            }}
                        />

                    </div>

                </div>

            </div>


            {/* Error */}

            {error && (

                <div
                    className="alert alert-danger"
                    role="alert"
                >

                    {error}

                </div>

            )}


            {/* Success */}

            {success && (

                <div
                    className="alert alert-success"
                    role="alert"
                >

                    {success}

                </div>

            )}


            {/* ================================================== */}
            {/* STEP 1 */}
            {/* ================================================== */}

            {step === 1 && (

                <form onSubmit={submitUserID}>

                    <div className="mb-3">

                        <label className="form-label">

                            Login ID

                        </label>


                        <div className="input-icon">

                            <span className="input-icon-addon">

                                <IconUser size={18} />

                            </span>


                            <input
                                type="number"
                                className="form-control"
                                placeholder="Enter Login ID"
                                value={userId}
                                onChange={(e) =>
                                    setUserId(
                                        e.target.value
                                    )
                                }
                                disabled={loading}
                                autoFocus
                            />

                        </div>

                    </div>


                    <button
                        type="submit"
                        className="btn btn-primary w-100"
                        disabled={loading}
                    >

                        {loading ? (

                            <>
                                <IconLoader2
                                    size={18}
                                    className="me-2 spinner-border spinner-border-sm"
                                />

                                Checking...

                            </>

                        ) : (

                            <>
                                Continue

                                <IconArrowRight
                                    size={18}
                                    className="ms-2"
                                />

                            </>

                        )}

                    </button>


                    <button
                        type="button"
                        className="btn btn-link w-100 mt-3"
                        onClick={() => navigate("/")}
                        disabled={loading}
                    >

                        <IconArrowLeft
                            size={18}
                            className="me-1"
                        />

                        Back to Login

                    </button>

                </form>

            )}


            {/* ================================================== */}
            {/* STEP 2 */}
            {/* ================================================== */}

            {step === 2 && (

                <form onSubmit={submitOtp}>

                    <div className="mb-3">

                        <label className="form-label">

                            OTP

                        </label>


                        <div className="input-icon">

                            <span className="input-icon-addon">

                                <IconShieldCheck size={18} />

                            </span>


                            <input
                                type="text"
                                className="form-control text-center"
                                placeholder="Enter OTP"
                                value={otp}
                                onChange={(e) =>
                                    setOtp(
                                        e.target.value
                                    )
                                }
                                disabled={loading}
                                autoFocus
                            />

                        </div>

                    </div>


                    <div className="text-secondary small text-center mb-3">

                        Login ID:

                        <strong className="ms-1">

                            {userId}

                        </strong>

                    </div>


                    <button
                        type="submit"
                        className="btn btn-primary w-100"
                        disabled={loading}
                    >

                        {loading ? (

                            <>
                                <IconLoader2
                                    size={18}
                                    className="me-2 spinner-border spinner-border-sm"
                                />

                                Verifying...

                            </>

                        ) : (

                            <>
                                Verify OTP

                                <IconArrowRight
                                    size={18}
                                    className="ms-2"
                                />

                            </>

                        )}

                    </button>


                    <button
                        type="button"
                        className="btn btn-link w-100 mt-3"
                        onClick={goBack}
                        disabled={loading}
                    >

                        <IconArrowLeft
                            size={18}
                            className="me-1"
                        />

                        Back

                    </button>

                </form>

            )}


            {/* ================================================== */}
            {/* STEP 3 */}
            {/* ================================================== */}

            {step === 3 && (

                <form onSubmit={submitReset}>

                    {/* Password */}

                    <div className="mb-3">

                        <label className="form-label">

                            New Password

                        </label>


                        <div className="input-icon">

                            <span className="input-icon-addon">

                                <IconLock size={18} />

                            </span>


                            <input
                                type={
                                    showPassword
                                        ? "text"
                                        : "password"
                                }
                                className="form-control"
                                placeholder="Enter new password"
                                value={password}
                                onChange={(e) =>
                                    setPassword(
                                        e.target.value
                                    )
                                }
                                disabled={loading}
                                autoFocus
                            />


                            <span
                                className="input-icon-addon"
                                style={{
                                    cursor: "pointer",
                                }}
                                onClick={() =>
                                    setShowPassword(
                                        !showPassword
                                    )
                                }
                            >

                                {showPassword ? (

                                    <IconEyeOff size={18} />

                                ) : (

                                    <IconEye size={18} />

                                )}

                            </span>

                        </div>

                    </div>


                    {/* Confirm Password */}

                    <div className="mb-4">

                        <label className="form-label">

                            Confirm Password

                        </label>


                        <div className="input-icon">

                            <span className="input-icon-addon">

                                <IconLock size={18} />

                            </span>


                            <input
                                type={
                                    showConfirmPassword
                                        ? "text"
                                        : "password"
                                }
                                className="form-control"
                                placeholder="Confirm new password"
                                value={confirmPassword}
                                onChange={(e) =>
                                    setConfirmPassword(
                                        e.target.value
                                    )
                                }
                                disabled={loading}
                            />


                            <span
                                className="input-icon-addon"
                                style={{
                                    cursor: "pointer",
                                }}
                                onClick={() =>
                                    setShowConfirmPassword(
                                        !showConfirmPassword
                                    )
                                }
                            >

                                {showConfirmPassword ? (

                                    <IconEyeOff size={18} />

                                ) : (

                                    <IconEye size={18} />

                                )}

                            </span>

                        </div>

                    </div>


                    <button
                        type="submit"
                        className="btn btn-primary w-100"
                        disabled={loading}
                    >

                        {loading ? (

                            <>
                                <IconLoader2
                                    size={18}
                                    className="me-2 spinner-border spinner-border-sm"
                                />

                                Saving...

                            </>

                        ) : (

                            <>
                                Reset Password

                                <IconLock
                                    size={18}
                                    className="ms-2"
                                />

                            </>

                        )}

                    </button>


                    <button
                        type="button"
                        className="btn btn-link w-100 mt-3"
                        onClick={goBack}
                        disabled={loading}
                    >

                        <IconArrowLeft
                            size={18}
                            className="me-1"
                        />

                        Back

                    </button>

                </form>

            )}

        </AuthLayout>

    );

}