import { IconTrendingUp } from "@tabler/icons-react";

export default function StatCard({
    title,
    value,
    icon: Icon = IconTrendingUp,
    color = "primary",
}) {
    return (
        <div className="col-sm-6 col-lg-4 mb-3">
            <div className="card h-100 shadow-sm">

                <div className="card-body">

                    <div className="d-flex justify-content-between">

                        <div>

                            <div className="text-secondary">

                                {title}

                            </div>

                            <div className="display-6 fw-bold">

                                {value}

                            </div>

                        </div>

                        <span
                            className={`avatar avatar-lg bg-${color}-lt`}
                        >

                            <Icon
                                size={28}
                                className={`text-${color}`}
                            />

                        </span>

                    </div>

                </div>

            </div>
        </div>
    );
}