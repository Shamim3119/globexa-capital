import {
    IconWallet,
    IconChartLine,
    IconCoin,
    IconArrowDownCircle,
    IconRefresh,
} from "@tabler/icons-react";

import { useAuth } from "../../context/AuthContext";

import WelcomeCard from "../../components/dashboard/WelcomeCard";
import BalanceCard from "../../components/dashboard/BalanceCard";
import TeamCard from "../../components/dashboard/TeamCard";
import QuickActions from "../../components/dashboard/QuickActions";
import DashboardStatCard from "../../components/dashboard/DashboardStatCard";
import TotalBalanceCard from "../../components/dashboard/TotalBalanceCard";

import { useDashboard } from "../../context/DashboardContext";

import Loader from "../../components/Loader";

export default function Dashboard() {
    const { user } = useAuth();

    const {
        dashboard,
        loading,
        refreshing,
        error,
        loadDashboard
    } = useDashboard();

    if (loading) {
        return <Loader />;
    }

    return (
        <>
            {/* Header */}
            <div className="d-flex justify-content-end mb-3">
                <button
                    type="button"
                    className="btn btn-outline-primary"
                    onClick={() => loadDashboard(true)}
                    disabled={refreshing}
                >
                    <IconRefresh
                        size={18}
                        className={refreshing ? "dashboard-refresh-spin" : ""}
                    />
                    <span className="ms-2">
                        {refreshing ? "Refreshing..." : "Refresh"}
                    </span>
                </button>
            </div>

            {/* Error */}
            {error && (
                <div
                    className="alert alert-danger d-flex align-items-center justify-content-between"
                    role="alert"
                >
                    <div>
                        <strong>Dashboard Error</strong>
                        <div className="small mt-1">{error}</div>
                    </div>

                    <button
                        type="button"
                        className="btn btn-danger btn-sm"
                        onClick={() => loadDashboard()}
                    >
                        Try Again
                    </button>
                </div>
            )}

            {/* Welcome */}
            <WelcomeCard user={user} />

            {/* Balances */}
            <div className="row mt-3">
                <BalanceCard
                    title="Deposit Balance"
                    value={user?.deposit_balance}
                    icon={IconWallet}
                    color="blue"
                />

                <BalanceCard
                    title="Investment"
                    value={user?.investment_balance}
                    icon={IconChartLine}
                    color="green"
                />

                <BalanceCard
                    title="Income"
                    value={user?.income_balance}
                    icon={IconCoin}
                    color="yellow"
                />
            </div>

            {/* Statistics */}
            <div className="row g-3 mt-1">
                <DashboardStatCard
                    title="Deposit"
                    today={dashboard?.deposit?.today}
                    lastWeek={dashboard?.deposit?.lastWeek}
                    icon={IconWallet}
                    className="stat-deposit"
                />

                <DashboardStatCard
                    title="Investment"
                    today={dashboard?.investment?.today}
                    lastWeek={dashboard?.investment?.lastWeek}
                    icon={IconChartLine}
                    className="stat-investment"
                />

                <DashboardStatCard
                    title="Income"
                    today={dashboard?.income?.today}
                    lastWeek={dashboard?.income?.lastWeek}
                    icon={IconCoin}
                    className="stat-income"
                />

                <DashboardStatCard
                    title="Withdraw"
                    today={dashboard?.withdraw?.today}
                    lastWeek={dashboard?.withdraw?.lastWeek}
                    icon={IconArrowDownCircle}
                    className="stat-withdraw"
                />
            </div>

            {/* Grand Totals Component */}
            <TotalBalanceCard totals={dashboard?.totals} />

            {/* Team */}
            <div className="mt-3">
                <TeamCard user={user} />
            </div>

            {/* Quick Actions */}
            <div className="mt-3">
                <QuickActions />
            </div>
        </>
    );
}