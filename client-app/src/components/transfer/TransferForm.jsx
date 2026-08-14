import {
    IconArrowsExchange,
    IconWallet,
    IconCash,
    IconArrowRight,
    IconCheck,
    IconX,
} from "@tabler/icons-react";

import { useTransfer } from "../../context/TransferContext";
import { useToast } from "../../context/ToastContext";

export default function TransferForm({ onSuccess }) {

    const { showToast } = useToast();

    const {
        amount,
        setAmount,

        step,

        loading,

        incomeBalance,
        depositBalance,

        transferAmount,
        afterIncomeBalance,
        afterDepositBalance,

        verifyTransfer,
        confirmTransfer,

        resetForm,
    } = useTransfer();


    const handleNext = () => {

        const result = verifyTransfer();

        if (!result?.success) {

            showToast(
                result?.message || "Unable to continue.",
                "danger"
            );

        }

    };


    const handleConfirm = async () => {

        const result = await confirmTransfer();

        if (result?.success) {

            showToast(
                result.message ||
                "Transfer completed successfully.",
                "success"
            );

            onSuccess?.();

        } else {

            showToast(
                result?.message ||
                "Transfer failed.",
                "danger"
            );

        }

    };


    return (

        <div className="card">

            <div className="card-body">

                {/* Header */}

                <div className="text-center mb-4">

                    <IconArrowsExchange
                        size={36}
                        className="text-primary mb-2"
                    />

                    <h2 className="mb-1">
                        Transfer Funds
                    </h2>

                    <div className="text-secondary">
                        Transfer funds from your income balance
                        to your deposit balance
                    </div>

                </div>


                {/* Balance Cards */}

                <div className="row g-3 mb-4">

                    <div className="col-md-6">

                        <div className="card bg-primary-lt h-100">

                            <div className="card-body">

                                <div className="d-flex align-items-center">

                                    <div className="me-3">

                                        <IconWallet
                                            size={28}
                                            className="text-primary"
                                        />

                                    </div>

                                    <div>

                                        <div className="text-secondary">
                                            Income Balance
                                        </div>

                                        <div className="h2 mb-0">
                                            $
                                            {incomeBalance.toFixed(2)}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div className="col-md-6">

                        <div className="card bg-success-lt h-100">

                            <div className="card-body">

                                <div className="d-flex align-items-center">

                                    <div className="me-3">

                                        <IconCash
                                            size={28}
                                            className="text-success"
                                        />

                                    </div>

                                    <div>

                                        <div className="text-secondary">
                                            Deposit Balance
                                        </div>

                                        <div className="h2 mb-0">
                                            $
                                            {depositBalance.toFixed(2)}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {/* STEP 1 */}

                {step === 1 && (

                    <>

                        <div className="mb-4">

                            <label className="form-label">

                                Transfer Amount

                            </label>

                            <div className="input-group input-group-lg">

                                <span className="input-group-text">
                                    $
                                </span>

                                <input
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    className="form-control"
                                    placeholder="0.00"
                                    value={amount}
                                    onChange={(e) =>
                                        setAmount(e.target.value)
                                    }
                                />

                            </div>

                            <div className="form-hint">
                                Available income balance: $
                                {incomeBalance.toFixed(2)}
                            </div>

                        </div>


                        <button
                            type="button"
                            className="btn btn-primary w-100"
                            onClick={handleNext}
                            disabled={loading}
                        >

                            <IconArrowRight
                                size={20}
                                className="me-2"
                            />

                            Next

                        </button>

                    </>

                )}


                {/* STEP 2 */}

                {step === 2 && (

                    <>

                        <div className="alert alert-info">

                            <div className="d-flex">

                                <IconArrowsExchange
                                    size={22}
                                    className="me-2"
                                />

                                <div>

                                    <h3 className="alert-title">
                                        Confirm Transfer
                                    </h3>

                                    <div>
                                        Please review the transfer
                                        information before confirming.
                                    </div>

                                </div>

                            </div>

                        </div>


                        <div className="card bg-light mb-4">

                            <div className="card-body">

                                <div className="row">

                                    <div className="col-md-6 mb-3">

                                        <div className="text-secondary">
                                            Transfer Amount
                                        </div>

                                        <div className="h2 mb-0">
                                            $
                                            {transferAmount.toFixed(2)}
                                        </div>

                                    </div>


                                    <div className="col-md-6 mb-3">

                                        <div className="text-secondary">
                                            Current Income Balance
                                        </div>

                                        <div className="fw-bold">
                                            $
                                            {incomeBalance.toFixed(2)}
                                        </div>

                                    </div>


                                    <div className="col-md-6 mb-3">

                                        <div className="text-secondary">
                                            Current Deposit Balance
                                        </div>

                                        <div className="fw-bold">
                                            $
                                            {depositBalance.toFixed(2)}
                                        </div>

                                    </div>


                                    <div className="col-md-6 mb-3">

                                        <div className="text-secondary">
                                            After Transfer Income
                                        </div>

                                        <div className="fw-bold text-danger">
                                            $
                                            {afterIncomeBalance.toFixed(2)}
                                        </div>

                                    </div>


                                    <div className="col-md-6">

                                        <div className="text-secondary">
                                            After Transfer Deposit
                                        </div>

                                        <div className="fw-bold text-success">
                                            $
                                            {afterDepositBalance.toFixed(2)}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div className="row g-2">

                            <div className="col-md-6">

                                <button
                                    type="button"
                                    className="btn btn-outline-secondary w-100"
                                    onClick={resetForm}
                                    disabled={loading}
                                >

                                    <IconX
                                        size={20}
                                        className="me-2"
                                    />

                                    Cancel

                                </button>

                            </div>


                            <div className="col-md-6">

                                <button
                                    type="button"
                                    className="btn btn-primary w-100"
                                    onClick={handleConfirm}
                                    disabled={loading}
                                >

                                    <IconCheck
                                        size={20}
                                        className="me-2"
                                    />

                                    {loading
                                        ? "Processing..."
                                        : "Confirm Transfer"
                                    }

                                </button>

                            </div>

                        </div>

                    </>

                )}

            </div>

        </div>

    );

}