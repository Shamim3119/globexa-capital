import {
    IconUser,
    IconLock,
    IconLogout,
    IconSettings,
} from "@tabler/icons-react";

import { Link } from "react-router-dom";

import { useAuth } from "../../context/AuthContext";

const IMAGE_URL = import.meta.env.VITE_API_URL.replace("/api", "");

export default function UserDropdown() {

    const { user, logout } = useAuth();

    return (

        <div className="nav-item dropdown">

            <button
                type="button"
                className="btn nav-link d-flex align-items-center"
                data-bs-toggle="dropdown"
            >

                <span className="avatar avatar-sm me-2 bg-primary text-white">

                    {
                        user?.photo
                        ?
                        <img
                            src={`${IMAGE_URL}/storage/${user.photo}`}
                            alt={user.name}
                            className="avatar-img"
                        />
                        :
                        user?.name?.charAt(0).toUpperCase() ?? "U"
                    }

                </span>

                <div className="d-none d-xl-block text-start">

                    <div>

                        {user?.name ?? "User"}

                    </div>

                    <small className="text-secondary">

                        ID : {user?.id ?? "-"}

                    </small>

                </div>

            </button>

            <div className="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

                <div className="dropdown-header">

                    Account

                </div>

                <Link
                    to="/profile"
                    className="dropdown-item"
                >

                    <IconUser
                        size={18}
                        className="me-2"
                    />

                    Profile

                </Link>

 

 

                <div className="dropdown-divider"></div>

                <button
                    className="dropdown-item text-danger"
                    onClick={logout}
                >

                    <IconLogout
                        size={18}
                        className="me-2"
                    />

                    Logout

                </button>

            </div>

        </div>

    );

}