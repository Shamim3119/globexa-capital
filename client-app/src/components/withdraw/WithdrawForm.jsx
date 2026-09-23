import {
    IconMail,
    IconArrowDownCircle,
} from "@tabler/icons-react";

import React from "react";
import { useWithdraw } from "../../context/WithdrawContext";
import { useAuth } from "../../context/AuthContext";

const WithdrawForm = () => {
    const { user } = useAuth();

    const {
        accounts,
        accountsLoading,
        form,
        loading,
        selectedCurrency,
        selectedRate,
        withdrawAmount,
        otpSent,
        handleChange,
        handleAccountChange,
        sendOtp,
        withdraw,
    } = useWithdraw();

    return (
        <div className="card shadow-sm">
            <div className="card-body p-4">

                <div className="mb-4">
                    <h2 className="card-title mb-1">
                        Withdraw Request
                    </h2>

                    <p className="text-secondary mb-0">
                        Select your account and enter the withdrawal amount.
                    </p>
                </div>

                {/* Account */}

                <div className="mb-3">
                    <label className="form-label">
                        Withdraw Account
                    </label>

                    <select
                        className="form-select"
                        value={form.accountId}
                        onChange={(e) =>
                            handleAccountChange(e.target.value)
                        }
                        disabled={accountsLoading || loading}
                    >
                        <option value="">
                            Select Withdraw Account
                        </option>

                        {accounts.map((account) => (
                            <option
                                key={account.id}
                                value={account.id}
                            >
                                {account.account_no} |{" "}
                                {account.account_name} |{" "}
                                {account.operator?.name ?? ""}
                            </option>
                        ))}
                    </select>
                </div>

                {/* Currency */}

                {selectedCurrency && (
                    <div className="alert alert-info py-2">
                        <strong>Currency:</strong>{" "}
                        {selectedCurrency}
                    </div>
                )}

                {/* Balance */}

                <div className="alert alert-success py-2">
                    <strong>Income Balance:</strong>{" "}
                    ${Number(user?.income_balance ?? 0).toFixed(2)}
                </div>

                {/* Amount */}

                <div className="mb-3">
                    <label className="form-label">
                        Amount
                    </label>

                    <input
                        type="number"
                        className="form-control"
                        value={form.amount}
                        onChange={(e) =>
                            handleChange(
                                "amount",
                                e.target.value
                            )
                        }
                        placeholder="Enter amount"
                        min="0"
                        step="0.01"
                        disabled={loading}
                    />
                </div>

                {/* Non USD */}

                {selectedCurrency &&
                    selectedCurrency !== "USD" && (
                        <>
                            <div className="mb-2">
                                <strong>
                                    Withdraw Rate:
                                </strong>{" "}
                                {selectedRate.toFixed(2)}
                            </div>

                            <div className="alert alert-success">
                                <strong>
                                    Withdraw Amount:
                                </strong>{" "}
                                $
                                {withdrawAmount.toFixed(2)}
                            </div>
                        </>
                    )}

                {/* USD */}

                {selectedCurrency === "USD" && (
                    <div className="alert alert-success">
                        <strong>
                            Withdraw Amount:
                        </strong>{" "}
                        $
                        {Number(
                            form.amount || 0
                        ).toFixed(2)}
                    </div>
                )}

                {/* Send OTP */}

                {!otpSent && (

                    <button
                        type="button"
                        className="btn btn-primary w-100"
                        onClick={sendOtp}
                        disabled={loading}
                    >
                        {loading ? (
                            <>
                                <span
                                    className="spinner-border spinner-border-sm me-2"
                                />
                                Sending OTP...
                            </>
                        ) : (
                            <>
                                <IconMail
                                    size={20}
                                    className="me-2"
                                />
                                Send OTP
                            </>
                        )}
                    </button>
                )}

                {/* OTP */}

                {otpSent && (
                    <>
                        <div className="mb-3 mt-4">
                            <label className="form-label">
                                OTP
                            </label>

                            <input
                                type="text"
                                className="form-control"
                                value={form.otp}
                                onChange={(e) =>
                                    handleChange(
                                        "otp",
                                        e.target.value
                                    )
                                }
                                placeholder="Enter OTP"
                                inputMode="numeric"
                                disabled={loading}
                            />

                            <small className="text-secondary">
                                Enter the OTP sent to your email.
                            </small>
                        </div>

                        <button
                            type="button"
                            className="btn btn-primary w-100"
                            onClick={withdraw}
                            disabled={loading}
                        >
                            {loading ? (
                                <>
                                    <span
                                        className="spinner-border spinner-border-sm me-2"
                                    />
                                    Processing...
                                </>
                            ) : (
                                <>
                                    <IconArrowDownCircle
                                        size={20}
                                        className="me-2"
                                    />
                                    {form.id ? "Update Withdraw" : "Withdraw"}
                                </>
                            )}
                        </button>
                    </>
                )}
            </div>
        </div>
    );
};

export default WithdrawForm;