import {
    IconRefresh,
    IconArrowLeft,
    IconCash,
    IconPercentage,
} from "@tabler/icons-react";

import { useRefund } from "../../context/RefundContext";
import { useToast } from "../../context/ToastContext";

export default function RefundDetails() {

    const {
        refundData,
        submitRefund,
        setRefundData,
        loading,
    } = useRefund();

    const { showToast } = useToast();


    if (!refundData) {
        return null;
    }


    const handleSubmit = async () => {

        const result = await submitRefund();

        if (result?.success) {

            showToast(
                result.message ||
                "Refund submitted successfully.",
                "success"
            );

        } else {

            showToast(
                result?.message ||
                "Failed to submit refund.",
                "danger"
            );

        }

    };


    const investment =
        refundData.investment || {};

    const charge =
        refundData.charge || {};

    const refund =
        refundData.refund || {};


    return (

        <div className="card">

            <div className="card-body">

                <div className="text-center mb-4">

                    <IconRefresh
                        size={36}
                        className="text-primary mb-2"
                    />

                    <h2 className="mb-1">
                        Refund Details
                    </h2>

                    <div className="text-secondary">
                        Review your refund information
                    </div>

                </div>


                {/* Investment */}

                <div className="card bg-light mb-3">

                    <div className="card-body">

                        <h3 className="card-title">
                            Investment Information
                        </h3>


                        <div className="d-flex justify-content-between py-2 border-bottom">

                            <span className="text-secondary">
                                <IconCash
                                    size={16}
                                    className="me-1"
                                />

                                Investment Amount
                            </span>

                            <strong>
                                {Number(
                                    investment.amount || 0
                                ).toFixed(2)} $
                            </strong>

                        </div>


                        <div className="d-flex justify-content-between py-2 border-bottom">

                            <span className="text-secondary">
                                Days Passed
                            </span>

                            <strong>
                                {Math.floor(
                                    Number(
                                        refundData.days_passed || 0
                                    )
                                )}
                            </strong>

                        </div>

                    </div>

                </div>


                {/* Charge */}

                <div className="card bg-light mb-3">

                    <div className="card-body">

                        <h3 className="card-title">
                            Refund Calculation
                        </h3>


                        <div className="d-flex justify-content-between py-2 border-bottom">

                            <span className="text-secondary">
                                <IconPercentage
                                    size={16}
                                    className="me-1"
                                />

                                Charge
                            </span>

                            <strong>
                                {charge.percentage || 0}%
                            </strong>

                        </div>


                        <div className="d-flex justify-content-between py-2 border-bottom">

                            <span className="text-secondary">
                                Charge Amount
                            </span>

                            <strong>
                                {Number(
                                    charge.amount || 0
                                ).toFixed(2)} $
                            </strong>

                        </div>


                        <div className="d-flex justify-content-between py-3">

                            <span className="fw-bold">
                                Payable Refund
                            </span>

                            <strong className="text-success fs-3">

                                {Number(
                                    refund.amount || 0
                                ).toFixed(2)} $

                            </strong>

                        </div>

                    </div>

                </div>


                {/* Actions */}

                <button
                    type="button"
                    className="btn btn-primary w-100"
                    onClick={handleSubmit}
                    disabled={loading}
                >

                    <IconRefresh
                        size={20}
                        className="me-2"
                    />

                    {loading
                        ? "Submitting..."
                        : "Submit Refund"
                    }

                </button>


                <button
                    type="button"
                    className="btn btn-secondary w-100 mt-2"
                    onClick={() => setRefundData(null)}
                    disabled={loading}
                >

                    <IconArrowLeft
                        size={20}
                        className="me-2"
                    />

                    Back

                </button>

            </div>

        </div>

    );

}