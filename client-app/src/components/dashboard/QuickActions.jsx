import {
    IconCash,
    IconChartLine,
    IconArrowDownCircle,
    IconUsers,
    IconUser,
    IconUserCircle,
    IconArrowsExchange,
    IconWallet,
    IconReceiptRefund,
    IconTransfer,
    IconFileDescription,
    IconLock,
} from "@tabler/icons-react";

import { Link } from "react-router-dom";


export default function QuickActions() {

    const actions = [

        {
            title: "Deposit",
            description: "Add funds to your account",
            icon: IconCash,
            path: "/deposit",
            className: "quick-action-blue",
        },

        {
            title: "Investment",
            description: "Manage your investments",
            icon: IconChartLine,
            path: "/investment",
            className: "quick-action-green",
        },

        {
            title: "Withdraw",
            description: "Request a withdrawal",
            icon: IconArrowDownCircle,
            path: "/withdraw",
            className: "quick-action-yellow",
        },

        {
            title: "Transfer",
            description: "Transfer funds",
            icon: IconTransfer,
            path: "/transfer",
            className: "quick-action-pink",
        },

        {
            title: "P2P",
            description: "Peer-to-peer transactions",
            icon: IconArrowsExchange,
            path: "/p2p",
            className: "quick-action-cyan",
        },
        
        {
            title: "Refund",
            description: "Manage refund requests",
            icon: IconReceiptRefund,
            path: "/refund",
            className: "quick-action-orange",
        },

        {
            title: "Incomes",
            description: "View your income history",
            icon: IconWallet,
            path: "/incomes",
            className: "quick-action-teal",
        },

        {
            title: "My Team",
            description: "View your team network",
            icon: IconUsers,
            path: "/team",
            className: "quick-action-purple",
        },

        {
            title: "My Account",
            description: "View account information",
            icon: IconUserCircle,
            path: "/account",
            className: "quick-action-indigo",
        },

        {
            title: "Profile",
            description: "Manage your profile",
            icon: IconUserCircle,
            path: "/profile",
            className: "quick-action-blue",
        },
 

        {
            title: "Company Documents",
            description: "View company documents",
            icon: IconFileDescription,
            path: "/company-documents",
            className: "quick-action-brown",
        },

 

    ];


    return (

        <div className="card quick-actions-card">

            <div className="card-body">

                <div className="d-flex align-items-center justify-content-between mb-3">

                    <div>

                        <h3 className="card-title mb-1">
                            Quick Actions
                        </h3>

                        <div className="text-secondary small">
                            Quickly access your account
                        </div>

                    </div>

                </div>


                <div className="row g-3">

                    {
                        actions.map((action) => {

                            const Icon = action.icon;


                            return (

                                <div
                                    className="col-12 col-sm-6 col-lg-4"
                                    key={action.path}
                                >

                                    <Link
                                        to={action.path}
                                        className={`quick-action ${action.className}`}
                                    >

                                        <span className="quick-action-icon">

                                            <Icon size={22} />

                                        </span>


                                        <span className="quick-action-content">

                                            <span className="quick-action-title">
                                                {action.title}
                                            </span>

                                            <span className="quick-action-description">
                                                {action.description}
                                            </span>

                                        </span>

                                    </Link>

                                </div>

                            );

                        })

                    }

                </div>

            </div>

        </div>

    );

}