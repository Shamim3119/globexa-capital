import {
    IconArrowsExchange,
    IconUser,
    IconCash,
    IconCheck,
    IconArrowLeft,
} from "@tabler/icons-react";

import { useToast } from "../../context/ToastContext";
import { useP2P } from "../../context/P2PContext";
import { useAuth } from "../../context/AuthContext";

export default function P2PForm() {

    const { showToast } = useToast();

    const { user } = useAuth();

    const {
        toId,
        setToId,

        amount,
        setAmount,

        step,
        receiver,

        loading,

        verifyReceiver,
        confirmTransfer,
        backToForm,
        resetForm,
    } = useP2P();


    /*
    |--------------------------------------------------------------------------
    | Verify Receiver
    |--------------------------------------------------------------------------
    */

    const handleNext = async (e) => {

        e.preventDefault();

        const result = await verifyReceiver();

        if (!result?.success) {

            showToast(
                result?.message || "Unable to verify receiver.",
                "danger"
            );

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Confirm Transfer
    |--------------------------------------------------------------------------
    */

    const handleConfirm = async () => {

        const result = await confirmTransfer();

        if (result?.success) {

            showToast(
                result.message ||
                    "Transfer completed successfully.",
                "success"
            );

            /*
             * P2P.jsx will switch to the list tab.
             * We dispatch an event so the parent page can
             * detect successful transfer.
             */

            window.dispatchEvent(
                new CustomEvent("p2p-transfer-success")
            );

        } else {

            showToast(
                result?.message ||
                    "Transfer failed.",
                "danger"
            );

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Cancel
    |--------------------------------------------------------------------------
    */

    const handleCancel = () => {

        resetForm();

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
                        P2P Transfer
                    </h2>

                    <div className="text-secondary">
                        Enter the receiver's ID and transfer amount.
                    </div>

                </div>


                {/* ======================================================
                    STEP 1
                ====================================================== */}

                {step === 1 && (

                    <form onSubmit={handleNext}>

                        {/* Receiver ID */}

                        <div className="mb-4">

                            <label className="form-label">

                                <IconUser
                                    size={18}
                                    className="me-1"
                                />

                                Receiver ID

                            </label>


                            <input
                                type="number"
                                className="form-control form-control-lg"
                                placeholder="Enter Receiver ID"
                                value={toId}
                                onChange={(e) =>
                                    setToId(e.target.value)
                                }
                                disabled={loading}
                            />

                        </div>


                        {/* Deposit Balance */}

                        <div className="alert alert-success mb-4">

                            <div className="d-flex justify-content-between align-items-center">

                                <span>
                                    <IconCash
                                        size={18}
                                        className="me-1"
                                    />

                                    Deposit Balance
                                </span>

                                <strong>

                                    {Number(
                                        user?.deposit_balance ?? 0
                                    ).toFixed(2)}

                                    {" $"}

                                </strong>

                            </div>

                        </div>


                        {/* Amount */}

                        <div className="mb-4">

                            <label className="form-label">

                                <IconCash
                                    size={18}
                                    className="me-1"
                                />

                                Amount

                            </label>


                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                className="form-control form-control-lg"
                                placeholder="Enter Amount"
                                value={amount}
                                onChange={(e) =>
                                    setAmount(e.target.value)
                                }
                                disabled={loading}
                            />

                        </div>


                        {/* Next */}

                        <button
                            type="submit"
                            className="btn btn-primary w-100"
                            disabled={loading}
                        >

                            <IconArrowsExchange
                                size={20}
                                className="me-2"
                            />

                            {loading
                                ? "Verifying..."
                                : "Next"
                            }

                        </button>


                        {/* Cancel */}

                        {(toId || amount) && (

                            <button
                                type="button"
                                className="btn btn-secondary w-100 mt-2"
                                onClick={handleCancel}
                                disabled={loading}
                            >

                                Cancel

                            </button>

                        )}

                    </form>

                )}


                {/* ======================================================
                    STEP 2
                ====================================================== */}

                {step === 2 && receiver && (

                    <div>

                        {/* Confirmation Card */}

                        <div
                            className="card mb-4"
                            style={{
                                backgroundColor: "#f4f8ff",
                                borderColor: "#d5e2f5",
                            }}
                        >

                            <div className="card-body">

                                <div className="d-flex align-items-center mb-3">

                                    <IconCheck
                                        size={24}
                                        className="text-primary me-2"
                                    />

                                    <h3 className="card-title mb-0">
                                        Confirm Transfer
                                    </h3>

                                </div>


                                {/* Receiver ID */}

                                <div className="row mb-3">

                                    <div className="col-6 text-secondary">
                                        Receiver ID
                                    </div>

                                    <div className="col-6 text-end fw-bold">
                                        {receiver.id}
                                    </div>

                                </div>


                                {/* Name */}

                                <div className="row mb-3">

                                    <div className="col-6 text-secondary">
                                        Name
                                    </div>

                                    <div className="col-6 text-end fw-bold">
                                        {receiver.name || "-"}
                                    </div>

                                </div>


                                {/* Mobile */}

                                <div className="row mb-3">

                                    <div className="col-6 text-secondary">
                                        Mobile
                                    </div>

                                    <div className="col-6 text-end fw-bold">
                                        {receiver.phone || "-"}
                                    </div>

                                </div>


                                {/* Amount */}

                                <div className="row">

                                    <div className="col-6 text-secondary">
                                        Amount
                                    </div>

                                    <div className="col-6 text-end fw-bold text-success">

                                        {Number(amount).toFixed(2)}
                                        {" $"}

                                    </div>

                                </div>

                            </div>

                        </div>


                        {/* Confirm */}

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
                                : "Confirm"
                            }

                        </button>


                        {/* Back */}

                        <button
                            type="button"
                            className="btn btn-secondary w-100 mt-2"
                            onClick={backToForm}
                            disabled={loading}
                        >

                            <IconArrowLeft
                                size={20}
                                className="me-2"
                            />

                            Back

                        </button>

                    </div>

                )}

            </div>

        </div>

    );

}