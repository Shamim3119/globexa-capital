import {
    IconWallet,
    IconUser,
    IconHash,
    IconBuildingBank,
    IconCurrencyDollar,
    IconCheck,
    IconX,
} from "@tabler/icons-react";

import { useAccount } from "../../context/AccountContext";
import { useToast } from "../../context/ToastContext";


export default function AccountForm() {

    const { showToast } = useToast();

    const {
        id,

        accountName,
        setAccountName,

        accountNo,
        setAccountNo,

        operatorId,
        setOperatorId,

        inactive,
        setInactive,

        operators,
        selectedOperator,

        loading,
        operatorsLoading,

        saveAccount,
        resetForm,
    } = useAccount();


    const handleSubmit = async (e) => {

        e.preventDefault();

        const result = await saveAccount();

        if (result?.success) {

            showToast(
                result.message ||
                "Account saved successfully.",
                "success"
            );

            /*
             * Account.jsx will switch to Account List
             * after successful save.
             */

        } else {

            showToast(
                result?.message ||
                "Failed to save account.",
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

                        <IconWallet
                            size={34}
                            className="text-primary mb-2"
                        />

                        <h2 className="mb-1">

                            {id
                                ? "Update Account"
                                : "Add New Account"
                            }

                        </h2>

                        <div className="text-secondary">

                            {id
                                ? "Update your payment account information"
                                : "Add a payment account to your profile"
                            }

                        </div>

                    </div>


                    {/* Inactive */}

                    <div className="mb-4">

                        <label className="form-check">

                            <input
                                type="checkbox"
                                className="form-check-input"
                                checked={inactive}
                                onChange={(e) =>
                                    setInactive(
                                        e.target.checked
                                    )
                                }
                            />

                            <span className="form-check-label text-danger fw-bold">

                                Inactive Account

                            </span>

                        </label>

                    </div>


                    {/* Payment Operator */}

                    <div className="mb-3">

                        <label className="form-label">

                            <IconBuildingBank
                                size={18}
                                className="me-1"
                            />

                            Payment Operator

                        </label>


                        <select
                            className="form-select"
                            value={operatorId}
                            onChange={(e) =>
                                setOperatorId(
                                    e.target.value
                                )
                            }
                            disabled={
                                operatorsLoading ||
                                loading
                            }
                        >

                            <option value="">

                                Select Payment Operator

                            </option>


                            {operators.map((operator) => (

                                <option
                                    key={operator.id}
                                    value={String(operator.id)}
                                >

                                    {operator.name}

                                    {operator.currency?.name
                                        ? ` - ${operator.currency.name}`
                                        : ""
                                    }

                                </option>

                            ))}

                        </select>

                    </div>


                    {/* Operator Information */}

                    {selectedOperator && (

                        <div className="card bg-light mb-4">

                            <div className="card-body">

                                <div className="row">

                                    {/* Bank Type */}

                                    <div className="col-md-6 mb-2">

                                        <div className="text-secondary small">

                                            Bank Type

                                        </div>

                                        <div className="fw-bold">

                                            <IconBuildingBank
                                                size={16}
                                                className="me-1"
                                            />

                                            {selectedOperator
                                                ?.bank_type
                                                ?.name || "-"
                                            }

                                        </div>

                                    </div>


                                    {/* Currency */}

                                    <div className="col-md-6 mb-2">

                                        <div className="text-secondary small">

                                            Currency

                                        </div>

                                        <div className="fw-bold">

                                            <IconCurrencyDollar
                                                size={16}
                                                className="me-1"
                                            />

                                            {selectedOperator
                                                ?.currency
                                                ?.name || "-"
                                            }

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    )}


                    {/* Account Name */}

                    <div className="mb-4">

                        <label className="form-label">

                            <IconUser
                                size={18}
                                className="me-1"
                            />

                            Account Name

                        </label>


                        <input
                            type="text"
                            className="form-control"
                            placeholder="Enter account holder name"
                            value={accountName}
                            onChange={(e) =>
                                setAccountName(
                                    e.target.value
                                )
                            }
                            disabled={loading}
                        />

                    </div>


                    {/* Account Number */}

                    <div className="mb-4">

                        <label className="form-label">

                            <IconHash
                                size={18}
                                className="me-1"
                            />

                            Account Number

                        </label>


                        <input
                            type="text"
                            className="form-control"
                            placeholder="Enter account number"
                            value={accountNo}
                            onChange={(e) =>
                                setAccountNo(
                                    e.target.value
                                )
                            }
                            disabled={loading}
                        />

                    </div>


                    {/* Buttons */}

                    <div className="d-flex gap-2">

                        <button
                            type="submit"
                            className="btn btn-primary flex-fill"
                            disabled={loading}
                        >

                            <IconCheck
                                size={19}
                                className="me-1"
                            />

                            {loading
                                ? "Saving..."
                                : id
                                    ? "Update Account"
                                    : "Save Account"
                            }

                        </button>


                        {id && (

                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={resetForm}
                                disabled={loading}
                            >

                                <IconX
                                    size={19}
                                    className="me-1"
                                />

                                Cancel Edit

                            </button>

                        )}

                    </div>

                </div>

            </div>

        </form>

    );

}