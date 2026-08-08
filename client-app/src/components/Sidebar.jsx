import {
    IconDashboard,
    IconCash,
    IconChartLine,
    IconArrowDownCircle,
    IconUsers,
    IconUser,
    IconLogout,
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
            ],
        },

        {
            title: "Network",
            items: [
                {
                    name: "Team",
                    icon: IconUsers,
                    path: "/team",
                },
            ],
        },

        {
            title: "Account",
            items: [
                {
                    name: "Profile",
                    icon: IconUser,
                    path: "/profile",
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

                {/* Logo */}

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



                {/* Menu */}

                <div className="navbar-collapse flex-column flex-grow-1 overflow-auto">

                    <ul className="navbar-nav pt-lg-3">

                        {
                            menuGroups.map((group, index) => (

                                <div
                                    key={index}
                                    className="w-100"
                                >

                                    {
                                        group.title && (!collapsed || window.innerWidth < 992) &&

                                        <li className="nav-item mt-3">

                                            <span className="nav-link disabled">

                                                {group.title}

                                            </span>

                                        </li>

                                    }

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

                                                            if (window.innerWidth < 992) {

                                                                closeMobileSidebar();

                                                            }

                                                        }}

                                                        className={({ isActive }) =>

                                                            isActive

                                                                ? "nav-link active"

                                                                : "nav-link"

                                                        }

                                                    >

                                                        <span className="nav-link-icon">

                                                            <Icon size={20} />

                                                        </span>

                                                        {
                                                            (!collapsed || window.innerWidth < 992) &&
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



                {/* Logout */}

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
                            (!collapsed || window.innerWidth < 992) && "Logout"
                        }

                    </button>

                </div>

            </div>

        </aside>

    );

}