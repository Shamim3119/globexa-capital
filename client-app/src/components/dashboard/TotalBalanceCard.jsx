import {
    IconWallet,
    IconChartLine,
    IconCoin,
    IconArrowDownCircle,
} from "@tabler/icons-react";

export default function TotalBalanceCard({ totals }) {
    return (
        <div className="row g-3 mt-3">
            {/* Total Deposit */}
            <div className="col-6 col-md-3">
                <div
                    className="card h-100 border-0 shadow-sm py-3 py-md-4 px-2 text-center justify-content-center"
                    style={{ backgroundColor: "#eef6ff", minHeight: "110px" }}
                >
                    <div className="d-flex align-items-center justify-content-center text-primary mb-2">
                        <IconWallet size={22} />
                        <span className="ms-2 fw-bold" style={{ fontSize: "0.95rem" }}>
                            Total Deposit
                        </span>
                    </div>
                    <div className="fs-4 fw-bold text-primary">
                        {Number(totals?.deposit || 0).toFixed(2)}
                    </div>
                </div>
            </div>

            {/* Total Income */}
            <div className="col-6 col-md-3">
                <div
                    className="card h-100 border-0 shadow-sm py-3 py-md-4 px-2 text-center justify-content-center"
                    style={{ backgroundColor: "#fefce8", minHeight: "110px" }}
                >
                    <div className="d-flex align-items-center justify-content-center text-warning mb-2">
                        <IconCoin size={22} />
                        <span className="ms-2 fw-bold" style={{ fontSize: "0.95rem" }}>
                            Total Income
                        </span>
                    </div>
                    <div className="fs-4 fw-bold text-warning">
                        {Number(totals?.income || 0).toFixed(2)}
                    </div>
                </div>
            </div>

            {/* Total Investment */}
            <div className="col-6 col-md-3">
                <div
                    className="card h-100 border-0 shadow-sm py-3 py-md-4 px-2 text-center justify-content-center"
                    style={{ backgroundColor: "#f0fdf4", minHeight: "110px" }}
                >
                    <div className="d-flex align-items-center justify-content-center text-success mb-2">
                        <IconChartLine size={22} />
                        <span className="ms-2 fw-bold" style={{ fontSize: "0.95rem" }}>
                            Total Invest
                        </span>
                    </div>
                    <div className="fs-4 fw-bold text-success">
                        {Number(totals?.investment || 0).toFixed(2)}
                    </div>
                </div>
            </div>

            {/* Total Withdrawal */}
            <div className="col-6 col-md-3">
                <div
                    className="card h-100 border-0 shadow-sm py-3 py-md-4 px-2 text-center justify-content-center"
                    style={{ backgroundColor: "#fef2f2", minHeight: "110px" }}
                >
                    <div className="d-flex align-items-center justify-content-center text-danger mb-2">
                        <IconArrowDownCircle size={22} />
                        <span className="ms-2 fw-bold" style={{ fontSize: "0.95rem" }}>
                            Total Withdraw
                        </span>
                    </div>
                    <div className="fs-4 fw-bold text-danger">
                        {Number(totals?.withdraw || 0).toFixed(2)}
                    </div>
                </div>
            </div>
        </div>
    );
}