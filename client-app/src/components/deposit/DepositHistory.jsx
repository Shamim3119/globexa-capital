import { useState } from "react";

import {
    IconReceipt,
    IconFileDescription,
    IconX,
    IconZoomIn,
} from "@tabler/icons-react";

import { useDeposit } from "../../context/DepositContext";

export default function DepositHistory() {

    const {
        deposits,
        loading,
        formatDate,
        getStatusText,
    } = useDeposit();

    const [selectedImage, setSelectedImage] = useState(null);


    const getStatusClass = (status) => {

        switch (Number(status)) {

            case 1:
                return "bg-warning";

            case 2:
                return "bg-success";

            case 3:
                return "bg-danger";

            default:
                return "bg-secondary";
        }
    };


    const getStatusTextSafe = (status) => {

        return getStatusText
            ? getStatusText(status)
            : "Unknown";

    };


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    if (loading && deposits.length === 0) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <div
                        className="spinner-border text-primary"
                        role="status"
                    />

                    <div className="text-secondary mt-3">
                        Loading deposit history...
                    </div>

                </div>

            </div>

        );

    }


    /*
    |--------------------------------------------------------------------------
    | Empty
    |--------------------------------------------------------------------------
    */

    if (!deposits.length) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <IconReceipt
                        size={45}
                        className="text-secondary mb-3"
                    />

                    <h3 className="mb-1">
                        No Deposits Found
                    </h3>

                    <div className="text-secondary">
                        Your deposit history will appear here.
                    </div>

                </div>

            </div>

        );

    }


    /*
    |--------------------------------------------------------------------------
    | Deposit History
    |--------------------------------------------------------------------------
    */

    return (

        <>

            <div className="card">

                {/* Header */}

                <div className="card-header">

                    <h3 className="card-title mb-0">

                        <IconReceipt
                            size={20}
                            className="me-2"
                        />

                        Deposit History

                    </h3>

                </div>


                {/* Cards */}

                <div className="card-body">

                    <div className="row g-3">

                        {deposits.map((item) => (

                            <div
                                className="col-12 col-md-6 col-xl-4"
                                key={item.id}
                            >

                                <div
                                    className="card h-100 mb-0"
                                    style={{
                                        border: "1px solid #e5e7eb",
                                        borderRadius: "14px",
                                        boxShadow:
                                            "0 2px 8px rgba(0,0,0,0.04)",
                                    }}
                                >

                                    <div className="card-body">


                                        {/* Amount */}

                                        <div
                                            className="d-flex justify-content-between align-items-center"
                                        >

                                            <span className="text-secondary">
                                                Amount
                                            </span>

                                            <strong
                                                style={{
                                                    color: "#003366",
                                                    fontSize: "18px",
                                                }}
                                            >
                                                {item.amount}
                                            </strong>

                                        </div>


                                        {/* TRX ID */}

                                        <div
                                            className="d-flex justify-content-between align-items-start mt-2"
                                        >

                                            <span className="text-secondary">
                                                Trx ID
                                            </span>

                                            <span
                                                className="fw-semibold text-end"
                                                style={{
                                                    maxWidth: "65%",
                                                    wordBreak: "break-word",
                                                }}
                                            >
                                                {item.trxid || "-"}
                                            </span>

                                        </div>


                                        {/* Created */}

                                        <div
                                            className="d-flex justify-content-between align-items-start mt-2"
                                        >

                                            <span className="text-secondary">
                                                Created
                                            </span>

                                            <span
                                                className="fw-semibold text-end"
                                            >
                                                {formatDate(
                                                    item.created_at
                                                )}
                                            </span>

                                        </div>


                                        {/* Success */}

                                        {item.accept_at && (

                                            <div
                                                className="d-flex justify-content-between align-items-start mt-2"
                                            >

                                                <span className="text-secondary">
                                                    Success
                                                </span>

                                                <span
                                                    className="fw-semibold text-end"
                                                >
                                                    {formatDate(
                                                        item.accept_at
                                                    )}
                                                </span>

                                            </div>

                                        )}


                                        {/* Divider */}

                                        <div
                                            style={{
                                                height: "1px",
                                                backgroundColor: "#e5e5e5",
                                                margin:
                                                    "14px 0",
                                            }}
                                        />


                                        {/* Status */}

                                        <div
                                            className="d-flex justify-content-between align-items-center"
                                        >

                                            <span className="text-secondary">
                                                Status
                                            </span>

                                            <span
                                                className={`badge ${getStatusClass(
                                                    item.status_id
                                                )}`}
                                                style={{
                                                    minWidth: "90px",
                                                    padding:
                                                        "7px 12px",
                                                    fontSize:
                                                        "13px",
                                                }}
                                            >

                                                {getStatusTextSafe(
                                                    item.status_id
                                                )}

                                            </span>

                                        </div>


                                        {/* Deposit Document */}

                                        {item.deposit_doc && (

                                            <>

                                                <div
                                                    style={{
                                                        height: "1px",
                                                        backgroundColor:
                                                            "#e5e5e5",
                                                        margin:
                                                            "14px 0",
                                                    }}
                                                />


                                                <div className="text-center">

                                                    <div
                                                        className="fw-semibold mb-2"
                                                    >
                                                        Deposit Slip
                                                    </div>


                                                    <div
                                                        className="position-relative d-inline-block"
                                                        style={{
                                                            cursor:
                                                                "pointer",
                                                        }}
                                                        onClick={() =>
                                                            setSelectedImage(
                                                                `https://globexacapital.com/${item.deposit_doc}`
                                                            )
                                                        }
                                                    >

                                                        <img
                                                            src={`https://globexacapital.com/${item.deposit_doc}`}
                                                            alt="Deposit Slip"
                                                            className="img-fluid"
                                                            style={{
                                                                width:
                                                                    "140px",
                                                                height:
                                                                    "140px",
                                                                objectFit:
                                                                    "cover",
                                                                borderRadius:
                                                                    "12px",
                                                                border:
                                                                    "1px solid #ddd",
                                                            }}
                                                        />


                                                        {/* Zoom overlay */}

                                                        <div
                                                            className="position-absolute d-flex align-items-center justify-content-center"
                                                            style={{
                                                                right:
                                                                    "6px",
                                                                bottom:
                                                                    "6px",
                                                                width:
                                                                    "32px",
                                                                height:
                                                                    "32px",
                                                                backgroundColor:
                                                                    "rgba(0,0,0,0.65)",
                                                                borderRadius:
                                                                    "50%",
                                                                color:
                                                                    "#fff",
                                                            }}
                                                        >

                                                            <IconZoomIn
                                                                size={17}
                                                            />

                                                        </div>

                                                    </div>

                                                </div>

                                            </>

                                        )}


                                        {/* No document */}

                                        {!item.deposit_doc && (

                                            <div
                                                className="text-center text-secondary small mt-3"
                                            >

                                                <IconFileDescription
                                                    size={18}
                                                    className="me-1"
                                                />

                                                No deposit slip

                                            </div>

                                        )}

                                    </div>

                                </div>

                            </div>

                        ))}

                    </div>

                </div>

            </div>


            {/* =========================================================
                IMAGE MODAL
            ========================================================= */}

            {selectedImage && (

                <div
                    className="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                    style={{
                        backgroundColor:
                            "rgba(0, 0, 0, 0.90)",
                        zIndex: 9999,
                        padding: "20px",
                    }}
                    onClick={() =>
                        setSelectedImage(null)
                    }
                >

                    {/* Close button */}

                    <button
                        type="button"
                        className="btn btn-dark position-absolute"
                        style={{
                            top: "20px",
                            right: "20px",
                            width: "42px",
                            height: "42px",
                            borderRadius: "50%",
                            zIndex: 10000,
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "center",
                        }}
                        onClick={(e) => {

                            e.stopPropagation();

                            setSelectedImage(null);

                        }}
                    >

                        <IconX size={22} />

                    </button>


                    {/* Full image */}

                    <img
                        src={selectedImage}
                        alt="Deposit Slip"
                        onClick={(e) =>
                            e.stopPropagation()
                        }
                        style={{
                            maxWidth: "95%",
                            maxHeight: "90%",
                            objectFit: "contain",
                            borderRadius: "12px",
                            boxShadow:
                                "0 10px 40px rgba(0,0,0,0.5)",
                        }}
                    />

                </div>

            )}

        </>

    );

}