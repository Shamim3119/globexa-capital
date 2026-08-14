import {
    IconChartLine,
    IconCalendar,
    IconCash,
    IconPercentage,
} from "@tabler/icons-react";

import { useInvestment } from "../../context/InvestmentContext";

export default function InvestmentHistory() {

    const {
        investments,
        investmentsLoading,
        planName,
    } = useInvestment();


    const formatDate = (dateString) => {

        if (!dateString) {
            return "-";
        }

        const date = new Date(dateString);

        if (isNaN(date.getTime())) {
            return "-";
        }

        return date.toLocaleString("en-GB", {
            day: "2-digit",
            month: "short",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            hour12: true,
        });

    };


    if (investmentsLoading) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <div
                        className="spinner-border text-primary"
                        role="status"
                    />

                    <div className="text-secondary mt-3">
                        Loading investment history...
                    </div>

                </div>

            </div>

        );

    }


    if (!investments.length) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <IconChartLine
                        size={48}
                        className="text-secondary mb-3"
                    />

                    <h3>
                        No Investments Found
                    </h3>

                    <div className="text-secondary">
                        You have not created any investment yet.
                    </div>

                </div>

            </div>

        );

    }


    return (

        <div className="card">

            <div className="card-header">

                <div>

                    <h3 className="card-title mb-1">
                        Investment History
                    </h3>

                    <div className="text-secondary">
                        Your investment transactions
                    </div>

                </div>

            </div>


            <div className="list-group list-group-flush">

                {investments.map((item) => (

                    <div
                        key={item.id}
                        className="list-group-item"
                    >

                        <div className="row align-items-center">


                            {/* Icon */}

                            <div className="col-auto">

                                <span className="avatar bg-primary-lt">

                                    <IconChartLine size={22}/>

                                </span>

                            </div>


                            {/* Main information */}

                            <div className="col">

                                <div className="fw-bold">

                                    Investment #{item.id}

                                </div>


                                <div className="text-secondary small">

                                    {planName(item.investment_id)}

                                </div>


                                <div className="text-secondary small mt-1">

                                    <IconCalendar
                                        size={15}
                                        className="me-1"
                                    />

                                    {formatDate(item.created_at)}

                                </div>

                            </div>


                            {/* Amount */}

                            <div className="col-auto text-end">

                                <div className="fw-bold">

                                    <IconCash
                                        size={16}
                                        className="me-1"
                                    />

                                    ৳ {Number(item.amount || 0).toFixed(2)}

                                </div>


                                {item.commission !== undefined && (

                                    <div className="text-success small">

                                        <IconPercentage
                                            size={14}
                                            className="me-1"
                                        />

                                        Commission:
                                        {" "}
                                        {item.commission}

                                    </div>

                                )}

                            </div>

                        </div>

                    </div>

                ))}

            </div>

        </div>

    );

}