import {
    IconUsers,
    IconArrowLeft,
    IconArrowRight,
} from "@tabler/icons-react";


export default function TeamCard({ user }) {

    return (

        <div className="row g-3">

            {/* Left Team */}

            <div className="col-12 col-md-6">

                <div className="card team-business-card h-100">

                    <div className="card-body">

                        <div className="d-flex align-items-center justify-content-between">

                            <div>

                                <div className="text-secondary mb-1">
                                    Left Team Business
                                </div>

                                <div className="team-business-value">

                                    $ {Number(
                                        user?.left_balance || 0
                                    ).toFixed(2)}

                                </div>

                            </div>


                            <span className="avatar team-icon">

                                <IconArrowLeft size={22} />

                            </span>

                        </div>


                        <div className="team-business-footer">

                            <IconUsers size={16} />

                            <span>
                                Left Team
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {/* Right Team */}

            <div className="col-12 col-md-6">

                <div className="card team-business-card h-100">

                    <div className="card-body">

                        <div className="d-flex align-items-center justify-content-between">

                            <div>

                                <div className="text-secondary mb-1">
                                    Right Team Business
                                </div>

                                <div className="team-business-value">

                                    $ {Number(
                                        user?.right_balance || 0
                                    ).toFixed(2)}

                                </div>

                            </div>


                            <span className="avatar team-icon">

                                <IconArrowRight size={22} />

                            </span>

                        </div>


                        <div className="team-business-footer">

                            <IconUsers size={16} />

                            <span>
                                Right Team
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    );

}