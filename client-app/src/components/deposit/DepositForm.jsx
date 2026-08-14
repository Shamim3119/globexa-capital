import {
    IconWallet,
    IconCash,
    IconReceipt,
    IconUpload,
    IconCheck,
    IconCopy,
    IconQrcode,
} from "@tabler/icons-react";
import { useToast } from "../../context/ToastContext";
import { useDeposit } from "../../context/DepositContext";

export default function DepositForm({ onSuccess }) {

    const { showToast } = useToast();

    const {
        businessAccounts,
        accountId,
        setAccountId,
        selectedAccount,

        amount,
        setAmount,

        trxid,
        setTrxid,

        image,
        setImage,

        convertedAmount,

        loading,
        accountsLoading,

        saveDeposit,
    } = useDeposit();


    const handleCopy = async () => {

        if (!selectedAccount?.account_no) {
            return;
        }

        try {

            await navigator.clipboard.writeText(
                selectedAccount.account_no
            );

            showToast("Account number copied.", "success");

        } catch (error) {

            showToast("Unable to copy account number.","danger");

        }

    };


    const handleSubmit = async (e) => {

        e.preventDefault();

        const result = await saveDeposit();

        if (result?.success) {
            showToast(
                result.message || "Deposit submitted successfully.",
                "success"
            );
            if (onSuccess) {
                onSuccess();
            }
        } else {
            showToast(
                result?.message || "Failed to submit deposit.",
                "danger"
            );
        }
    };


    return (

        <form onSubmit={handleSubmit}>

            <div className="card">

                <div className="card-body">

                    <div className="text-center mb-4">

                        <IconCash
                            size={32}
                            className="text-primary mb-2"
                        />

                        <h2 className="mb-1">
                            Submit Deposit
                        </h2>

                        <div className="text-secondary">
                            Submit your deposit information
                        </div>

                    </div>


                    {/* Payment Account */}

                    <div className="mb-4">

                        <label className="form-label">

                            <IconWallet
                                size={18}
                                className="me-1"
                            />

                            Payment Account

                        </label>


                        <select
                            className="form-select"
                            value={accountId}
                            onChange={(e) =>
                                setAccountId(e.target.value)
                            }
                            disabled={accountsLoading}
                        >

                            {businessAccounts.map((account) => (

                                <option
                                    key={account.id}
                                    value={account.id}
                                >

                                    {account.operator}
                                    {" - "}
                                    {account.account_no}

                                </option>

                            ))}

                        </select>

                    </div>


                    {/* Account Information */}

                    {selectedAccount && (

                        <div className="card bg-light mb-4">

                            <div className="card-body">

                                <h3 className="card-title">

                                    Payment Account

                                </h3>


                                <div className="row">

                                    <div className="col-md-6 mb-2">

                                        <span className="text-secondary">
                                            Operator
                                        </span>

                                        <div className="fw-bold">
                                            {selectedAccount.operator}
                                        </div>

                                    </div>


                                    <div className="col-md-6 mb-2">

                                        <span className="text-secondary">
                                            Account Name
                                        </span>

                                        <div className="fw-bold">
                                            {selectedAccount.account_name}
                                        </div>

                                    </div>


                                    <div className="col-md-6 mb-2">

                                        <span className="text-secondary">
                                            Currency
                                        </span>

                                        <div className="fw-bold">
                                            {selectedAccount.currency}
                                        </div>

                                    </div>


                                    <div className="col-md-6 mb-2">

                                        <span className="text-secondary">
                                            Account Number
                                        </span>

                                        <div className="input-group">

                                            <input
                                                type="text"
                                                className="form-control"
                                                value={
                                                    selectedAccount.account_no || ""
                                                }
                                                readOnly
                                            />

                                            <button
                                                type="button"
                                                className="btn btn-outline-primary"
                                                onClick={handleCopy}
                                            >

                                                <IconCopy size={18}/>

                                            </button>

                                        </div>

                                    </div>

                                </div>


                                {/* QR */}

                                {selectedAccount.qr_code && (

                                    <div className="text-center mt-3">

                                        <img
                                            src={`https://globexacapital.com/storage/qr_code/${selectedAccount.qr_code}`}
                                            alt="Payment QR"
                                            className="img-fluid rounded"
                                            style={{
                                                width: "180px",
                                                height: "180px",
                                                objectFit: "contain",
                                            }}
                                        />

                                        <div className="small text-secondary mt-2">

                                            <IconQrcode
                                                size={16}
                                                className="me-1"
                                            />

                                            Payment QR Code

                                        </div>

                                    </div>

                                )}

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

                            Deposit Amount

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


                        {convertedAmount && (

                            <div className="alert alert-success mt-2 mb-0">

                                <div className="d-flex justify-content-between">

                                    <span>
                                        Converted Amount
                                    </span>

                                    <strong>
                                        {convertedAmount}
                                        {" "}
                                        {selectedAccount?.currency}
                                    </strong>

                                </div>

                            </div>

                        )}

                    </div>


                    {/* Transaction */}

                    <div className="mb-4">

                        <label className="form-label">

                            <IconReceipt
                                size={18}
                                className="me-1"
                            />

                            Transaction Information

                        </label>


                        <input
                            type="text"
                            className="form-control"
                            placeholder="Transaction ID"
                            value={trxid}
                            onChange={(e) =>
                                setTrxid(e.target.value)
                            }
                        />

                        <div className="form-hint">
                            Transaction ID or deposit document is required.
                        </div>

                    </div>


                    {/* Deposit Document */}

                    <div className="mb-4">

                        <label className="form-label">

                            <IconUpload
                                size={18}
                                className="me-1"
                            />

                            Deposit Slip

                        </label>


                        <input
                            type="file"
                            className="form-control"
                            accept="image/*"
                            onChange={(e) => {

                                const file =
                                    e.target.files?.[0] || null;

                                setImage(file);

                            }}
                        />


                        {image && (

                            <div className="mt-3">

                                <img
                                    src={URL.createObjectURL(image)}
                                    alt="Deposit preview"
                                    className="img-thumbnail"
                                    style={{
                                        maxWidth: "180px",
                                        maxHeight: "180px",
                                    }}
                                />

                            </div>

                        )}

                    </div>


                    {/* Submit */}

                    <button
                        type="submit"
                        className="btn btn-primary w-100"
                        disabled={loading}
                    >

                        <IconCheck
                            size={20}
                            className="me-2"
                        />

                        {loading
                            ? "Submitting..."
                            : "Submit Deposit"
                        }

                    </button>

                </div>

            </div>

        </form>

    );

}