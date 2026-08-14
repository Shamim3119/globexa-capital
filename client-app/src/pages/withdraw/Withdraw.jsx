import {
    IconArrowDownCircle,
    IconHistory,
} from "@tabler/icons-react";

import React, { useState } from "react";

import WithdrawForm from "../../components/withdraw/WithdrawForm";
import WithdrawHistory from "../../components/withdraw/WithdrawHistory";

import { useWithdraw } from "../../context/WithdrawContext";

const Withdraw = () => {

    const [activeTab, setActiveTab] = useState("withdraw");

    const { form, resetForm } = useWithdraw();


    const handleWithdrawTab = () => {

        setActiveTab("withdraw");

    };


    const handleListTab = () => {

        setActiveTab("list");

    };


    const handleNewWithdraw = () => {

        resetForm();

        setActiveTab("withdraw");

    };


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
                                Withdraw
                            </h2>

                        </div>

                    </div>

                </div>

            </div>


            {/* Tabs */}

            <div className="card mb-3">

                <div className="card-body p-2">

                    <div
                        className="nav nav-pills nav-fill"
                        role="tablist"
                    >

                        {/* Withdraw */}

                        <button
                            type="button"
                            className={`nav-link ${
                                activeTab === "withdraw"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={handleWithdrawTab}
                        >

                            <IconArrowDownCircle
                                size={20}
                                className="me-2"
                            />

                            {form.id
                                ? "Edit Withdraw"
                                : "Withdraw"}

                        </button>


                        {/* History */}

                        <button
                            type="button"
                            className={`nav-link ${
                                activeTab === "list"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={handleListTab}
                        >

                            <IconHistory
                                size={20}
                                className="me-2"
                            />

                            Withdraw History

                        </button>

                    </div>

                </div>

            </div>


            {/* Withdraw Form */}

            {activeTab === "withdraw" && (

                <div className="row row-cards">

                    <div className="col-12">

                        <WithdrawForm />

                    </div>

                </div>

            )}


            {/* Withdraw History */}

            {activeTab === "list" && (

                <>

                    <div className="d-flex justify-content-end mb-3">

                        <button
                            type="button"
                            className="btn btn-primary"
                            onClick={handleNewWithdraw}
                        >

                            <i className="ti ti-plus me-2" />

                            New Withdrawal

                        </button>

                    </div>


                    <WithdrawHistory />

                </>

            )}

        </>

    );

};

export default Withdraw;