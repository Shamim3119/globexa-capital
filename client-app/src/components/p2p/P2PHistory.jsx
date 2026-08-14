import {
    IconArrowsExchange,
    IconArrowDownLeft,
    IconArrowUpRight,
} from "@tabler/icons-react";

import { useP2P } from "../../context/P2PContext";
import { useAuth } from "../../context/AuthContext";

export default function P2PHistory() {

    const {
        p2ps,
        historyLoading,
        formatDate,
    } = useP2P();

    const { user } = useAuth();


    if (historyLoading) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <div
                        className="spinner-border text-primary mb-3"
                        role="status"
                    />

                    <div className="text-secondary">
                        Loading P2P records...
                    </div>

                </div>

            </div>

        );

    }


    if (!p2ps || p2ps.length === 0) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <IconArrowsExchange
                        size={42}
                        className="text-secondary mb-3"
                    />

                    <h3 className="mb-1">
                        No P2P Records
                    </h3>

                    <div className="text-secondary">
                        No P2P transaction records found.
                    </div>

                </div>

            </div>

        );

    }


    return (

        <div>

            {p2ps.map((item) => {

                const isOutgoing =
                    Number(item.from_id) === Number(user?.id);


                return (

                    <div
                        className="card mb-3"
                        key={item.id}
                    >

                        <div className="card-body">

                            {/* Header */}

                            <div className="d-flex justify-content-between align-items-center">

                                <div className="d-flex align-items-center">

                                    <span
                                        className={`
                                            avatar
                                            me-3
                                            ${
                                                isOutgoing
                                                    ? "bg-danger-lt"
                                                    : "bg-success-lt"
                                            }
                                        `}
                                    >

                                        {isOutgoing ? (

                                            <IconArrowUpRight
                                                size={22}
                                                className="text-danger"
                                            />

                                        ) : (

                                            <IconArrowDownLeft
                                                size={22}
                                                className="text-success"
                                            />

                                        )}

                                    </span>


                                    <div>

                                        <h3 className="card-title mb-1">

                                            P2P Transfer

                                        </h3>

                                        <div className="text-secondary small">

                                            {formatDate(
                                                item.created_at
                                            )}

                                        </div>

                                    </div>

                                </div>


                                {/* IN / OUT */}

                                <span
                                    className={`
                                        badge
                                        ${
                                            isOutgoing
                                                ? "bg-danger"
                                                : "bg-success"
                                        }
                                    `}
                                >

                                    {isOutgoing
                                        ? "OUT"
                                        : "IN"
                                    }

                                </span>

                            </div>


                            <div className="hr my-3" />


                            {/* Sender */}

                            <div className="row mb-2">

                                <div className="col-6 text-secondary">
                                    Sender ID
                                </div>

                                <div className="col-6 text-end fw-semibold">
                                    {item.from_id}
                                </div>

                            </div>


                            <div className="row mb-2">

                                <div className="col-6 text-secondary">
                                    Sender Name
                                </div>

                                <div className="col-6 text-end fw-semibold">

                                    {item.sender?.name || "-"}

                                </div>

                            </div>


                            {/* Receiver */}

                            <div className="row mb-2">

                                <div className="col-6 text-secondary">
                                    Receiver ID
                                </div>

                                <div className="col-6 text-end fw-semibold">
                                    {item.to_id}
                                </div>

                            </div>


                            <div className="row mb-3">

                                <div className="col-6 text-secondary">
                                    Receiver Name
                                </div>

                                <div className="col-6 text-end fw-semibold">

                                    {item.receiver?.name || "-"}

                                </div>

                            </div>


                            {/* Amount */}

                            <div className="border-top pt-3">

                                <div className="d-flex justify-content-between align-items-center">

                                    <span className="text-secondary">
                                        Amount
                                    </span>

                                    <span
                                        className={`
                                            fs-3
                                            fw-bold
                                            ${
                                                isOutgoing
                                                    ? "text-danger"
                                                    : "text-success"
                                            }
                                        `}
                                    >

                                        {isOutgoing ? "-" : "+"}

                                        $

                                        {Number(
                                            item.amount || 0
                                        ).toFixed(2)}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                );

            })}

        </div>

    );

}