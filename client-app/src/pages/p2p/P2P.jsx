import { useEffect, useState } from "react";

import {
    IconArrowsExchange,
    IconList,
} from "@tabler/icons-react";

import P2PForm from "../../components/p2p/P2PForm";
import P2PHistory from "../../components/p2p/P2PHistory";

export default function P2P() {

    const [activeTab, setActiveTab] = useState("p2p");

    /*
    |--------------------------------------------------------------------------
    | Automatically switch to P2P List after successful transfer
    |--------------------------------------------------------------------------
    */

    useEffect(() => {

        const handleTransferSuccess = () => {

            setActiveTab("list");

        };

        window.addEventListener(
            "p2p-transfer-success",
            handleTransferSuccess
        );

        return () => {

            window.removeEventListener(
                "p2p-transfer-success",
                handleTransferSuccess
            );

        };

    }, []);


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
                                P2P
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

                        {/* P2P */}

                        <button
                            type="button"
                            className={`nav-link ${
                                activeTab === "p2p"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={() =>
                                setActiveTab("p2p")
                            }
                        >

                            <IconArrowsExchange
                                size={20}
                                className="me-2"
                            />

                            P2P

                        </button>


                        {/* P2P List */}

                        <button
                            type="button"
                            className={`nav-link ${
                                activeTab === "list"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={() =>
                                setActiveTab("list")
                            }
                        >

                            <IconList
                                size={20}
                                className="me-2"
                            />

                            P2P List

                        </button>

                    </div>

                </div>

            </div>


            {/* Content */}

            <div className="row row-cards">

                <div className="col-12">

                    {activeTab === "p2p" && (
                        <P2PForm />
                    )}

                    {activeTab === "list" && (
                        <P2PHistory />
                    )}

                </div>

            </div>

        </>

    );

}