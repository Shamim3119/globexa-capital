import { IconRefresh, IconCalendar, IconCash } from "@tabler/icons-react";
import { useRefund } from "../../context/RefundContext";

export default function RefundList() {

    const {
        investments,
        loading,
        getRefundButton,
        formatDate,
        openRefund,
    } = useRefund();


    if (loading) {

        return (
            <div className="card">
                <div className="card-body text-center py-5">
                    <div className="spinner-border text-primary" />
                    <div className="text-secondary mt-2">
                        Loading investments...
                    </div>
                </div>
            </div>
        );

    }


    if (!investments.length) {

        return (
            <div className="card">
                <div className="card-body text-center py-5">

                    <IconRefresh
                        size={40}
                        className="text-secondary mb-3"
                    />

                    <h3>No investments found</h3>

                    <div className="text-secondary">
                        You do not have any investment records.
                    </div>

                </div>
            </div>
        );

    }


    return (

        <div className="row g-3">

            {investments.map((item) => {

                const button = getRefundButton(item);

                const isRegular =
                    item.commission_info?.id === 1;


                return (

                    <div
                        className="col-12 col-md-6 col-xl-4"
                        key={item.id}
                    >

                        <div className="card h-100">

                            <div className="card-body">

                                {/* Header */}

                                <div className="d-flex justify-content-between align-items-center mb-3">

                                    <h3 className="card-title mb-0">
                                        Investment
                                    </h3>

                                    <span
                                        className={`badge text-white ${
                                            isRegular
                                                ? "bg-success"
                                                : "bg-danger"
                                        }`}
                                    >
                                        {isRegular
                                            ? "Regular"
                                            : "Fixed"}
                                    </span>

                                </div>


                                {/* Amount */}

                                <div className="mb-3">

                                    <div className="text-secondary small">
                                        Investment Amount
                                    </div>

                                    <div className="fs-2 fw-bold text-primary">

                                        {Number(
                                            item.amount || 0
                                        ).toFixed(2)} $

                                    </div>

                                </div>


                                {/* Information */}

                                <div className="border-top pt-3">

                                    <div className="d-flex justify-content-between mb-2">

                                        <span className="text-secondary">
                                            <IconCash
                                                size={16}
                                                className="me-1"
                                            />

                                            Total Income
                                        </span>

                                        <strong>
                                            {Number(
                                                item.total_income || 0
                                            ).toFixed(2)} $
                                        </strong>

                                    </div>


                                    <div className="d-flex justify-content-between">

                                        <span className="text-secondary">
                                            <IconCalendar
                                                size={16}
                                                className="me-1"
                                            />

                                            Started
                                        </span>

                                        <strong>
                                            {formatDate(
                                                item.created_at
                                            )}
                                        </strong>

                                    </div>

                                </div>


                                {/* Refund */}

                                <button
                                    type="button"
                                    disabled={button.disabled}
                                    onClick={() =>
                                        openRefund(item.id)
                                    }
                                    className="btn w-100 mt-4"
                                    style={{
                                        backgroundColor:
                                            button.color,
                                        color: "#fff",
                                        opacity:
                                            button.disabled
                                                ? 0.7
                                                : 1,
                                    }}
                                >

                                    <IconRefresh
                                        size={18}
                                        className="me-2"
                                    />

                                    {button.text}

                                </button>

                            </div>

                        </div>

                    </div>

                );

            })}

        </div>

    );

}