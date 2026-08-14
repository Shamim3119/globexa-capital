import { useState } from "react";

import {
    IconUsers,
    IconChartLine,
    IconRefresh,
} from "@tabler/icons-react";

import { useTeam } from "../../context/TeamContext";


export default function Team() {

    const {
        summary,
        loading,
        error,
        loadTeam,
    } = useTeam();


    const [activeTab, setActiveTab] = useState("summary");


    const formatAmount = (value) => {
        if (value === null || value === undefined || value === "") {
            return "0.00";
        }

        const numericValue = Number(
            String(value).replace(/,/g, "")
        );

        if (Number.isNaN(numericValue)) {
            return "0.00";
        }

        return numericValue.toLocaleString("en-US", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
    };


    const calculateTreeTotal = (tree) => {

        return tree.reduce(
            (sum, item) =>
                sum + Number(item.investment_balance || 0),
            0
        ).toFixed(2);

    };


    return (

        <>

                    {/* Page Header */}

            <div className="page-header d-print-none">

                <div className="row align-items-center">

                    <div className="col">

                        <div className="d-flex align-items-center gap-2">

                            <span className="text-secondary">
                                Network 
                            </span>

                            <span className="text-secondary">
                                /
                            </span>

                            <h2 className="page-title mb-0">
                                My Team
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
                                activeTab === "summary"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={() =>
                                setActiveTab("summary")
                            }
                        >

                            <IconUsers
                                size={18}
                                className="me-2"
                            />

                            Summary

                        </button>


                        <button
                            type="button"
                            className={`nav-link ${
                                activeTab === "details"
                                    ? "active"
                                    : ""
                            }`}
                            onClick={() =>
                                setActiveTab("details")
                            }
                        >

                            <IconChartLine
                                size={18}
                                className="me-2"
                            />

                            Details

                        </button>

                    </div>

                </div>

            </div>


            {/* Loading */}

            {loading && (

                <div className="card">

                    <div className="card-body text-center py-5">

                        <div
                            className="spinner-border text-primary"
                            role="status"
                        />

                        <div className="text-secondary mt-3">
                            Loading team information...
                        </div>

                    </div>

                </div>

            )}


            {/* Error */}

            {!loading && error && (

                <div className="alert alert-danger">

                    <div className="d-flex align-items-center">

                        <div className="flex-fill">
                            {error}
                        </div>

                        <button
                            type="button"
                            className="btn btn-danger"
                            onClick={loadTeam}
                        >

                            <IconRefresh
                                size={18}
                                className="me-1"
                            />

                            Retry

                        </button>

                    </div>

                </div>

            )}


            {/* Content */}

            {!loading && !error && (

                <>

                    {/* ================= SUMMARY ================= */}

                    {activeTab === "summary" && (

                        <>

                            {/* Team Info */}

                            <div className="card mb-3">

                                <div className="card-header">

                                    <h3 className="card-title">

                                        <IconUsers
                                            size={22}
                                            className="me-2"
                                        />

                                        Team Info Summary

                                    </h3>

                                </div>


                                <div className="card-body">

                                    <div className="row">

                                        <div className="col-md-4 mb-3 text-center">

                                            <div className="text-secondary">
                                                Team (A)
                                            </div>

                                            <div className="h2 mb-0">
                                                {summary.team_a}
                                            </div>

                                        </div>


                                        <div className="col-md-4 mb-3 text-center">

                                            <div className="text-secondary">
                                                Team (B)
                                            </div>

                                            <div className="h2 mb-0">
                                                {summary.team_b}
                                            </div>

                                        </div>


                                        <div className="col-md-4 mb-3 text-center">

                                            <div className="text-secondary">
                                                Total Team Member
                                            </div>

                                            <div className="h2 mb-0">
                                                {summary.total}
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {/* Investment Summary */}

                            <div className="card">

                                <div className="card-header">

                                    <h3 className="card-title">

                                        <IconChartLine
                                            size={22}
                                            className="me-2"
                                        />

                                        Team Investment Summary

                                    </h3>

                                </div>


                                <div className="card-body">

                                    <div className="row">

                                        <div className="col-md-4 mb-3 text-center">

                                            <div className="text-secondary">
                                                Team (A)
                                            </div>

                                            <div className="h2 mb-0">

                                                $ {formatAmount(
                                                    summary.left_balance
                                                )}

                                            </div>

                                        </div>


                                        <div className="col-md-4 mb-3 text-center">

                                            <div className="text-secondary">
                                                Team (B)
                                            </div>

                                            <div className="h2 mb-0">

                                                $ {formatAmount(
                                                    summary.right_balance
                                                )}

                                            </div>

                                        </div>


                                        <div className="col-md-4 mb-3 text-center">

                                            <div className="text-secondary">
                                                Total Team Investment
                                            </div>

                                            <div className="h2 mb-0">

                                                $ {formatAmount(
                                                    summary.total_balance
                                                )}

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </>

                    )}


                    {/* ================= DETAILS ================= */}

                    {activeTab === "details" && (

                        <>

                            {/* Team A */}

                            <div className="card mb-3">

                                <div className="card-header">

                                    <h3 className="card-title">

                                        Team A Details

                                    </h3>

                                </div>


                                <div className="table-responsive">

                                    <table className="table table-vcenter card-table">

                                        <thead>

                                            <tr>

                                                <th>ID</th>

                                                <th className="text-end">
                                                    Investment
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            {summary.left_tree.length === 0 ? (

                                                <tr>

                                                    <td
                                                        colSpan="2"
                                                        className="text-center text-secondary py-4"
                                                    >
                                                        No Team A members
                                                    </td>

                                                </tr>

                                            ) : (

                                                summary.left_tree.map(
                                                    (item) => (

                                                        <tr key={item.id}>

                                                            <td>
                                                                {item.id}
                                                            </td>

                                                            <td className="text-end fw-bold">

                                                                $
                                                                {" "}
                                                                {formatAmount(
                                                                    item.investment_balance
                                                                )}

                                                            </td>

                                                        </tr>

                                                    )
                                                )

                                            )}

                                        </tbody>


                                        <tfoot>

                                            <tr>

                                                <th>
                                                    Total Team (A) Investment
                                                </th>

                                                <th className="text-end">

                                                    $
                                                    {" "}
                                                    {calculateTreeTotal(
                                                        summary.left_tree
                                                    )}

                                                </th>

                                            </tr>

                                        </tfoot>

                                    </table>

                                </div>

                            </div>


                            {/* Team B */}

                            <div className="card">

                                <div className="card-header">

                                    <h3 className="card-title">

                                        Team B Details

                                    </h3>

                                </div>


                                <div className="table-responsive">

                                    <table className="table table-vcenter card-table">

                                        <thead>

                                            <tr>

                                                <th>ID</th>

                                                <th className="text-end">
                                                    Investment
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            {summary.right_tree.length === 0 ? (

                                                <tr>

                                                    <td
                                                        colSpan="2"
                                                        className="text-center text-secondary py-4"
                                                    >
                                                        No Team B members
                                                    </td>

                                                </tr>

                                            ) : (

                                                summary.right_tree.map(
                                                    (item) => (

                                                        <tr key={item.id}>

                                                            <td>
                                                                {item.id}
                                                            </td>

                                                            <td className="text-end fw-bold">

                                                                $
                                                                {" "}
                                                                {formatAmount(
                                                                    item.investment_balance
                                                                )}

                                                            </td>

                                                        </tr>

                                                    )
                                                )

                                            )}

                                        </tbody>


                                        <tfoot>

                                            <tr>

                                                <th>
                                                    Total Team (B) Investment
                                                </th>

                                                <th className="text-end">

                                                    $
                                                    {" "}
                                                    {calculateTreeTotal(
                                                        summary.right_tree
                                                    )}

                                                </th>

                                            </tr>

                                        </tfoot>

                                    </table>

                                </div>

                            </div>

                        </>

                    )}

                </>

            )}

        </>

    );

}