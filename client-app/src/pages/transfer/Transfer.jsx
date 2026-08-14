import {
    IconArrowsExchange,
    IconHistory,
} from "@tabler/icons-react";

import { useState } from "react";

import TransferForm from "../../components/transfer/TransferForm";
import TransferHistory from "../../components/transfer/TransferHistory";
import { useTransfer } from "../../context/TransferContext";

export default function Transfer() {

    const [activeTab, setActiveTab] = useState("transfer");

    const {
        step,
        setStep,
        loadTransfers,
    } = useTransfer();


    const handleTabChange = async (tab) => {

        setActiveTab(tab);

        if (tab === "history") {
            await loadTransfers();
        }

    };


    /*
     * TransferForm changes step to 2 when
     * "Next" is clicked.
     *
     * After successful confirmation the context
     * resets step to 1.
     *
     * We watch that change and switch to history.
     */

    const handleTransferSuccess = () => {

        setActiveTab("history");

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
                                Transfer
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
                            className={
                                `nav-link ${
                                    activeTab === "transfer"
                                        ? "active"
                                        : ""
                                }`
                            }
                            onClick={() =>
                                handleTabChange("transfer")
                            }
                        >

                            <IconArrowsExchange
                                size={20}
                                className="me-2"
                            />

                            Transfer

                        </button>


                        <button
                            type="button"
                            className={
                                `nav-link ${
                                    activeTab === "history"
                                        ? "active"
                                        : ""
                                }`
                            }
                            onClick={() =>
                                handleTabChange("history")
                            }
                        >

                            <IconHistory
                                size={20}
                                className="me-2"
                            />

                            Transfer History

                        </button>

                    </div>

                </div>

            </div>


            {/* Content */}

            {activeTab === "transfer" && (

                <TransferForm
                    onSuccess={handleTransferSuccess}
                />

            )}


            {activeTab === "history" && (

                <TransferHistory />

            )}

        </>

    );

}