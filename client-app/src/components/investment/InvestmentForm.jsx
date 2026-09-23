import {
    IconChartLine,
    IconCash,
    IconPercentage,
    IconCheck,
} from "@tabler/icons-react";

import { useToast } from "../../context/ToastContext";
import { useInvestment } from "../../context/InvestmentContext";

export default function InvestmentForm({ onSuccess }) {

    const { showToast } = useToast();

    const {
        plans,
        investmentId,
        setInvestmentId,

        amount,
        setAmount,

        depositBalance,
        selectedPlan,
        commission,

        loading,
        plansLoading,

        saveInvestment,
    } = useInvestment();


    const handleSubmit = async (e) => {

        e.preventDefault();

        const result = await saveInvestment();

        if (result?.success) {

            showToast(
                result.message || "Investment created successfully.",
                "success"
            );

            /*
             * Switch to Investment History
             * after successful submission.
             */
            if (onSuccess) {
                onSuccess();
            }

        } else {

            showToast(
                result?.message || "Failed to create investment.",
                "danger"
            );

        }

    };


    return (

        <form onSubmit={handleSubmit}>

            <div className="card">

                <div className="card-body">

                    {/* Header */}

                    <div className="text-center mb-4">

                        <IconChartLine
                            size={32}
                            className="text-primary mb-2"
                        />

                        <h2 className="mb-1">
                            Create Investment
                        </h2>

                        <div className="text-secondary">
                            Invest using your deposit balance
                        </div>

                    </div>


                    {/* Deposit Balance */}

                    <div className="alert alert-primary mb-4">

                        <div className="d-flex justify-content-between align-items-center">

                            <span>

                                <IconCash
                                    size={18}
                                    className="me-1"
                                />

                                Deposit Balance

                            </span>

                            <strong>

                                $ {Number(depositBalance || 0).toFixed(2)}

                            </strong>

                        </div>

                    </div>


                    {/* Investment Plan */}

                    <div className="mb-4">

                        <label className="form-label">

                            <IconChartLine
                                size={18}
                                className="me-1"
                            />

                            Investment Plan

                        </label>


                        <select
                            className="form-select"
                            value={investmentId}
                            onChange={(e) =>
                                setInvestmentId(e.target.value)
                            }
                            disabled={plansLoading}
                        >

                            {plans.length === 0 && (

                                <option value="">
                                    No investment plans available
                                </option>

                            )}


                            {plans.map((plan) => (

                                <option
                                    key={plan.id}
                                    value={plan.id}
                                >

                                    {plan.day} Days
                                    {" - "}
                                    {plan.deposite_commission}%

                                </option>

                            ))}

                        </select>

                    </div>


                    {/* Selected Plan */}

                    {selectedPlan && (

                        <div className="card bg-light mb-4">

                            <div className="card-body">

                                <h3 className="card-title">
                                    Selected Plan
                                </h3>


                                <div className="row">

                                    <div className="col-md-6 mb-3">

                                        <div className="text-secondary">
                                            Duration
                                        </div>

                                        <div className="fw-bold">
                                            {selectedPlan.day} Days
                                        </div>

                                    </div>


                                    <div className="col-md-6 mb-3">

                                        <div className="text-secondary">

                                            <IconPercentage
                                                size={16}
                                                className="me-1"
                                            />

                                            Commission

                                        </div>

                                        <div className="fw-bold">
                                            {selectedPlan.deposite_commission}%
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    )}


                    {/* Amount */}

                    <div className="mb-4">

                        <label className="form-label">

                            <IconCash
                                size={18}
                                className="me-1"
                            />

                            Investment Amount

                        </label>


                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            className="form-control form-control-lg"
                            placeholder="0.00"
                            value={amount}
                            onChange={(e) =>
                                setAmount(e.target.value)
                            }
                        />

                    </div>


                    {/* Commission */}

                    {amount && selectedPlan && (

                        <div className="alert alert-success mb-4">

                            <div className="d-flex justify-content-between">

                                <span>
                                    Expected Commission
                                </span>

                                <strong>
                                    $ {Number(commission || 0).toFixed(2)}
                                </strong>

                            </div>

                        </div>

                    )}


                    {/* Submit */}

                    <button
                        type="submit"
                        className="btn btn-primary w-100"
                        disabled={
                            loading ||
                            plansLoading ||
                            !investmentId
                        }
                    >

                        <IconCheck
                            size={20}
                            className="me-2"
                        />

                        {loading
                            ? "Processing..."
                            : "Create Investment"
                        }

                    </button>

                </div>

            </div>

        </form>

    );

}