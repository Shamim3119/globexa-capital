import {
    IconBuildingBank,
    IconEdit,
    IconHash,
    IconCurrencyDollar,
    IconMapPin,
} from "@tabler/icons-react";

import { useAccount } from "../../context/AccountContext";


export default function AccountHistory({ onEdit }) {

    const {
        accounts,
        accountsLoading,
    } = useAccount();


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    if (accountsLoading) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <div
                        className="spinner-border text-primary"
                        role="status"
                    />

                    <div className="text-secondary mt-3">

                        Loading accounts...

                    </div>

                </div>

            </div>

        );

    }


    /*
    |--------------------------------------------------------------------------
    | No Accounts
    |--------------------------------------------------------------------------
    */

    if (!accounts.length) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <IconBuildingBank
                        size={40}
                        className="text-secondary mb-3"
                    />

                    <h3 className="mb-1">

                        No Account Found

                    </h3>

                    <div className="text-secondary">

                        You have not added any payment account yet.

                    </div>

                </div>

            </div>

        );

    }


    /*
    |--------------------------------------------------------------------------
    | Account List
    |--------------------------------------------------------------------------
    */

    return (

        <div className="row row-cards">

            {accounts.map((item) => {

                const isInactive =
                    Number(item.inactive) === 1;


                const operatorName =
                    item.operator?.name || "-";


                const bankType =
                    item.operator?.bank_type?.name || "-";


                const currency =
                    item.operator?.currency?.name || "-";


                const isBranchRequired =
                    Number(item.operator?.type_id) === 7;


                return (

                    <div
                        className="col-12 col-md-6"
                        key={item.id}
                    >

                        <div className="card h-100">

                            <div className="card-body">

                                {/* Header */}

                                <div className="d-flex align-items-center">

                                    <div
                                        className="avatar avatar-md rounded-circle text-white me-3"
                                        style={{
                                            backgroundColor:
                                                "#003366",
                                        }}
                                    >

                                        {operatorName
                                            .charAt(0)
                                            .toUpperCase()
                                        }

                                    </div>


                                    <div className="flex-fill">

                                        <div className="fw-bold text-primary">

                                            {item.account_name}

                                        </div>

                                        <div className="text-secondary small">

                                            {operatorName}

                                        </div>

                                    </div>


                                    {/* Status */}

                                    <span
                                        className={
                                            `badge ${
                                                isInactive
                                                    ? "bg-danger"
                                                    : "bg-success"
                                            }`
                                        }
                                    >

                                        {isInactive
                                            ? "Inactive"
                                            : "Active"
                                        }

                                    </span>

                                </div>


                                <hr />


                                {/* Account Number */}

                                <div className="bg-light rounded p-3 mb-3">

                                    <div className="text-secondary small mb-1">

                                        <IconHash
                                            size={15}
                                            className="me-1"
                                        />

                                        Account Number

                                    </div>

                                    <div className="fw-bold fs-3 text-primary">

                                        {item.account_no}

                                    </div>

                                </div>


                                {/* Details */}

                                <div className="row g-3 mb-3">

                                    {/* Bank Type */}

                                    <div className="col-6">

                                        <div className="text-secondary small">

                                            <IconBuildingBank
                                                size={15}
                                                className="me-1"
                                            />

                                            Bank Type

                                        </div>

                                        <div className="fw-bold mt-1">

                                            {bankType}

                                        </div>

                                    </div>


                                    {/* Currency */}

                                    <div className="col-6">

                                        <div className="text-secondary small">

                                            <IconCurrencyDollar
                                                size={15}
                                                className="me-1"
                                            />

                                            Currency

                                        </div>

                                        <div className="fw-bold mt-1">

                                            {currency}

                                        </div>

                                    </div>

                                </div>


                                {/* Branch */}

                                {isBranchRequired && item.branch && (

                                    <div className="bg-light rounded p-3 mb-3">

                                        <div className="text-secondary small mb-1">

                                            <IconMapPin
                                                size={15}
                                                className="me-1"
                                            />

                                            Branch

                                        </div>

                                        <div className="fw-bold">

                                            {item.branch}

                                        </div>

                                    </div>

                                )}


                                {/* Edit */}

                                <button
                                    type="button"
                                    className="btn btn-primary w-100"
                                    onClick={() =>
                                        onEdit(item)
                                    }
                                >

                                    <IconEdit
                                        size={18}
                                        className="me-2"
                                    />

                                    Edit Account

                                </button>

                            </div>

                        </div>

                    </div>

                );

            })}

        </div>

    );

}