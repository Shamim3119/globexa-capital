import {
    IconDashboard,
    IconCash,
    IconChartLine,
    IconArrowDownCircle,
    IconUsers,
    IconUser,
    IconUserCircle,
    IconLogout,
    IconArrowsExchange,
    IconWallet,
    IconReceiptRefund,
    IconTransfer,
    IconFileDescription,
    IconLock,
    IconShieldCheck,     
    IconTrendingUp,     
} from "@tabler/icons-react";

import { NavLink } from "react-router-dom";

import { useAuth } from "../context/AuthContext";
import { useSidebar } from "../context/SidebarContext";

export default function Sidebar() {

    const { logout } = useAuth();

    const {
        collapsed,
        mobileOpen,
        closeMobileSidebar,
    } = useSidebar();


    const menuGroups = [

        // =========================
        // DASHBOARD
        // =========================

        {
            title: null,

            items: [

                {
                    name: "Dashboard",
                    icon: IconDashboard,
                    path: "/dashboard",
                },

            ],
        },


        // =========================
        // TRANSACTIONS
        // =========================

        {
            title: "Transactions",

            items: [

                {
                    name: "Deposit",
                    icon: IconCash,
                    path: "/deposit",
                },

                {
                    name: "Investment",
                    icon: IconChartLine,
                    path: "/investment",
                },

                {
                    name: "Withdraw",
                    icon: IconArrowDownCircle,
                    path: "/withdraw",
                },

                {
                    name: "Transfer",
                    icon: IconTransfer,
                    path: "/transfer",
                },

                {
                    name: "P2P",
                    icon: IconArrowsExchange,
                    path: "/p2p",
                },

                {
                    name: "Refund",
                    icon: IconReceiptRefund,
                    path: "/refund",
                },

            ],
        },


        // =========================
        // INCOME
        // =========================

        {
            title: "Report",

            items: [

                {
                    name: "Incomes",
                    icon: IconWallet,
                    path: "/incomes",
                },
                {
                    name: "Sales",
                    icon: IconTrendingUp,
                    path: "/sales",
                },
 

            ],
 
        },


        // =========================
        // NETWORK
        // =========================

        {
            title: "Network",

            items: [

                {
                    name: "My Team",
                    icon: IconUsers,
                    path: "/team",
                },

            ],
        },


        // =========================
        // ACCOUNT
        // =========================

        {
            title: "Account",

            items: [
                

                {
                    name: "My Account",
                    icon: IconUserCircle,
                    path: "/account",
                },

 

                {
                    name: "Profile",
                    icon: IconUser,
                    path: "/profile",
                },
                
                {
                    name: "Verification",
                    icon: IconShieldCheck,
                    path: "/verification",
                },

            ],
        },


        // =========================
        // COMPANY
        // =========================

        {
            title: "Company",

            items: [

                {
                    name: "Documents",
                    icon: IconFileDescription,
                    path: "/company-documents",
                },

            ],
        },

    ];


    return (

        <aside
            className={`
                navbar
                navbar-vertical
                navbar-expand-lg
                ${collapsed ? "collapsed" : ""}
                ${mobileOpen ? "mobile-open" : ""}
            `}
        >

            <div className="container-fluid h-100 d-flex flex-column">


                {/* =========================
                    LOGO
                ========================= */}

                <div className="navbar-brand">

                    {
                        collapsed && window.innerWidth >= 992

                            ?

                            <span className="fw-bold fs-3">
                                G
                            </span>

                            :

                            <span className="navbar-brand-text">
                                Globexa Capital
                            </span>
                    }

                </div>


                {/* =========================
                    MENU
                ========================= */}

                <div className="navbar-collapse flex-column flex-grow-1 overflow-auto">

                    <ul className="navbar-nav pt-lg-3">

                        {
                            menuGroups.map((group, index) => (

                                <div
                                    key={index}
                                    className="w-100"
                                >


                                    {/* GROUP TITLE */}

                                    {
                                        group.title &&
                                        (!collapsed || window.innerWidth < 992) &&

                                        <li className="nav-item mt-3">

                                            <span className="nav-link disabled">

                                                {group.title}

                                            </span>

                                        </li>
                                    }


                                    {/* GROUP ITEMS */}

                                    {
                                        group.items.map((item) => {

                                            const Icon = item.icon;


                                            return (

                                                <li
                                                    className="nav-item"
                                                    key={item.path}
                                                >

                                                    <NavLink
                                                        to={item.path}

                                                        onClick={() => {

                                                            if (
                                                                window.innerWidth < 992
                                                            ) {

                                                                closeMobileSidebar();

                                                            }

                                                        }}

                                                        className={({ isActive }) =>

                                                            isActive
                                                                ? "nav-link active"
                                                                : "nav-link"

                                                        }
                                                    >


                                                        {/* ICON */}

                                                        <span className="nav-link-icon">

                                                            <Icon size={20} />

                                                        </span>


                                                        {/* TITLE */}

                                                        {
                                                            (
                                                                !collapsed ||
                                                                window.innerWidth < 992
                                                            ) &&

                                                            <span className="nav-link-title">

                                                                {item.name}

                                                            </span>
                                                        }


                                                    </NavLink>

                                                </li>

                                            );

                                        })
                                    }

                                </div>

                            ))
                        }

                    </ul>

                </div>


                {/* =========================
                    LOGOUT
                ========================= */}

                <div className="mt-auto p-3">

                    <button
                        onClick={logout}
                        className="btn btn-danger w-100"
                    >

                        <IconLogout
                            size={20}
                            className="me-2"
                        />

                        {
                            (
                                !collapsed ||
                                window.innerWidth < 992
                            ) && "Logout"
                        }

                    </button>

                </div>


            </div>

        </aside>

    );
}

