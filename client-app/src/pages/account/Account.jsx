import { useState } from "react";

import {
    IconWallet,
    IconList,
    IconPlus,
} from "@tabler/icons-react";

import AccountForm from "../../components/account/AccountForm";
import AccountHistory from "../../components/account/AccountHistory";

import { useAccount } from "../../context/AccountContext";


export default function Account() {

    const [activeTab, setActiveTab] =
        useState("account");


    const {
        id,
        editAccount,
        resetForm,
    } = useAccount();

 


    /*
    |--------------------------------------------------------------------------
    | Edit Account
    |--------------------------------------------------------------------------
    */

    const handleEdit = (account) => {

        // First load the selected account into form
        editAccount(account);


        // Then switch to form tab
        setActiveTab("account");


        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });

    };


    /*
    |--------------------------------------------------------------------------
    | Save Success
    |--------------------------------------------------------------------------
    */

    const handleSaveSuccess = () => {

        // After Add/Update, open Account List
        setActiveTab("list");

    };


    return (

        <>

            {/* Page Header */}

            <div className="page-header d-print-none">

                <div className="row align-items-center">

                    <div className="col">

                        <div className="d-flex align-items-center gap-2">

                            <span className="text-secondary">
                                Account
                            </span>

                            <span className="text-secondary">
                                /
                            </span>

                            <h2 className="page-title mb-0">
                                My Account
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
                                activeTab === "account"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={() =>
                                setActiveTab("account")
                            }
                        >

                            <IconWallet
                                size={20}
                                className="me-2"
                            />

                            {id
                                ? "Update Account"
                                : "Account"
                            }

                        </button>


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

                            Account List

                        </button>

                    </div>

                </div>

            </div>


            {/* Account Form */}

            {activeTab === "account" && (

                <div className="row row-cards">

                    <div className="col-12">

                        <AccountForm
                            onSaveSuccess={handleSaveSuccess}
                        />

                    </div>

                </div>

            )}


            {/* Account List */}

            {activeTab === "list" && (

                <>

                    <div className="d-flex justify-content-between align-items-center mb-3">

                        <div>

                            <h3 className="mb-1">
                                Account List
                            </h3>

                            <div className="text-secondary">
                                Manage your payment accounts
                            </div>

                        </div>


                            <button
                                type="button"
                                className="btn btn-primary"
                                onClick={() => {

                                    resetForm();

                                    setActiveTab("account");

                                }}
                            >

                            <IconPlus
                                size={18}
                                className="me-2"
                            />

                            Add Account

                        </button>

                    </div>


                    <AccountHistory
                        onEdit={handleEdit}
                    />

                </>

            )}

        </>

    );

}