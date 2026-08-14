import {
    IconChartLine,
    IconHistory,
} from "@tabler/icons-react";

import { useState } from "react";

import InvestmentForm from "../../components/investment/InvestmentForm";
import InvestmentHistory from "../../components/investment/InvestmentHistory";

export default function Investment() {

    const [activeTab, setActiveTab] = useState("investment");


    return (

        <>


            {/* Page Header */}

            <div className="page-header d-print-none">

                <div className="row align-items-center">

                    <div className="col">

                        <div className="d-flex align-items-center">

                            <span
                                className="badge bg-primary-lt text-primary me-2"
                            >
                                Transactions
                            </span>

                            <span className="text-secondary me-2">
                                /
                            </span>

                            <h2 className="page-title mb-0">
                                Investment
                            </h2>

                        </div>

                    </div>

                </div>

            </div>

            {/* Tabs */}

            <div className="card mb-3">

                <div className="card-body p-2">

                    <div className="nav nav-pills nav-fill">

                        <button
                            type="button"
                            className={`nav-link ${
                                activeTab === "investment"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={() =>
                                setActiveTab("investment")
                            }
                        >
                            <IconChartLine
                                size={20}
                                className="me-2"
                            />
                            Investment
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

                            Investment History
                        </button>

                    </div>

                </div>

            </div>


            {/* Form */}

            {activeTab === "investment" && (

                <InvestmentForm
                    onSuccess={() =>
                        setActiveTab("history")
                    }
                />

            )}


            {/* History */}

            {activeTab === "history" && (

                <InvestmentHistory/>

            )}

        </>

    );

}