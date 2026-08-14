export default function DashboardStatCard({
    title,
    today,
    lastWeek,
    icon: Icon,
    className = "",
}) {

    return (

        <div className="col-12 col-sm-6 col-xl-3">

            <div className={`card dashboard-stat-card h-100 ${className}`}>

                <div className="card-body">

                    <div className="d-flex align-items-center justify-content-between">

                        <div>

                            <div className="text-secondary mb-1">
                                {title}
                            </div>

                            <div className="dashboard-stat-value">

                                ৳ {Number(today || 0).toFixed(2)}

                            </div>

                            <div className="dashboard-stat-label">
                                Today
                            </div>

                        </div>


                        <span className="dashboard-stat-icon">

                            <Icon size={24} />

                        </span>

                    </div>


                    <div className="dashboard-stat-footer">

                        <span>
                            Last Week
                        </span>

                        <strong>
                            ৳ {Number(lastWeek || 0).toFixed(2)}
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    );

}