import {
    IconUsersGroup,
    IconTrendingUp,
    IconUser,
    IconCalendar,
    IconChartBar,
} from "@tabler/icons-react";

import { useSales } from "../../context/SalesContext";


export default function SalesHistory() {

    const {

        result,
        loading,
        error,

    } = useSales();


    if (loading) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <div
                        className="spinner-border text-primary mb-3"
                        role="status"
                    />

                    <div className="text-secondary">

                        Loading sales report...

                    </div>

                </div>

            </div>

        );

    }


    if (error) {

        return (

            <div className="alert alert-danger">

                {error}

            </div>

        );

    }


    if (!result) {

        return (

            <div className="card">

                <div className="card-body text-center py-5">

                    <IconChartBar
                        size={48}
                        className="text-secondary mb-3"
                    />

                    <h3 className="mb-2">

                        Sales Report

                    </h3>

                    <div className="text-secondary">

                        Select your filters and click Search to view
                        the sales report.

                    </div>

                </div>

            </div>

        );

    }


    return (

        <>

            {/* Client Information */}

            <div className="card mb-4">

                <div className="card-body">

                    <div className="row g-3 align-items-center">


                        <div className="col-12 col-md-6">

                            <div className="d-flex align-items-center">

                                <div className="avatar avatar-md bg-primary-lt me-3">

                                    <IconUser
                                        size={22}
                                    />

                                </div>


                                <div>

                                    <div className="text-secondary small">

                                        Client

                                    </div>

                                    <div className="fw-bold fs-3">

                                        {result.client_name || "-"}

                                    </div>

                                    <div className="text-secondary">

                                        Client ID: {result.client_id || "-"}

                                    </div>

                                </div>

                            </div>

                        </div>



                        <div className="col-12 col-md-6">

                            <div className="d-flex align-items-center">

                                <IconCalendar
                                    size={20}
                                    className="text-secondary me-2"
                                />

                                <div>

                                    <div className="text-secondary small">

                                        Report Period

                                    </div>

                                    <div className="fw-bold">

                                        {result.filters?.start_date || "-"}
                                        {" "}
                                        to
                                        {" "}
                                        {result.filters?.end_date || "-"}

                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>

            </div>



            {/* Team Balances */}

            <div className="row row-cards">


                {/* Team A */}

                <div className="col-12 col-md-6">

                    <div className="card">

                        <div className="card-body">

                            <div className="d-flex align-items-center">


                                <div className="avatar avatar-md bg-blue-lt me-3">

                                    <IconUsersGroup
                                        size={24}
                                    />

                                </div>


                                <div className="flex-fill">

                                    <div className="text-secondary">

                                        Team A Balance

                                    </div>


                                    <div className="h1 mb-0 text-primary">

                                        {Number(
                                            result.left_investment_balance || 0
                                        ).toFixed(2)}

                                    </div>

                                </div>


                                <IconTrendingUp
                                    size={28}
                                    className="text-secondary"
                                />


                            </div>

                        </div>

                    </div>

                </div>



                {/* Team B */}

                <div className="col-12 col-md-6">

                    <div className="card">

                        <div className="card-body">

                            <div className="d-flex align-items-center">


                                <div className="avatar avatar-md bg-green-lt me-3">

                                    <IconUsersGroup
                                        size={24}
                                    />

                                </div>


                                <div className="flex-fill">

                                    <div className="text-secondary">

                                        Team B Balance

                                    </div>


                                    <div className="h1 mb-0 text-success">

                                        {Number(
                                            result.right_investment_balance || 0
                                        ).toFixed(2)}

                                    </div>

                                </div>


                                <IconTrendingUp
                                    size={28}
                                    className="text-secondary"
                                />


                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </>

    );

}