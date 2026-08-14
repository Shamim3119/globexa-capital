import {
    IconCash,
    IconHistory,
} from "@tabler/icons-react";

import { useState } from "react";

import DepositForm from "../../components/deposit/DepositForm";
import DepositHistory from "../../components/deposit/DepositHistory";

export default function Deposit() {

    const [activeTab, setActiveTab] = useState("deposit");

    const handleDepositSuccess = () => {

        setActiveTab("history");

    };


    return (

        <>

            {/* Page Header */}

            <div className="page-header d-print-none">

                <div className="row align-items-center">

                    <div className="col">

                        <div className="d-flex align-items-center gap-2">

                            <span className="text-secondary">
                                Transactions
                            </span>

                            <span className="text-secondary">
                                /
                            </span>

                            <h2 className="page-title mb-0">
                                Deposit
                            </h2>

                        </div>

                    </div>

                </div>

            </div>

            {/* Tabs */}

            <div className="card mb-3">

                <div className="card-body py-2">

                    <div className="nav nav-pills nav-fill">

                        <button
                            type="button"
                            className={`nav-link ${
                                activeTab === "deposit"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={() =>
                                setActiveTab("deposit")
                            }
                        >
                            <IconCash
                                size={20}
                                className="me-2"
                            />
                            Deposit
                        </button>


                        <button
                            type="button"
                            className={`nav-link ${
                                activeTab === "history"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={() =>
                                setActiveTab("history")
                            }
                        >
                            <IconHistory
                                size={20}
                                className="me-2"
                            />  
                            Deposit History
                        </button>

                    </div>

                </div>

            </div>


            {/* Deposit Form */}

            {activeTab === "deposit" && (

                <DepositForm
                    onSuccess={handleDepositSuccess}
                />

            )}


            {/* Deposit History */}

            {activeTab === "history" && (

                <DepositHistory />

            )}

        </>

    );

}