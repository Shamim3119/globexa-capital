import React from "react";
import { useWithdraw } from "../../context/WithdrawContext";

const WithdrawHistory = () => {
    const {
        withdraws,
        loading,
        accountName,
        editWithdraw,
    } = useWithdraw();

    const getStatus = (statusId) => {
        switch (Number(statusId)) {
            case 1:
                return {
                    text: "Pending",
                    className: "bg-warning text-dark",
                };

            case 2:
                return {
                    text: "Approved",
                    className: "bg-success text-white",
                };

            default:
                return {
                    text: "Rejected",
                    className: "bg-danger text-white",
                };
        }
    };

    const formatDate = (date) => {
        if (!date) return "-";

        return new Date(date).toLocaleString("en-GB", {
            day: "2-digit",
            month: "short",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        });
    };

    if (loading) {
        return (
            <div className="card">
                <div className="card-body text-center py-5">
                    <div className="spinner-border text-primary" />
                    <div className="text-secondary mt-2">
                        Loading withdrawal history...
                    </div>
                </div>
            </div>
        );
    }

    if (!withdraws.length) {
        return (
            <div className="card">
                <div className="card-body text-center py-5">
                    <div className="empty">
                        <div className="empty-img">
                            <i className="ti ti-wallet-off fs-1 text-secondary" />
                        </div>

                        <p className="empty-title">
                            No withdrawal requests
                        </p>

                        <p className="empty-subtitle text-secondary">
                            You have not submitted any withdrawal request yet.
                        </p>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="row row-cards">
            {withdraws.map((item) => {
                const status = getStatus(
                    item.status_id
                );

                return (
                    <div
                        className="col-12"
                        key={item.id}
                    >
                        <div className="card shadow-sm">
                            <div className="card-body">

                                {/* Header */}

                                <div className="d-flex justify-content-between align-items-center mb-3">
                                    <h3 className="card-title mb-0">
                                        Withdraw Request
                                    </h3>

                                    <span
                                        className={`badge ${status.className}`}
                                    >
                                        {status.text}
                                    </span>
                                </div>

                                <div className="hr-text">
                                    Details
                                </div>

                                {/* Details */}

                                <div className="row g-3">

                                    <div className="col-md-6">
                                        <div className="text-secondary">
                                            Amount
                                        </div>

                                        <div className="fw-bold text-success fs-3">
                                            $
                                            {Number(
                                                item.amount
                                            ).toFixed(2)}
                                        </div>
                                    </div>

                                    <div className="col-md-6">
                                        <div className="text-secondary">
                                            Withdraw Account
                                        </div>

                                        <div className="fw-semibold">
                                            {accountName(
                                                item.account_id
                                            )}
                                        </div>
                                    </div>

                                    <div className="col-md-6">
                                        <div className="text-secondary">
                                            Request Date
                                        </div>

                                        <div className="fw-semibold">
                                            {formatDate(
                                                item.created_at
                                            )}
                                        </div>
                                    </div>

                                    {item.trxid && (
                                        <div className="col-md-6">
                                            <div className="text-secondary">
                                                TRX ID
                                            </div>

                                            <div className="fw-semibold">
                                                {item.trxid}
                                            </div>
                                        </div>
                                    )}

                                    {item.accept_at && (
                                        <div className="col-md-6">
                                            <div className="text-secondary">
                                                Approved Date
                                            </div>

                                            <div className="fw-semibold">
                                                {formatDate(
                                                    item.accept_at
                                                )}
                                            </div>
                                        </div>
                                    )}
                                </div>

                                {/* Actions */}

                                <div className="mt-4 d-flex gap-2 flex-wrap">

                                    {item.withdraw_doc && (
                                        <a
                                            href={`https://globexacapital.com/${item.withdraw_doc}`}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="btn btn-success"
                                        >
                                            <i className="ti ti-file-invoice me-1" />
                                            Withdraw Slip
                                        </a>
                                    )}

                                    {Number(item.status_id) === 1 && (
                                        <button
                                            type="button"
                                            className="btn btn-outline-primary"
                                            onClick={() =>
                                                editWithdraw(item)
                                            }
                                        >
                                            <i className="ti ti-edit me-1" />
                                            Edit
                                        </button>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                );
            })}
        </div>
    );
};

export default WithdrawHistory;